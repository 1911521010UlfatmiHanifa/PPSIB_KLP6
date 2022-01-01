<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <li class="nav-item">
    <a class="nav-link collapsed" href="dashboard.php">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li><!-- End Dashboard Nav -->

  <li class="nav-item">
    <a class="nav-link collapsed" href="user.php">
      <i class="bi bi-person"></i>
      <span>User</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="inventaris.php">
      <i class="bi bi-list"></i>
      <span>Inventaris</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-menu-button-wide"></i><span>Peminjaman Inventaris</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="peminjaman_pengajuan_daftar.php">
          <i class="bi bi-box-arrow-in-right"></i><span>Pengajuan Peminjaman</span>
        </a>
      </li>
      <li>
        <a href="peminjaman_sedang.php">
          <i class="bi bi-box-arrow-in-right"></i><span>Sedang Dipinjam</span>
        </a>
      </li>
      <li>
        <a href="peminjaman_ditolak.php">
          <i class="bi bi-box-arrow-in-right"></i><span>Ditolak</span>
        </a>
      </li>
    </ul>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="peminjaman_cetak.php">
    <i class="bi bi-printer"></i>
      <span>Cetak Data Peminjaman Inventaris</span>
    </a>
  </li>
</ul>

</aside><!-- End Sidebar-->