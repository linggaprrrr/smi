<?= $this->extend('gudang_gesit/layout/content') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-xl-4 col-md-4 mb-4">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                            Total Stok Kain</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= (is_null($totalKainGesit) ? "0" : $totalKainGesit) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-cubes fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-4 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Kain Masuk <mark>(<?= date('F') ?>)</mark></div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= (is_null($totalKainGesitMonth) ? "0" : $totalKainGesitMonth) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-cube fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-4 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Cutting <mark>(<?= date('F') ?>)</mark></div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= (is_null($totalCutting) ? "0" : $totalCutting) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-cut fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-4 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Pola Keluar / Masuk <mark>(<?= date('F') ?>)</mark></div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= (is_null($totalPolaKeluar) ? "0" : $totalPolaKeluar) ?> / <?= (is_null($totalPolaMasuk) ? "0" : $totalPolaMasuk) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shekel-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-4 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total Produk Gesit <mark>(<?= date('F') ?>)</mark></div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= (is_null($totalGesit) ? "0" : $totalGesit) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-4 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Kain Retur / Pola Reject <mark>(<?= date('F') ?>)</mark></div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= (is_null($totalKainRetur) ? "0" : $totalKainRetur) ?> / <?= (is_null($polaReject) ? "0" : $polaReject) ?> </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-sign-out-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left">Stok Kain Masuk</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th class="text-center">Jenis</th>
                                <th class="text-center">Warna</th>
                                <th class="text-center">Stok</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php $no = 1; ?>
                            <?php if ($materials->getNumRows() > 0) : ?>
                                <?php foreach ($materials->getResultObject() as $kain) : ?>
                                    <?php if ($kain->stok_masuk > 0) :  ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= $kain->type ?></td>
                                            <td><?= $kain->color ?></td>
                                            <td class="text-center"><?= $kain->stok_masuk ?></td>
                                        </tr>
                                    <?php endif ?>
                                <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left">Stok Produk Gesit</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th class="text-center">Jenis</th>
                                <th class="text-center">Model</th>
                                <th class="text-center">Warna</th>
                                <th class="text-center">Stok</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php $no = 1; ?>
                            <?php if ($productsIn->getNumRows() > 0) : ?>
                                <?php foreach ($productsIn->getResultObject() as $product) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $product->product_name ?></td>
                                        <td><?= $product->model_name ?></td>
                                        <td><?= $product->color ?></td>
                                        <?php if ($product->stok <= 5) :?>
                                            <td class="text-center font-weight-bold table-danger"><?= $product->stok  ?></td>
                                        <?php elseif($product->stok >= 5 || $product->stok <= 10) : ?>
                                            <td class="text-center font-weight-bold table-warning"><?= $product->stok  ?></td>
                                        <?php else : ?>
                                            <td class="text-center font-weight-bold"><?= $product->stok  ?></td>
                                        <?php endif ?>
                                    </tr>
                                <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left">Stok Kain</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th class="text-center">Jenis</th>
                                <th class="text-center">Warna</th>
                                <th class="text-center">Stok Awal</th>
                                <th class="text-center">Stok Masuk</th>
                                <th class="text-center">Stok Retur</th>
                                <th class="text-center">Total Stok</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php $no = 1; ?>
                            <?php if ($materials->getNumRows() > 0) : ?>
                                <?php foreach ($materials->getResultObject() as $kain) : ?>
                                    <?php 
                                        $total = $kain->stok + $kain->stok_masuk - $kain->stok_retur;                                    
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $kain->type ?></td>
                                        <td><?= $kain->color ?></td>
                                        <td class="text-center"><?= $kain->stok ?></td>
                                        <td class="text-center"><?= $kain->stok_masuk ?></td>
                                        <td class="text-center text-danger"><?= $kain->stok_retur ?></td>                                        
                                        <?php if ($total <= 5) :?>
                                            <td class="text-center font-weight-bold table-danger"><?= $total ?></td>
                                        <?php elseif($total >= 5 || $total <= 10) : ?>
                                            <td class="text-center font-weight-bold table-warning"><?= $total ?></td>
                                        <?php else : ?>
                                            <td class="text-center font-weight-bold"><?= $total ?></td>
                                        <?php endif ?>
                                    </tr>
                                <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left">Data Produk Ke Gudang</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable3" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th class="text-center">Jenis</th>
                                <th class="text-center">Model</th>
                                <th class="text-center">Warna</th>
                                <th class="text-center">Stok</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php $no = 1; ?>
                            <?php if ($productsOut->getNumRows() > 0) : ?>
                                <?php foreach ($productsOut->getResultObject() as $product) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $product->product_name ?></td>
                                        <td><?= $product->model_name ?></td>
                                        <td><?= $product->color ?></td>
                                        <td class="text-center"><?= $product->stok ?></td>
                                    </tr>
                                <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>