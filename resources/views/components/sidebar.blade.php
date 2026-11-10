  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link {{ request()->is('/') ? '' : 'collapsed' }}" href="{{ url('/') }}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-heading">Master Data</li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('items.*', 'indexItems', 'createItems') ? '' : 'collapsed' }}" data-bs-target="#items-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-box-seam"></i><span>Data Items</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="items-nav" class="nav-content collapse {{ request()->routeIs('items.*', 'indexItems', 'createItems') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('items.index') }}" class="{{ request()->routeIs('items.index', 'items.show') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Daftar Barang</span>
            </a>
          </li>
          <li>
            <a href="{{ route('items.create') }}" class="{{ request()->routeIs('items.create') ? 'active' : '' }}">
              <i class="bi bi-circle"></i><span>Tambah Barang</span>
            </a>
          </li>
        </ul>
      </li><!-- End Items Nav -->

      <li class="nav-heading">Transaksi Logistik</li>

      <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('stock-movements.*') ? '' : 'collapsed' }}" href="{{ route('stock-movements.index') }}">
          <i class="bi bi-arrow-left-right"></i>
          <span>Riwayat Mutasi Stok</span>
        </a>
      </li>

      <li class="nav-heading">Pengaturan & Akun</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#">
          <i class="bi bi-person"></i>
          <span>Profil Pengguna</span>
        </a>
      </li><!-- End Profile Nav -->

    </ul>

  </aside><!-- End Sidebar-->
