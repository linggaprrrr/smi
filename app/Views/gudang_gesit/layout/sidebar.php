<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-icon">
        <i class="fas fa-store"></i>
    </div>
    <div class="sidebar-brand-text mx-2">Gesit</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="<?= base_url('/gudang-gesit/dashboard') ?>">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Data
</div>
<li class="nav-item">
    <a class="nav-link" href="<?= base_url('/gudang-gesit/produk') ?>">
        <i class="fas fa-fw fa-tshirt"></i>
        <span>Produk</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="<?= base_url('/gudang-gesit/kain') ?>">
        <i class="fas fa-fw fa-boxes"></i>
        <span>Kain</span></a>
</li>
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
        aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-fw fa-print"></i>
        <span>QR Generator</span>
    </a>
    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item" href="<?= base_url('/gudang-gesit/qr-generator-kain') ?>">Kain</a>
            <a class="collapse-item" href="<?= base_url('/gudang-gesit/qr-generator-produk-masuk') ?>">Produk</a>
        </div>
    </div>
</li>
<li class="nav-item">
    <a class="nav-link" href="<?= base_url('/gudang-gesit/qr-scanner-in') ?>">
        <i class="fas fa-fw fa-qrcode"></i>
        <span>QR Scanner IN</span></a>
</li>

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>



</ul>
<!-- End of Sidebar -->