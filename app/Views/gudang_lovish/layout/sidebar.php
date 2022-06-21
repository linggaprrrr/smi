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
<?php 
    $access = json_decode(session()->get('accessibility'));
    if (!is_null($access)) {
        for ($i=0; $i < count($access); $i++) {
            switch ($access[$i]) {
                case "1": 
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/gudang-lovish/produk') ?>">
                                <i class="fas fa-fw fa-tshirt"></i>
                                <span>Produk</span></a>
                        </li>
                        <?php
                    break;
                case "2": 
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/gudang-lovish/qr-scanner-in') ?>">
                                <i class="fas fa-fw fa-print"></i>
                                <span>Cetak QR Pengiriman</span></a>
                        </li>
                        <?php
                    break;
                case "3": 
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/gudang-lovish/qr-scanner-out') ?>">
                                <i class="fas fa-fw fa-qrcode"></i>
                                <span>QR Scanner OUT</span></a>
                        </li>
                        <?php
                    break;
                case "4": 
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/gudang-gesit/qr-scanner-in') ?>">
                                <i class="fas fa-fw fa-qrcode"></i>
                                <span>QR Scanner Pengiriman</span></a>
                        </li>
                        <?php
                    break;
                case "5": 
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/gudang-gesit/qr-scanner-in') ?>">
                                <i class="fas fa-fw fa-qrcode"></i>
                                <span>QR Scanner Retur (IN)</span></a>
                        </li>
                        <?php
                    break;
                case "6": 
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/gudang-gesit/qr-scanner-in') ?>">
                                <i class="fas fa-fw fa-chart-area"></i>
                                <span>Laporan</span></a>
                        </li>
                        <?php
                    break;
            }
        }
    }
?>

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>



</ul>
<!-- End of Sidebar -->