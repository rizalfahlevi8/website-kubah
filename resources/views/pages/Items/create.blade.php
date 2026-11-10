@extends('components.main')

@section('title', 'Tambah Barang Baru')

@section('content')
<div class="pagetitle">
    <h1>Tambah Barang Baru</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('items.index') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('items.index') }}">Data Barang</a></li>
            <li class="breadcrumb-item active">Tambah Barang</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            {{-- Flash Alert --}}
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-octagon me-1"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(isset($errors) && $errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <h6 class="fw-bold mb-1"><i class="bi bi-exclamation-triangle me-1"></i> Periksa kembali inputan Anda:</h6>
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
                    <i class="bi bi-plus-circle text-primary fs-5 me-2"></i>
                    <h5 class="card-title m-0 p-0 fs-6 fw-bold">Form Tambah Master Barang Kubah Masjid</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('items.store') }}" method="POST">
                        @csrf

                        <!-- Kode Barang (Wajib & Unik) -->
                        <div class="mb-3">
                            <label for="kode" class="form-label fw-semibold">
                                Kode Barang <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-upc-scan"></i></span>
                                <input 
                                    type="text" 
                                    name="kode" 
                                    id="kode" 
                                    class="form-control @error('kode') is-invalid @enderror" 
                                    placeholder="Contoh: KBH-STR-010, KBH-PNL-009"
                                    value="{{ old('kode') }}" 
                                    required 
                                    autofocus
                                >
                                @error('kode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">Kode barang bersifat unik sebagai identitas unik katalog material kubah.</small>
                        </div>

                        <!-- Nama Barang (Wajib) -->
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-semibold">
                                Nama Barang / Material <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-box-seam"></i></span>
                                <input 
                                    type="text" 
                                    name="nama" 
                                    id="nama" 
                                    class="form-control @error('nama') is-invalid @enderror" 
                                    placeholder="Contoh: Pipa Galvanis Medium B 3.0 Inch (6m)"
                                    value="{{ old('nama') }}" 
                                    required
                                >
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Satuan (Wajib) -->
                        <div class="mb-3" x-data="{ satuan: '{{ old('satuan', '') }}' }">
                            <label for="satuan" class="form-label fw-semibold">
                                Satuan Barang <span class="text-danger">*</span>
                            </label>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-light"><i class="bi bi-rulers"></i></span>
                                <input 
                                    type="text" 
                                    name="satuan" 
                                    id="satuan" 
                                    x-model="satuan"
                                    class="form-control @error('satuan') is-invalid @enderror" 
                                    placeholder="Contoh: Batang, Lembar, Pcs, Roll, Box, Set, Pail"
                                    value="{{ old('satuan') }}" 
                                    required
                                >
                                @error('satuan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Pilihan Cepat Satuan -->
                            <div class="d-flex flex-wrap gap-1 align-items-center">
                                <small class="text-muted me-1">Pilihan Cepat:</small>
                                @foreach(['Batang', 'Lembar', 'Pcs', 'Roll', 'Box', 'Dus', 'Set', 'Meter', 'Pail', 'Kaleng', 'Tube', 'Jerigen'] as $sat)
                                    <button 
                                        type="button" 
                                        class="btn btn-xs btn-outline-secondary py-0 px-2 rounded-pill"
                                        style="font-size: 0.75rem;"
                                        @click="satuan = '{{ $sat }}'"
                                    >
                                        {{ $sat }}
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        <!-- Stok Awal (Opsional) -->
                        <div class="mb-4">
                            <label for="stock" class="form-label fw-semibold">
                                Stok Awal (Opsional)
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-layers"></i></span>
                                <input 
                                    type="number" 
                                    name="stock" 
                                    id="stock" 
                                    class="form-control @error('stock') is-invalid @enderror" 
                                    placeholder="0"
                                    value="{{ old('stock', 0) }}" 
                                    min="0"
                                >
                                @error('stock')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted">Bila diisi lebih dari 0, sistem akan otomatis mencatat mutasi masuk awal.</small>
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-2 border-top">
                            <a href="{{ route('items.index') }}" class="btn btn-light px-4">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary px-4 fw-semibold">
                                <i class="bi bi-check-circle me-1"></i> Simpan Barang
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
