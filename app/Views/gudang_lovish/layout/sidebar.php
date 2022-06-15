<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-icon">
        <i class="fas fa-store"></i>
    </div>
    <div class="sidebar-brand-text mx-2">Lovish</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="<?= base_url('/gudang-lovish/dashboard') ?>">
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
    <a class="nav-link" href="<?= base_url('/gudang-lovish/produk') ?>">
        <i class="fas fa-fw fa-tshirt"></i>
        <span>Produk</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="<?= base_url('/gudang-lovish/qr-scanner-in') ?>">
        <i class="fas fa-fw fa-qrcode"></i>
        <span>QR Scanner IN</span></a>
</li>
<li class="nav-item">
    <a class="nav-link" href="<?= base_url('/gudang-lovish/qr-scanner-out') ?>">
        <i class="fas fa-fw fa-qrcode"></i>
        <span>QR Scanner OUT</span></a>
</li>


<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>



</ul>
<!-- End of Sidebar -->