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
<?php 
    $access = json_decode(session()->get('accessibility'));
    if (!is_null($access)) {
        for ($i=0; $i < count($access); $i++) {
            switch ($access[$i]) {
                case "1": 
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/gudang-gesit/kain') ?>">
                                <i class="fas fa-fw fa-boxes"></i>
                                <span>Kain</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('gudang-gesit/produk') ?>">
                                <i class="fas fa-fw fa-tshirt"></i>
                                <span>Produk</span></a>
                        </li>
                        <?php
                    break;
                case "2": 
                        ?>
                        <li class="nav-item">
                            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                                aria-expanded="true" aria-controls="collapseUtilities">
                                <i class="fas fa-fw fa-print"></i>
                                <span>Cetak QR Code</span>
                            </a>
                            <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                                data-parent="#accordionSidebar">
                                <div class="bg-white py-2 collapse-inner rounded">
                                    <a class="collapse-item" href="<?= base_url('/gudang-gesit/qr-generator-kain') ?>">Kain</a>
                                    <a class="collapse-item" href="<?= base_url('/gudang-gesit/qr-generator-produk-masuk') ?>">Produk</a>
                                </div>
                            </div>
                        </li>                        
                        <?php
                    break;                
                case "4": 
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/gudang-gesit/qr-scanner-cutting') ?>">
                                <i class="fas fa-fw fa-qrcode"></i>
                                <span>QR Scanner Cutting</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/gudang-gesit/qr-scanner-reject') ?>">
                                <i class="fas fa-fw fa-qrcode"></i>
                                <span>QR Scanner Reject</span></a>
                        </li>
                        <?php
                    break;
                case "7": 
                        ?>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/gudang-gesit/qr-scanner-reject') ?>">
                                <i class="fas fa-fw fa-qrcode"></i>
                                <span>QR Scanner Reject</span></a>
                        </li> -->
                        <?php
                    break;
                case "5": 
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/gudang-gesit/qr-scanner-produk-in') ?>">
                                <i class="fas fa-fw fa-qrcode"></i>
                                <span>QR Scanner Produk (IN)</span></a>
                        </li>
                        <?php
                    break;
                case "3": 
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/gudang-gesit/qr-scanner-retur') ?>">
                                <i class="fas fa-fw fa-qrcode"></i>
                                <span>QR Scanner Kain Retur</span></a>
                        </li>
                        <?php
                    break;
                case "6": 
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/gudang-gesit/laporan') ?>">
                                <i class="fas fa-fw fa-chart-area"></i>
                                <span>Laporan</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/gudang-gesit/gudang-reject') ?>">
                                <i class="fas fa-fw fa fa-list"></i>
                                <span>Gudang Reject</span></a>
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