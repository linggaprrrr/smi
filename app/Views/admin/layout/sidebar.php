<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
    <div class="sidebar-brand-icon">
        <i class="fas fa-store"></i>
    </div>
    <div class="sidebar-brand-text mx-2">Administrator</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="<?= base_url('/admin/dashboard') ?>">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Data
</div>
<!-- <li class="nav-item">
    <a class="nav-link" href="<?= base_url('/admin/produk') ?>">
        <i class="fas fa-fw fa-tshirt"></i>
        <span>Produk</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="<?= base_url('/admin/material') ?>">
        <i class="fas fa-fw fa-boxes"></i>
        <span>Kain</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="<?= base_url('/admin/pengiriman') ?>">
        <i class="fas fa-fw fa-shipping-fast"></i>
        <span>Pengiriman</span></a>
</li> -->
<!-- <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
        aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-fw fa-print"></i>
        <span>QR Generator</span>
    </a>
    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?= base_url('/admin/qr-generator-kain') ?>">Kain</a>
            <a class="collapse-item" href="<?= base_url('/admin/qr-generator-produk-masuk') ?>">Produk</a>
        </div>
    </div>
</li> -->
<!-- <li class="nav-item">
    <a class="nav-link" href="<?= base_url('/admin/qr-generator') ?>">
        <i class="fas fa-fw fa-print"></i>
        <span>QR Generator</span></a>
</li> -->
<!-- <li class="nav-item">
    <a class="nav-link" href="<?= base_url('/admin/qr-scanner') ?>">
        <i class="fas fa-fw fa-qrcode"></i>
        <span>QR Scanner</span></a>
</li> -->
<li class="nav-item">
    <a class="nav-link" href="<?= base_url('/admin/user') ?>">
        <i class="fas fa-fw fa-user-alt"></i>
        <span>User</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="<?= base_url('/admin/datamaster') ?>">
        <i class="fas fa-fw fa-database"></i>
        <span>Data Master</span></a>
</li>


<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Report
</div>

<!-- Nav Item - Charts -->
<li class="nav-item">
    <a class="nav-link" href="<?= base_url('/admin/laporan') ?>">
        <i class="fas fa-fw fa-chart-area"></i>
        <span>Laporan</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="<?= base_url('/admin/logs') ?>">
        <i class="fas fa-fw fa-history"></i>
        <span>Log</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="<?= base_url('/download-db') ?>">
        <i class="fas fa-fw fa-database"></i>
        <span>Download Database</span></a>
</li>

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>



</ul>
<!-- End of Sidebar -->