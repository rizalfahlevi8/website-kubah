<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\stock_movements;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemsController extends Controller
{
    /**
     * Display a listing of items with optional search & pagination.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Items::withCount('stockMovements')
            ->with(['stockMovements' => function ($q) {
                $q->latest('tanggal')->latest('id')->take(5);
            }]);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('kode', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('satuan', 'like', "%{$search}%");
            });
        }

        $items = $query->orderBy('nama', 'asc')->paginate(10)->withQueryString();

        // Data map per item beserta mutasi untuk Alpine.js modal
        $itemsMap = $items->getCollection()->mapWithKeys(function ($item) {
            return [
                $item->id => [
                    'id' => $item->id,
                    'kode' => $item->kode,
                    'nama' => $item->nama,
                    'satuan' => $item->satuan,
                    'stock' => $item->stock,
                    'movements' => $item->stockMovements->map(function ($m) use ($item) {
                        return [
                            'id' => $m->id,
                            'tanggal' => \Carbon\Carbon::parse($m->tanggal)->format('d/m/Y'),
                            'jenis' => $m->jenis,
                            'jumlah' => $m->jumlah,
                            'keterangan' => $m->keterangan,
                            'satuan' => $item->satuan,
                        ];
                    })->values()->all(),
                ],
            ];
        });

        // Semua item untuk modal dropdown transaksi cepat
        $allItems = Items::select('id', 'kode', 'nama', 'satuan', 'stock')
            ->orderBy('nama', 'asc')
            ->get();

        return view('pages.Items.index', compact('items', 'allItems', 'itemsMap', 'search'));
    }

    /**
     * Show the form for creating a new item.
     */
    public function create()
    {
        return view('pages.Items.create');
    }

    /**
     * Store a newly created item with validation (kode required & unique, nama, satuan).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => ['required', 'string', 'max:50', 'unique:items,kode'],
            'nama' => ['required', 'string', 'max:255'],
            'satuan' => ['required', 'string', 'max:50'],
            'stock' => ['nullable', 'integer', 'min:0'],
        ], [
            'kode.required' => 'Kode barang wajib diisi.',
            'kode.unique' => 'Kode barang sudah digunakan, gunakan kode unik lainnya.',
            'nama.required' => 'Nama barang wajib diisi.',
            'satuan.required' => 'Satuan barang wajib diisi (misal: Batang, Lembar, Pcs, Box).',
            'stock.min' => 'Stok awal tidak boleh bernilai negatif.',
        ]);

        $initialStock = $request->filled('stock') ? (int) $request->stock : 0;

        DB::beginTransaction();
        try {
            $item = Items::create([
                'kode' => strtoupper(trim($validated['kode'])),
                'nama' => trim($validated['nama']),
                'satuan' => trim($validated['satuan']),
                'stock' => $initialStock,
            ]);

            // Jika ada stok awal > 0, catat sebagai mutasi masuk awal
            if ($initialStock > 0) {
                stock_movements::create([
                    'item_id' => $item->id,
                    'jenis' => 'masuk',
                    'jumlah' => $initialStock,
                    'keterangan' => 'Stok awal saat pendaftaran barang baru',
                    'tanggal' => now()->toDateString(),
                ]);
            }

            DB::commit();

            return redirect()
                ->route('items.index')
                ->with('success', "Barang [{$item->kode}] {$item->nama} berhasil ditambahkan!");
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan barang: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified item with its complete stock movement history.
     */
    public function show(Items $item)
    {
        $movements = $item->stockMovements()
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(15);

        $totalMasuk = $item->stockMovements()->where('jenis', 'masuk')->sum('jumlah');
        $totalKeluar = $item->stockMovements()->where('jenis', 'keluar')->sum('jumlah');

        return view('pages.Items.show', compact('item', 'movements', 'totalMasuk', 'totalKeluar'));
    }
}
