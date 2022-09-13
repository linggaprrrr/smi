<?= $this->extend('gudang_gesit/layout/content') ?>

<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        
    </div>
    <div class="card-body">        
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link font-weight-bold active" data-toggle="tab" href="#home">Kain</a>
            </li>
            <li class="nav-item">
                <a class="nav-link font-weight-bold" data-toggle="tab" href="#menu1">Cutting</a>
            </li>
            <li class="nav-item">
                <a class="nav-link font-weight-bold" data-toggle="tab" href="#menu2">Pola</a>
            </li>
            <li class="nav-item">
                <a class="nav-link font-weight-bold" data-toggle="tab" href="#menu3">Produk</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content m-0">
            <div id="home" class="tab-pane active"><br>                
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary float-left">Data Kain Masuk</h6>
                        <a class="btn btn-success float-right" href="<?= base_url('/export-data-kain') ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
                    </div>
                    <div class="card-body">        
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 5%">No</th>
                                        <th class="text-center">Jenis</th>
                                        <th class="text-center">Warna</th>
                                        <th class="text-center">Berat (kg)</th>
                                        <th class="text-center">Tanggal Masuk</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php if ($materials->getNumRows() > 0) : ?>
                                        <?php foreach ($materials->getResultObject() as $kain) : ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td class=""><?= $kain->type ?></td>
                                                <td><?= $kain->color ?></td>
                                                <td><?= number_format($kain->weight/1000, 2) ?></td>
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
            <div id="menu1" class="tab-pane fade"><br>
                
            </div>
            <div id="menu2" class="tab-pane fade"><br>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary float-left">Data Kain Keluar (Pola)</h6>
                        <a class="btn btn-success float-right" href="<?= base_url('/export-data-pola-out') ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 5%">No</th>
                                        <th class="text-center">Jenis</th>
                                        <th class="text-center">Warna</th>
                                        <th class="text-center">Berat (kg)</th>
                                        <th class="text-center">Tanggal Masuk</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php if ($polaOut->getNumRows() > 0) : ?>
                                        <?php foreach ($polaOut->getResultObject() as $kain) : ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td class=""><?= $kain->type ?></td>
                                                <td><?= $kain->color ?></td>
                                                <td><?= number_format($kain->weight/1000, 2) ?></td>
                                                <td class="text-center"><?= $kain->created_at ?></td>
                                            
                                            </tr>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary float-left">Data Kain Masuk (Pola)</h6>
                        <a class="btn btn-success float-right" href="<?= base_url('/export-data-pola-in') ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable3" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 5%">No</th>
                                        <th class="text-center">Jenis</th>
                                        <th class="text-center">Warna</th>
                                        <th class="text-center">Berat (kg)</th>
                                        <th class="text-center">Tanggal Masuk</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php if ($polaIn->getNumRows() > 0) : ?>
                                        <?php foreach ($polaIn->getResultObject() as $kain) : ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td class=""><?= $kain->type ?></td>
                                                <td><?= $kain->color ?></td>
                                                <td><?= number_format($kain->weight/1000, 2) ?></td>
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
            <div id="menu3" class="tab-pane fade"><br>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary float-left">Data Produk (Gesit)</h6>
                        <a class="btn btn-success float-right" href="<?= base_url('/export-produk-gesit') ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
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
                                    <?php if ($productsIn->getNumRows() > 0) : ?>
                                        <?php foreach ($productsIn->getResultObject() as $product) : ?>
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
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary float-left">Data Produk Masuk (Gudang)</h6>
                        <a class="btn btn-success float-right" href="<?= base_url('/export-produk-masuk-lovish') ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                                    <?php if ($productsOut->getNumRows() > 0) : ?>
                                        <?php foreach ($productsOut->getResultObject() as $product) : ?>
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
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {


    });
    
</script>
<?= $this->endSection() ?>