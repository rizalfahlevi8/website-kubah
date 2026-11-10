@extends('components.main')

@section('title', 'Detail & Riwayat Mutasi: ' . $item->nama)

@section('content')
<div 
    x-data="{
        mutationModalOpen: false,
        mutationMode: 'masuk',
        mutationJumlah: 1,
        mutationTanggal: '{{ date('Y-m-d') }}',
        mutationKeterangan: '',
        stockAvailable: {{ $item->stock }},
        openModal(mode) {
            this.mutationMode = mode;
            this.mutationJumlah = 1;
            this.mutationKeterangan = '';
            this.mutationModalOpen = true;
        }
    }"
>
    <div class="pagetitle d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1>Detail & Riwayat Mutasi Barang</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('items.index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('items.index') }}">Data Barang</a></li>
                    <li class="breadcrumb-item active">{{ $item->kode }}</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('items.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
            </a>
            <button 
                type="button" 
                class="btn btn-success fw-semibold shadow-sm"
                @click="openModal('masuk')"
            >
                <i class="bi bi-box-arrow-in-down me-1"></i> + Catat Masuk
            </button>
            <button 
                type="button" 
                class="btn btn-danger fw-semibold shadow-sm"
                @click="openModal('keluar')"
            >
                <i class="bi bi-box-arrow-up me-1"></i> - Catat Keluar
            </button>
        </div>
    </div>

    {{-- Flash Notifications --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5 align-middle"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-5 align-middle"></i>
            <strong>Gagal:</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <section class="section">
        <!-- Item Overview Cards -->
        <div class="row mb-4">
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <span class="badge bg-primary font-monospace fs-6 px-3 py-1">
                                {{ $item->kode }}
                            </span>
                            <span class="badge bg-secondary-subtle text-secondary px-2 py-1">
                                Satuan: {{ $item->satuan }}
                            </span>
                        </div>
                        <h4 class="card-title p-0 m-0 fw-bold mb-2 text-dark">{{ $item->nama }}</h4>
                        <div class="text-muted small">Material Fabrikasi Kubah Masjid</div>

                        <div class="border-top pt-3 mt-3">
                            <div class="d-flex justify-content-between py-1">
                                <span class="text-muted">Terdaftar Pada:</span>
                                <span class="fw-semibold">{{ $item->created_at->format('d M Y H:i') }}</span>
                            </div>
                            <div class="d-flex justify-content-between py-1">
                                <span class="text-muted">Total Frekuensi Mutasi:</span>
                                <span class="fw-semibold">{{ $movements->total() }} kali</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kartu Stok Saat Ini -->
            <div class="col-lg-8">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0 border-start border-4 border-primary h-100">
                            <div class="card-body p-4">
                                <div class="text-muted small text-uppercase fw-bold mb-1">Stok Saat Ini</div>
                                <div class="fs-2 fw-bold text-dark">
                                    {{ number_format($item->stock) }}
                                </div>
                                <span class="text-muted small">{{ $item->satuan }} fisik di gudang</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow-sm border-0 border-start border-4 border-success h-100">
                            <div class="card-body p-4">
                                <div class="text-muted small text-uppercase fw-bold mb-1">Akumulasi Masuk</div>
                                <div class="fs-2 fw-bold text-success">
                                    +{{ number_format($totalMasuk) }}
                                </div>
                                <span class="text-muted small">{{ $item->satuan }} total penerimaan</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow-sm border-0 border-start border-4 border-danger h-100">
                            <div class="card-body p-4">
                                <div class="text-muted small text-uppercase fw-bold mb-1">Akumulasi Keluar</div>
                                <div class="fs-2 fw-bold text-danger">
                                    -{{ number_format($totalKeluar) }}
                                </div>
                                <span class="text-muted small">{{ $item->satuan }} untuk proyek masjid</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Riwayat Mutasi Barang -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-clock-history text-primary fs-5"></i>
                    <h5 class="card-title p-0 m-0 fw-bold fs-6">Log Riwayat Mutasi Barang: {{ $item->nama }}</h5>
                </div>
                <span class="badge bg-secondary-subtle text-secondary">
                    Total {{ $movements->total() }} Transaksi
                </span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 50px;">No</th>
                                <th style="width: 130px;">Tanggal</th>
                                <th style="width: 140px;">Jenis Mutasi</th>
                                <th style="width: 150px;">Jumlah</th>
                                <th>Keterangan / Proyek / Supplier</th>
                                <th style="width: 160px;">Waktu Input</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($movements as $idx => $mov)
                                <tr>
                                    <td class="text-center text-muted fw-semibold">
                                        {{ $movements->firstItem() + $idx }}
                                    </td>
                                    <td>
                                        <i class="bi bi-calendar3 text-muted me-1"></i>
                                        <span class="fw-semibold">{{ \Carbon\Carbon::parse($mov->tanggal)->format('d/m/Y') }}</span>
                                    </td>
                                    <td>
                                        @if($mov->jenis === 'masuk')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1">
                                                <i class="bi bi-box-arrow-in-down me-1"></i> BARANG MASUK
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1">
                                                <i class="bi bi-box-arrow-up me-1"></i> BARANG KELUAR
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="fs-6 fw-bold {{ $mov->jenis === 'masuk' ? 'text-success' : 'text-danger' }}">
                                            {{ $mov->jenis === 'masuk' ? '+' : '-' }}{{ number_format($mov->jumlah) }} {{ $item->satuan }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-dark">{{ $mov->keterangan }}</span>
                                    </td>
                                    <td class="text-muted small">
                                        {{ $mov->created_at->format('d/m/Y H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-clock-history fs-1 d-block mb-2"></i>
                                        Belum ada catatan mutasi stok untuk barang ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($movements->hasPages())
                <div class="card-footer bg-white py-3 border-top d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        Menampilkan {{ $movements->firstItem() }} sampai {{ $movements->lastItem() }} dari {{ $movements->total() }} mutasi
                    </small>
                    {{ $movements->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </section>

    <!-- Modal Mutasi Cepat Khusus Barang Ini (Alpine.js) -->
    <div 
        x-cloak 
        x-show="mutationModalOpen" 
        class="position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center"
        style="background: rgba(0,0,0,0.55); z-index: 1050;"
        x-transition:enter="fade"
        x-transition:leave="fade"
        @keydown.escape.window="mutationModalOpen = false"
    >
        <div 
            class="modal-dialog modal-dialog-centered w-100 px-3" 
            style="max-width: 520px;"
            @click.away="mutationModalOpen = false"
        >
            <div class="modal-content shadow-lg border-0 rounded-3 overflow-hidden">
                <div 
                    class="modal-header text-white px-4 py-3"
                    :class="mutationMode === 'masuk' ? 'bg-success' : 'bg-danger'"
                >
                    <div class="d-flex align-items-center gap-2">
                        <i 
                            class="fs-4" 
                            :class="mutationMode === 'masuk' ? 'bi bi-box-arrow-in-down' : 'bi bi-box-arrow-up'"
                        ></i>
                        <h5 class="modal-title fw-bold m-0" x-text="mutationMode === 'masuk' ? 'Catat Barang Masuk' : 'Catat Barang Keluar'"></h5>
                    </div>
                    <button 
                        type="button" 
                        class="btn-close btn-close-white" 
                        @click="mutationModalOpen = false"
                    ></button>
                </div>

                <form action="{{ route('stock-movements.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                    <input type="hidden" name="jenis" :value="mutationMode">

                    <div class="modal-body p-4">
                        <div class="btn-group w-100 mb-3" role="group">
                            <button 
                                type="button" 
                                class="btn py-2 fw-semibold"
                                :class="mutationMode === 'masuk' ? 'btn-success' : 'btn-outline-success'"
                                @click="mutationMode = 'masuk'"
                            >
                                <i class="bi bi-box-arrow-in-down me-1"></i> Masuk
                            </button>
                            <button 
                                type="button" 
                                class="btn py-2 fw-semibold"
                                :class="mutationMode === 'keluar' ? 'btn-danger' : 'btn-outline-danger'"
                                @click="mutationMode = 'keluar'"
                            >
                                <i class="bi bi-box-arrow-up me-1"></i> Keluar
                            </button>
                        </div>

                        <div class="p-3 mb-3 rounded-2 bg-light border d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted d-block">Barang:</small>
                                <strong>{{ $item->nama }}</strong>
                                <span class="badge bg-secondary ms-1">{{ $item->kode }}</span>
                            </div>
                            <div class="text-end">
                                <small class="text-muted d-block">Stok Tersedia:</small>
                                <span class="fs-5 fw-bold text-dark">{{ $item->stock }} {{ $item->satuan }}</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jumlah ({{ $item->satuan }}) <span class="text-danger">*</span></label>
                            <input 
                                type="number" 
                                name="jumlah" 
                                class="form-control" 
                                x-model.number="mutationJumlah"
                                min="1"
                                :max="mutationMode === 'keluar' ? stockAvailable : null"
                                required
                            >
                            <div 
                                x-show="mutationMode === 'keluar' && mutationJumlah > stockAvailable" 
                                class="alert alert-danger py-2 px-3 mt-2 mb-0 small"
                            >
                                <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                Jumlah melebihi stok yang tersedia ({{ $item->stock }} {{ $item->satuan }}). Transaksi akan ditolak!
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Tanggal <span class="text-danger">*</span></label>
                            <input 
                                type="date" 
                                name="tanggal" 
                                class="form-control" 
                                x-model="mutationTanggal"
                                required
                            >
                        </div>

                        <div class="mb-2">
                            <label class="form-label fw-semibold">Keterangan / Keperluan Proyek <span class="text-danger">*</span></label>
                            <textarea 
                                name="keterangan" 
                                class="form-control" 
                                rows="2" 
                                x-model="mutationKeterangan"
                                :placeholder="mutationMode === 'masuk' ? 'Penerimaan supplier / PO' : 'Pengeluaran proyek kubah masjid...'"
                                required
                            ></textarea>
                        </div>
                    </div>

                    <div class="modal-footer bg-light px-4 py-3 d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" @click="mutationModalOpen = false">Batal</button>
                        <button 
                            type="submit" 
                            class="btn fw-semibold px-4"
                            :class="mutationMode === 'masuk' ? 'btn-success' : 'btn-danger'"
                            :disabled="mutationMode === 'keluar' && (mutationJumlah > stockAvailable || stockAvailable <= 0)"
                        >
                            Simpan Mutasi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

