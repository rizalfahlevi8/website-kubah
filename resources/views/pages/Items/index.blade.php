@extends('components.main')

@section('title', 'Daftar Barang & Inventaris Kubah')

@section('content')
<script>
    // Helper global untuk memastikan modal 100% bisa ditutup dalam kondisi apapun
    window.closeModalDirectly = function() {
        var modal = document.getElementById('mutationModal');
        if (modal) {
            modal.style.display = 'none';
        }
    };
</script>

<div 
    x-data="{
        // Master Data Barang
        allItems: {{ Js::from($allItems) }},

        // State Modal Mutasi (Satu-satunya modal agar tidak bertabrakan)
        modalOpen: false,
        mutationMode: 'masuk', // 'masuk' | 'keluar'
        selectedItemId: '{{ $allItems->first()->id ?? '' }}',
        selectedItemKode: '',
        selectedItemNama: '',
        selectedItemSatuan: '',
        selectedItemStock: 0,
        mutationJumlah: 1,
        mutationTanggal: '{{ date('Y-m-d') }}',
        mutationKeterangan: '',

        // State Riwayat Inline (Accordion di baris tabel yang sama)
        expandedHistoryId: null,

        init() {
            this.updateSelectedItem();
        },

        // Buka Modal Mutasi
        openModal(mode, itemId = null) {
            this.mutationMode = mode;
            if (itemId) {
                this.selectedItemId = itemId;
            }
            this.updateSelectedItem();
            this.mutationJumlah = 1;
            this.mutationKeterangan = '';
            this.modalOpen = true;
            
            var modalEl = document.getElementById('mutationModal');
            if (modalEl) {
                modalEl.style.display = 'flex';
            }
        },

        // Tutup Modal Mutasi
        closeModal() {
            this.modalOpen = false;
            window.closeModalDirectly();
        },

        // Sinkronisasi data barang terpilih
        updateSelectedItem() {
            const found = this.allItems.find(i => i.id == this.selectedItemId);
            if (found) {
                this.selectedItemKode = found.kode;
                this.selectedItemNama = found.nama;
                this.selectedItemSatuan = found.satuan;
                this.selectedItemStock = found.stock;
            }
        },

        // Toggle Buka/Tutup Riwayat di baris tabel yang sama
        toggleHistory(itemId) {
            if (this.expandedHistoryId === itemId) {
                this.expandedHistoryId = null;
            } else {
                this.expandedHistoryId = itemId;
            }
        }
    }"
    @keydown.escape.window="closeModal()"
>
    <!-- Header Halaman & Tombol Aksi -->
    <div class="pagetitle d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1>Daftar Barang & Material Kubah Masjid</h1>
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('items.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Daftar Barang</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
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
            <a href="{{ route('items.create') }}" class="btn btn-primary fw-semibold shadow-sm">
                <i class="bi bi-plus-lg me-1"></i> Tambah Barang
            </a>
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
            <h6 class="fw-bold mb-1"><i class="bi bi-exclamation-octagon me-1"></i> Periksa Kesalahan Input:</h6>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tabel Daftar Barang -->
    <section class="section">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary fs-6 px-3 py-2 rounded-pill">
                        Total: {{ $items->total() }} Barang
                    </span>
                    <span class="text-muted small">Katalog Pabrikasi Kubah Enamel & Galvalum</span>
                </div>

                <!-- Form Pencarian -->
                <form action="{{ route('items.index') }}" method="GET" class="d-flex gap-2">
                    <div class="input-group">
                        <input 
                            type="text" 
                            name="search" 
                            class="form-control form-control-sm" 
                            placeholder="Cari kode, nama, atau satuan..."
                            value="{{ request('search') }}"
                        >
                        @if(request('search'))
                            <a href="{{ route('items.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        @endif
                        <button class="btn btn-sm btn-primary" type="submit">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </div>
                </form>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 50px;">No</th>
                                <th style="width: 140px;">Kode</th>
                                <th>Nama Barang / Material</th>
                                <th style="width: 100px;">Satuan</th>
                                <th class="text-center" style="width: 140px;">Stok Saat Ini</th>
                                <th>Mutasi Terakhir</th>
                                <th class="text-center" style="width: 250px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $index => $item)
                                <tr>
                                    <td class="text-center text-muted fw-semibold">
                                        {{ $items->firstItem() + $index }}
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border font-monospace px-2 py-1">
                                            {{ $item->kode }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('items.show', $item->id) }}" class="fw-bold text-dark text-decoration-none">
                                            {{ $item->nama }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary px-2 py-1">
                                            {{ $item->satuan }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if($item->stock <= 0)
                                            <span class="badge bg-danger fs-6 px-3 py-1 rounded-pill">
                                                0 {{ $item->satuan }}
                                            </span>
                                            <div class="text-danger small mt-1"><i class="bi bi-x-circle"></i> Stok Habis</div>
                                        @elseif($item->stock <= 10)
                                            <span class="badge bg-warning text-dark fs-6 px-3 py-1 rounded-pill">
                                                {{ number_format($item->stock) }} {{ $item->satuan }}
                                            </span>
                                            <div class="text-warning small mt-1"><i class="bi bi-exclamation-circle"></i> Stok Menipis</div>
                                        @else
                                            <span class="badge bg-success fs-6 px-3 py-1 rounded-pill">
                                                {{ number_format($item->stock) }} {{ $item->satuan }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $lastMovement = $item->stockMovements->first();
                                        @endphp
                                        @if($lastMovement)
                                            <div class="small">
                                                @if($lastMovement->jenis === 'masuk')
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle">
                                                        <i class="bi bi-arrow-down-left"></i> +{{ $lastMovement->jumlah }} {{ $item->satuan }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">
                                                        <i class="bi bi-arrow-up-right"></i> -{{ $lastMovement->jumlah }} {{ $item->satuan }}
                                                    </span>
                                                @endif
                                                <span class="text-muted ms-1" style="font-size: 0.75rem;">
                                                    {{ \Carbon\Carbon::parse($lastMovement->tanggal)->format('d/m/Y') }}
                                                </span>
                                            </div>
                                            <div class="text-muted text-truncate" style="max-width: 200px; font-size: 0.75rem;" title="{{ $lastMovement->keterangan }}">
                                                {{ $lastMovement->keterangan }}
                                            </div>
                                        @else
                                            <span class="text-muted small fst-italic">Belum ada mutasi</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <!-- Tombol Catat Masuk -->
                                            <button 
                                                type="button" 
                                                class="btn btn-outline-success" 
                                                title="Catat Barang Masuk"
                                                @click="openModal('masuk', {{ $item->id }})"
                                            >
                                                <i class="bi bi-plus-circle"></i> Masuk
                                            </button>

                                            <!-- Tombol Catat Keluar -->
                                            <button 
                                                type="button" 
                                                class="btn btn-outline-danger" 
                                                title="Catat Barang Keluar"
                                                @click="openModal('keluar', {{ $item->id }})"
                                            >
                                                <i class="bi bi-dash-circle"></i> Keluar
                                            </button>

                                            <!-- Tombol Toggle Riwayat Inline di Halaman Yang Sama -->
                                            <button 
                                                type="button" 
                                                class="btn"
                                                :class="expandedHistoryId === {{ $item->id }} ? 'btn-info text-white' : 'btn-outline-info'"
                                                title="Lihat Riwayat Mutasi Barang Ini"
                                                @click="toggleHistory({{ $item->id }})"
                                            >
                                                <i class="bi bi-clock-history"></i> Riwayat
                                            </button>

                                            <!-- Tombol Detail Lengkap -->
                                            <a 
                                                href="{{ route('items.show', $item->id) }}" 
                                                class="btn btn-outline-secondary" 
                                                title="Halaman Detail Lengkap"
                                            >
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Baris Expandable Riwayat Mutasi di Halaman Yang Sama (Tanpa Pop-up yang Menutupi Layar) -->
                                <tr x-show="expandedHistoryId === {{ $item->id }}" x-cloak class="bg-light">
                                    <td colspan="7" class="p-3">
                                        <div class="card border border-info shadow-none m-0">
                                            <div class="card-header bg-info-subtle py-2 d-flex justify-content-between align-items-center">
                                                <span class="fw-bold small text-dark">
                                                    <i class="bi bi-clock-history me-1"></i>
                                                    Riwayat Mutasi Terbaru: [{{ $item->kode }}] {{ $item->nama }}
                                                </span>
                                                <div class="d-flex align-items-center gap-2">
                                                    <a href="{{ route('items.show', $item->id) }}" class="btn btn-xs btn-primary py-0 px-2 small" style="font-size: 0.75rem;">
                                                        Buka Halaman Detail <i class="bi bi-arrow-right"></i>
                                                    </a>
                                                    <button type="button" class="btn-close btn-sm" @click="expandedHistoryId = null"></button>
                                                </div>
                                            </div>
                                            <div class="card-body p-0">
                                                @if($item->stockMovements->count() > 0)
                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-bordered mb-0 align-middle">
                                                            <thead class="table-secondary">
                                                                <tr>
                                                                    <th style="width: 100px;">Tanggal</th>
                                                                    <th style="width: 100px;" class="text-center">Jenis</th>
                                                                    <th style="width: 120px;" class="text-end">Jumlah</th>
                                                                    <th>Keterangan / Keperluan Proyek</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($item->stockMovements->take(5) as $mov)
                                                                    <tr>
                                                                        <td class="small">{{ \Carbon\Carbon::parse($mov->tanggal)->format('d/m/Y') }}</td>
                                                                        <td class="text-center">
                                                                            <span class="badge {{ $mov->jenis === 'masuk' ? 'bg-success' : 'bg-danger' }}">
                                                                                {{ strtoupper($mov->jenis) }}
                                                                            </span>
                                                                        </td>
                                                                        <td class="text-end fw-bold {{ $mov->jenis === 'masuk' ? 'text-success' : 'text-danger' }}">
                                                                            {{ $mov->jenis === 'masuk' ? '+' : '-' }}{{ number_format($mov->jumlah) }} {{ $item->satuan }}
                                                                        </td>
                                                                        <td class="small">{{ $mov->keterangan }}</td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @else
                                                    <div class="text-center py-3 text-muted small fst-italic">
                                                        Belum ada catatan mutasi untuk barang ini.
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                        <span class="text-muted">Tidak ada data barang yang ditemukan.</span>
                                        @if(request('search'))
                                            <div class="mt-2">
                                                <a href="{{ route('items.index') }}" class="btn btn-sm btn-outline-primary">
                                                    Reset Pencarian
                                                </a>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if($items->hasPages())
                <div class="card-footer bg-white py-3 border-top d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        Menampilkan {{ $items->firstItem() }} sampai {{ $items->lastItem() }} dari {{ $items->total() }} barang
                    </small>
                    {{ $items->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </section>

    <!-- ======================================================== -->
    <!-- MODAL PENCATATAN BARANG MASUK / KELUAR (SATU-SATUNYA)   -->
    <!-- ======================================================== -->
    <div 
        id="mutationModal"
        x-cloak 
        x-show="modalOpen" 
        style="display: none; background: rgba(0, 0, 0, 0.65); z-index: 1055;"
        class="position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center"
        @click.self="closeModal()"
    >
        <div 
            class="bg-white rounded-3 shadow-lg overflow-hidden w-100 mx-3" 
            style="max-width: 540px;"
            @click.stop
        >
            <!-- Modal Header -->
            <div 
                class="d-flex justify-content-between align-items-center text-white px-4 py-3"
                :class="mutationMode === 'masuk' ? 'bg-success' : 'bg-danger'"
            >
                <div class="d-flex align-items-center gap-2">
                    <i 
                        class="fs-4" 
                        :class="mutationMode === 'masuk' ? 'bi bi-box-arrow-in-down' : 'bi bi-box-arrow-up'"
                    ></i>
                    <h5 class="fw-bold m-0 fs-6" x-text="mutationMode === 'masuk' ? 'Pencatatan Barang Masuk' : 'Pencatatan Barang Keluar'"></h5>
                </div>
                <!-- Tombol X Tutup (Diberi handler Alpine & Vanilla JS) -->
                <button 
                    type="button" 
                    class="btn-close btn-close-white" 
                    @click="closeModal()"
                    onclick="window.closeModalDirectly()"
                    aria-label="Close"
                ></button>
            </div>

            <!-- Form Mutasi -->
            <form action="{{ route('stock-movements.store') }}" method="POST">
                @csrf
                <input type="hidden" name="jenis" :value="mutationMode">

                <div class="p-4">
                    
                    <!-- Pilihan Tab Jenis Mutasi (Masuk / Keluar) -->
                    <div class="btn-group w-100 mb-3" role="group">
                        <button 
                            type="button" 
                            class="btn py-2 fw-semibold"
                            :class="mutationMode === 'masuk' ? 'btn-success' : 'btn-outline-success'"
                            @click="mutationMode = 'masuk'"
                        >
                            <i class="bi bi-box-arrow-in-down me-1"></i> Barang Masuk
                        </button>
                        <button 
                            type="button" 
                            class="btn py-2 fw-semibold"
                            :class="mutationMode === 'keluar' ? 'btn-danger' : 'btn-outline-danger'"
                            @click="mutationMode = 'keluar'"
                        >
                            <i class="bi bi-box-arrow-up me-1"></i> Barang Keluar
                        </button>
                    </div>

                    <!-- Pilih Barang -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Pilih Barang / Material <span class="text-danger">*</span></label>
                        <select 
                            name="item_id" 
                            class="form-select" 
                            x-model="selectedItemId"
                            @change="updateSelectedItem()"
                            required
                        >
                            <template x-for="item in allItems" :key="item.id">
                                <option :value="item.id" x-text="'[' + item.kode + '] ' + item.nama + ' (Stok: ' + item.stock + ' ' + item.satuan + ')'"></option>
                            </template>
                        </select>
                    </div>

                    <!-- Info Stok Saat Ini -->
                    <div 
                        class="p-3 mb-3 rounded-2 border d-flex justify-content-between align-items-center"
                        :class="mutationMode === 'masuk' ? 'bg-success-subtle border-success-subtle' : 'bg-danger-subtle border-danger-subtle'"
                    >
                        <div>
                            <small class="text-muted d-block">Barang Terpilih:</small>
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

                    <!-- Jumlah Mutasi -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Jumlah <span class="text-danger">*</span>
                            <span class="text-muted fw-normal" x-text="'(Satuan: ' + selectedItemSatuan + ')'"></span>
                        </label>
                        <div class="input-group">
                            <input 
                                type="number" 
                                name="jumlah" 
                                class="form-control" 
                                x-model.number="mutationJumlah"
                                min="1"
                                :max="mutationMode === 'keluar' ? selectedItemStock : null"
                                required
                            >
                            <span class="input-group-text bg-light fw-semibold" x-text="selectedItemSatuan"></span>
                        </div>

                        <!-- Peringatan: Barang keluar melebihi stok -->
                        <div 
                            x-show="mutationMode === 'keluar' && mutationJumlah > selectedItemStock" 
                            class="alert alert-danger py-2 px-3 mt-2 mb-0 d-flex align-items-center gap-2 small"
                        >
                            <i class="bi bi-exclamation-octagon-fill fs-6"></i>
                            <span>
                                <strong>Peringatan!</strong> Jumlah barang keluar (<span x-text="mutationJumlah"></span>) melebihi stok tersedia (<span x-text="selectedItemStock"></span>). Sistem akan menolak transaksi ini!
                            </span>
                        </div>
                    </div>

                    <!-- Tanggal Mutasi -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tanggal Mutasi <span class="text-danger">*</span></label>
                        <input 
                            type="date" 
                            name="tanggal" 
                            class="form-control" 
                            x-model="mutationTanggal"
                            required
                        >
                    </div>

                    <!-- Keterangan Transaksi -->
                    <div class="mb-2">
                        <label class="form-label fw-semibold">
                            Keterangan Transaksi / Keperluan <span class="text-danger">*</span>
                        </label>
                        <textarea 
                            name="keterangan" 
                            class="form-control" 
                            rows="2" 
                            x-model="mutationKeterangan"
                            :placeholder="mutationMode === 'masuk' ? 'Contoh: Penerimaan bahan pipa dari PT Krakatau Steel / PO-KBH-2026' : 'Contoh: Proyek Kubah Masjid Al-Ikhlas Surabaya (Diameter 8m)'"
                            required
                        ></textarea>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="bg-light px-4 py-3 border-top d-flex justify-content-between">
                    <!-- Tombol Batal (Diberi handler Alpine & Vanilla JS) -->
                    <button 
                        type="button" 
                        class="btn btn-secondary px-4" 
                        @click="closeModal()"
                        onclick="window.closeModalDirectly()"
                    >
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        class="btn fw-semibold px-4"
                        :class="mutationMode === 'masuk' ? 'btn-success' : 'btn-danger'"
                        :disabled="mutationMode === 'keluar' && (mutationJumlah > selectedItemStock || selectedItemStock <= 0)"
                    >
                        <i 
                            class="bi me-1" 
                            :class="mutationMode === 'masuk' ? 'bi-check-circle' : 'bi-arrow-right-circle'"
                        ></i>
                        <span x-text="mutationMode === 'masuk' ? 'Simpan Barang Masuk' : 'Keluarkan Barang'"></span>
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection
