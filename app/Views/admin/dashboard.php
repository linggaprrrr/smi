<?= $this->extend('admin/layout/content') ?>

<?= $this->section('content') ?>
<div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Gesit</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= (is_null($totalGesit) ? "0" : $totalGesit) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Lovish</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= (is_null($totalLovishIn) ? "0" : $totalLovishIn) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Produk Keluar (Lovish)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= (is_null($totalLovishOut) ? "0" : $totalLovishOut) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Produk Hampir Habis</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= (is_null($totalLovishAlmostOut) ? "0" : $totalLovishAlmostOut) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
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
                <h6 class="m-0 font-weight-bold text-primary float-left">Stok Gudang Gesit</h6>
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
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left">Stok Gudang Lovish</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
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
                                    <?php if ($product->stok > 20) : ?>
                                        <tr class="">
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= $product->product_name ?></td>
                                            <td><?= $product->model_name ?></td>
                                            <td><?= $product->color ?></td>
                                            <td class="text-center"><?= $product->stok ?></td>
                                        </tr>
                                    <?php else : ?>
                                        <tr class="table-warning">
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= $product->product_name ?></td>
                                            <td><?= $product->model_name ?></td>
                                            <td><?= $product->color ?></td>
                                            <td class="text-center"><?= $product->stok ?></td>
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
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left">Total Produk Keluar (Gudang Lovish)</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable4" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th class="text-center">Nama Produk</th>
                                <th class="text-center">Model</th>
                                <th class="text-center">Warna</th>
                                <th class="text-center">Berat (gr)</th>
                                <th class="text-center">Tanggal</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php $no = 1; ?>
                            <?php if ($productsExp->getNumRows() > 0) : ?>
                                <?php foreach ($productsExp->getResultObject() as $product) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $product->product_name ?></td>
                                        <td class="text-center"><?= $product->model_name ?></td>
                                        <td><?= $product->color ?></td>
                                        <td><?= $product->weight ?></td>
                                        <td class="text-center"><?= $product->created_at ?></td>
                                        
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
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left">Stok Kain Masuk (Gudang Gesit)</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th class="text-center">Jenis</th>
                                <th class="text-center">Warna</th>
                                <th class="text-center">Berat (kg)</th>
                                <th class="text-center">Tanggal</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php $no = 1; ?>
                            <?php if ($materials->getNumRows() > 0) : ?>
                                <?php foreach ($materials->getResultObject() as $kain) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $kain->type ?></td>
                                        <td><?= $kain->color ?></td>
                                        <td><?= number_format(($kain->weight/1000), 2) ?></td>
                                        <td class="text-center"><?= $kain->created_at ?></td>
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