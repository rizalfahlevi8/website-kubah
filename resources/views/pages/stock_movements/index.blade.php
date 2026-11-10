@extends('components.main')

@section('title', 'Riwayat Mutasi Stok')

@section('content')
<div 
    x-data="{
        mutationModalOpen: false,
        mutationMode: 'masuk',
        selectedItemId: '{{ $items->first()->id ?? '' }}',
        selectedItemKode: '',
        selectedItemNama: '',
        selectedItemSatuan: '',
        selectedItemStock: 0,
        mutationJumlah: 1,
        mutationTanggal: '{{ date('Y-m-d') }}',
        mutationKeterangan: '',

        openMutationModal(mode) {
            this.mutationMode = mode;
            this.updateSelectedItemFromId();
            this.mutationJumlah = 1;
            this.mutationKeterangan = '';
            this.mutationModalOpen = true;
        },

        updateSelectedItemFromId() {
            const items = {{ Js::from($items) }};
            const found = items.find(i => i.id == this.selectedItemId);
            if (found) {
                this.selectedItemKode = found.kode;
                this.selectedItemNama = found.nama;
                this.selectedItemSatuan = found.satuan;
                this.selectedItemStock = found.stock;
            }
        }
    }"
    x-init="updateSelectedItemFromId()"
>
    <div class="pagetitle d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1>Riwayat Mutasi Stok Gudang</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('items.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Riwayat Mutasi Stok</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <button 
                type="button" 
                class="btn btn-success fw-semibold shadow-sm"
                @click="openMutationModal('masuk')"
            >
                <i class="bi bi-box-arrow-in-down me-1"></i> + Catat Masuk
            </button>
            <button 
                type="button" 
                class="btn btn-danger fw-semibold shadow-sm"
                @click="openMutationModal('keluar')"
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

    @if(isset($errors) && $errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <h6 class="fw-bold mb-1"><i class="bi bi-exclamation-octagon me-1"></i> Terdapat Kesalahan Input:</h6>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <section class="section">
        <!-- Summary Widgets -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 border-start border-4 border-primary">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small text-uppercase fw-bold">Total Transaksi</span>
                            <div class="fs-3 fw-bold text-dark">{{ number_format($movements->total()) }}</div>
                        </div>
                        <i class="bi bi-arrow-left-right fs-1 text-primary opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 border-start border-4 border-success">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small text-uppercase fw-bold">Barang Masuk</span>
                            <div class="fs-3 fw-bold text-success">{{ number_format($totalMasukCount) }}</div>
                        </div>
                        <i class="bi bi-box-arrow-in-down fs-1 text-success opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 border-start border-4 border-danger">
                    <div class="card-body p-3 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small text-uppercase fw-bold">Barang Keluar (Proyek)</span>
                            <div class="fs-3 fw-bold text-danger">{{ number_format($totalKeluarCount) }}</div>
                        </div>
                        <i class="bi bi-box-arrow-up fs-1 text-danger opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-3">
                <form action="{{ route('stock-movements.index') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-3">
                        <select name="jenis" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">-- Semua Jenis Mutasi --</option>
                            <option value="masuk" {{ request('jenis') === 'masuk' ? 'selected' : '' }}>Barang Masuk (Hijau)</option>
                            <option value="keluar" {{ request('jenis') === 'keluar' ? 'selected' : '' }}>Barang Keluar (Merah)</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="item_id" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">-- Semua Barang / Material --</option>
                            @foreach($items as $it)
                                <option value="{{ $it->id }}" {{ request('item_id') == $it->id ? 'selected' : '' }}>
                                    [{{ $it->kode }}] {{ $it->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group input-group-sm">
                            <input 
                                type="text" 
                                name="search" 
                                class="form-control" 
                                placeholder="Cari keterangan / proyek..." 
                                value="{{ request('search') }}"
                            >
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-1 text-end">
                        <a href="{{ route('stock-movements.index') }}" class="btn btn-sm btn-outline-secondary w-100" title="Reset Filter">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabel Log Mutasi -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 50px;">No</th>
                                <th style="width: 120px;">Tanggal</th>
                                <th style="width: 130px;">Kode</th>
                                <th>Nama Barang / Material</th>
                                <th style="width: 130px;" class="text-center">Jenis Mutasi</th>
                                <th style="width: 140px;" class="text-end">Jumlah</th>
                                <th>Keterangan / Keperluan Proyek</th>
                                <th class="text-center" style="width: 80px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($movements as $i => $mov)
                                <tr>
                                    <td class="text-center text-muted fw-semibold">
                                        {{ $movements->firstItem() + $i }}
                                    </td>
                                    <td>
                                        <i class="bi bi-calendar3 text-muted me-1"></i>
                                        <span class="small fw-semibold">{{ \Carbon\Carbon::parse($mov->tanggal)->format('d/m/Y') }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border font-monospace">
                                            {{ $mov->item->kode ?? '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($mov->item)
                                            <a href="{{ route('items.show', $mov->item_id) }}" class="fw-bold text-dark text-decoration-none hover-primary">
                                                {{ $mov->item->nama }}
                                            </a>
                                        @else
                                            <span class="text-muted fst-italic">[Barang Dihapus]</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($mov->jenis === 'masuk')
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                                <i class="bi bi-box-arrow-in-down"></i> MASUK
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">
                                                <i class="bi bi-box-arrow-up"></i> KELUAR
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <span class="fs-6 fw-bold {{ $mov->jenis === 'masuk' ? 'text-success' : 'text-danger' }}">
                                            {{ $mov->jenis === 'masuk' ? '+' : '-' }}{{ number_format($mov->jumlah) }} 
                                            <small class="fw-normal">{{ $mov->item->satuan ?? '' }}</small>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-dark">{{ $mov->keterangan }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($mov->item)
                                            <a 
                                                href="{{ route('items.show', $mov->item_id) }}" 
                                                class="btn btn-sm btn-outline-primary py-0 px-2"
                                                title="Lihat Detail Barang"
                                            >
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        Tidak ada catatan mutasi yang cocok dengan filter.
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

    <!-- Modal Mutasi (Alpine.js) -->
    <div 
        x-cloak 
        x-show="mutationModalOpen" 
        class="position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center"
        style="background: rgba(0, 0, 0, 0.65); z-index: 99999;"
        @keydown.escape.window="mutationModalOpen = false"
    >
        <div 
            class="bg-white rounded-3 shadow-lg overflow-hidden w-100 mx-3" 
            style="max-width: 540px;"
            @click.away="mutationModalOpen = false"
        >
            <div 
                class="d-flex justify-content-between align-items-center text-white px-4 py-3"
                :class="mutationMode === 'masuk' ? 'bg-success' : 'bg-danger'"
            >
                <div class="d-flex align-items-center gap-2">
                    <i 
                        class="fs-4" 
                        :class="mutationMode === 'masuk' ? 'bi bi-box-arrow-in-down' : 'bi bi-box-arrow-up'"
                    ></i>
                    <h5 class="fw-bold m-0 fs-6" x-text="mutationMode === 'masuk' ? 'Catat Barang Masuk' : 'Catat Barang Keluar'"></h5>
                </div>
                <button 
                    type="button" 
                    class="btn btn-sm btn-link text-white text-decoration-none fs-5 p-0 lh-1" 
                    @click="mutationModalOpen = false"
                >&times;</button>
            </div>

            <form action="{{ route('stock-movements.store') }}" method="POST">
                @csrf
                <input type="hidden" name="jenis" :value="mutationMode">

                <div class="p-4">
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

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Barang <span class="text-danger">*</span></label>
                        <select 
                            name="item_id" 
                            class="form-select" 
                            x-model="selectedItemId"
                            @change="updateSelectedItemFromId()"
                            required
                        >
                            @foreach($items as $b)
                                <option value="{{ $b->id }}">
                                    [{{ $b->kode }}] {{ $b->nama }} (Stok: {{ $b->stock }} {{ $b->satuan }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="p-3 mb-3 rounded-2 border d-flex justify-content-between align-items-center"
                         :class="mutationMode === 'masuk' ? 'bg-success-subtle border-success-subtle' : 'bg-danger-subtle border-danger-subtle'">
                        <div>
                            <small class="text-muted d-block">Barang:</small>
                            <strong x-text="selectedItemNama"></strong>
                            <span class="badge bg-secondary ms-1" x-text="selectedItemKode"></span>
                        </div>
                        <div class="text-end">
                            <small class="text-muted d-block">Stok Tersedia:</small>
                            <span class="fs-5 fw-bold" :class="selectedItemStock <= 0 ? 'text-danger' : 'text-dark'">
                                <span x-text="selectedItemStock"></span> <span x-text="selectedItemSatuan"></span>
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jumlah (<span x-text="selectedItemSatuan"></span>) <span class="text-danger">*</span></label>
                        <input 
                            type="number" 
                            name="jumlah" 
                            class="form-control" 
                            x-model.number="mutationJumlah"
                            min="1"
                            :max="mutationMode === 'keluar' ? selectedItemStock : null"
                            required
                        >
                        <div 
                            x-show="mutationMode === 'keluar' && mutationJumlah > selectedItemStock" 
                            class="alert alert-danger py-2 px-3 mt-2 mb-0 small"
                        >
                            <i class="bi bi-exclamation-triangle-fill me-1"></i>
                            Jumlah melebihi stok yang tersedia. Transaksi akan ditolak!
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
                        <label class="form-label fw-semibold">Keterangan Transaksi <span class="text-danger">*</span></label>
                        <textarea 
                            name="keterangan" 
                            class="form-control" 
                            rows="2" 
                            x-model="mutationKeterangan"
                            placeholder="Keperluan mutasi, nomor PO supplier, atau nama proyek kubah masjid..."
                            required
                        ></textarea>
                    </div>
                </div>

                <div class="bg-light px-4 py-3 border-top d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" @click="mutationModalOpen = false">Batal</button>
                    <button 
                        type="submit" 
                        class="btn fw-semibold px-4"
                        :class="mutationMode === 'masuk' ? 'btn-success' : 'btn-danger'"
                        :disabled="mutationMode === 'keluar' && (mutationJumlah > selectedItemStock || selectedItemStock <= 0)"
                    >
                        Simpan Mutasi
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
