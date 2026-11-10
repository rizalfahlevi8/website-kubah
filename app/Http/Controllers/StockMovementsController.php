<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\stock_movements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockMovementsController extends Controller
{
    /**
     * Display a listing of all stock movements with filters.
     */
    public function index(Request $request)
    {
        $jenis = $request->input('jenis');
        $itemId = $request->input('item_id');
        $search = $request->input('search');

        $query = stock_movements::with('item')
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc');

        if ($jenis && in_array($jenis, ['masuk', 'keluar'])) {
            $query->where('jenis', $jenis);
        }

        if ($itemId) {
            $query->where('item_id', $itemId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('keterangan', 'like', "%{$search}%")
                  ->orWhereHas('item', function ($iq) use ($search) {
                      $iq->where('nama', 'like', "%{$search}%")
                         ->orWhere('kode', 'like', "%{$search}%");
                  });
            });
        }

        $movements = $query->paginate(20)->withQueryString();

        $items = Items::select('id', 'kode', 'nama', 'satuan', 'stock')
            ->orderBy('nama', 'asc')
            ->get();

        $totalMasukCount = stock_movements::where('jenis', 'masuk')->count();
        $totalKeluarCount = stock_movements::where('jenis', 'keluar')->count();

        return view('pages.stock_movements.index', compact(
            'movements',
            'items',
            'jenis',
            'itemId',
            'search',
            'totalMasukCount',
            'totalKeluarCount'
        ));
    }

    /**
     * Store a newly created stock movement with strict stock availability validation.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => ['required', 'exists:items,id'],
            'jenis' => ['required', 'in:masuk,keluar'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'keterangan' => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'date'],
        ], [
            'item_id.required' => 'Pilih barang yang akan dimutasi.',
            'item_id.exists' => 'Barang yang dipilih tidak ditemukan dalam sistem.',
            'jenis.required' => 'Jenis mutasi (masuk/keluar) wajib ditentukan.',
            'jenis.in' => 'Jenis mutasi harus berupa barang masuk atau barang keluar.',
            'jumlah.required' => 'Jumlah barang wajib diisi.',
            'jumlah.min' => 'Jumlah barang mutasi minimal 1.',
            'keterangan.required' => 'Keterangan mutasi (proyek/supplier/keperluan) wajib diisi.',
            'tanggal.required' => 'Tanggal mutasi wajib diisi.',
        ]);

        return DB::transaction(function () use ($validated) {
            $item = Items::lockForUpdate()->findOrFail($validated['item_id']);

            // Validasi: Barang keluar TIDAK BOLEH melebihi stok yang tersedia
            if ($validated['jenis'] === 'keluar') {
                if ($validated['jumlah'] > $item->stock) {
                    return back()
                        ->withInput()
                        ->with('error', "Transaksi Ditolak! Permintaan barang keluar sebanyak {$validated['jumlah']} {$item->satuan} melebihi stok yang tersedia ({$item->stock} {$item->satuan}). Stok tidak berubah.");
                }

                // Kurangi stok
                $item->stock -= $validated['jumlah'];
            } else {
                // Tambah stok untuk barang masuk
                $item->stock += $validated['jumlah'];
            }

            // Simpan perubahan stok barang secara otomatis
            $item->save();

            // Catat log mutasi
            stock_movements::create([
                'item_id' => $item->id,
                'jenis' => $validated['jenis'],
                'jumlah' => $validated['jumlah'],
                'keterangan' => trim($validated['keterangan']),
                'tanggal' => $validated['tanggal'],
            ]);

            $jenisLabel = $validated['jenis'] === 'masuk' ? 'Barang Masuk' : 'Barang Keluar';

            return back()->with(
                'success',
                "Berhasil mencatat {$jenisLabel} sebanyak {$validated['jumlah']} {$item->satuan} untuk [{$item->kode}] {$item->nama}. Sisa stok saat ini: {$item->stock} {$item->satuan}."
            );
        });
    }
}
