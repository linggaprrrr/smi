<?= $this->extend('gudang_lovish/layout/content') ?>

<?= $this->section('content') ?>
<div class="row">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                            Stok Gudang</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= (is_null($totalGudang) ? "0" : $totalGudang) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Stok Masuk </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= (is_null($totalStokMasuk['stok']) ? "0" : $totalStokMasuk['stok']) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Total Keluar </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= (is_null($stokKeluar['stok']) ? "0" : ($stokKeluar['stok'])) ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Produk Retur </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= (is_null($stokRetur['stok']) ? "0" : $stokRetur['stok']) ?></div>
                    </div>
                    <div class="col-auto"> 
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    

    <!-- Pending Requests Card Example -->
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Nilai Barang </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?= (is_null($totalNilaiBarang) ? "0" : number_format($totalNilaiBarang, 0, ',', '.')) ?></div>
                    </div>
                    <div class="col-auto"> 
                        <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Nilai Barang Jual </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?= (is_null($totalNilaiBarangJual) ? "0" : number_format($totalNilaiBarangJual, 0, ',', '.')) ?></div>
                    </div>
                    <div class="col-auto"> 
                        <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="float-right">
            <form method="GET" action="<?= base_url('/operasional/dashboard') ?>" id="date" >
                <div class="form-group" style="width: 280px;">
                    <label for="">Date Range: </label>    
                    <?php if (is_null($date1)) : ?>
                        <input type="text" name="dates" value="<?= date('m/d/Y 07:00') ?> - <?= date('m/d/Y 17:00') ?>" class="form-control text-center daterange" readonly />                    
                    <?php else : ?>
                        <input type="text" name="dates" class="form-control text-center daterange" value="<?= $dates ?>" readonly />            
                    <?php endif ?> 
                </div>    
            </form>
        </div>
    </div>
    <div class="col-lg-6">        
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left">Stok Gudang</h6>
                <div>
                <?php if (!is_null($date1)) : ?>
                    <a class="btn btn-success float-right" href="<?= base_url('/export-dash-stok-gudang/'. date('Y-m-d H:i:s', strtotime($date1)) . '/'. date('Y-m-d H:i:s', strtotime($date2))) ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>                            
                <?php else : ?>
                    <a class="btn btn-success float-right" href="<?= base_url('/export-dash-stok-gudang') ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
                <?php endif ?>
                </div>
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
                                <th class="text-center">Size</th>
                                <th class="text-center">Sisa Stok</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php $no = 1; ?>
                            <?php if (count($productLovish) > 0) : ?>
                                <?php foreach ($productLovish as $product) : ?>
                                    
                                    <tr class="">
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $product['product_name'] ?></td>
                                        <td><?= $product['model_name'] ?></td>
                                        <td><?= $product['color'] ?></td>
                                        <td class="text-center"><?= is_null($product['size']) ? '-' : $product['size'] ?></td>
                                    <?php if ($product['sisa_gudang'] > 20) : ?>
                                        <td class="text-center"><?= $product['sisa_gudang'] ?></td>                                        
                                    <?php elseif ($product['sisa_gudang'] > 10 && $product['sisa_gudang'] < 20): ?>
                                        <td class="text-center table-warning"><?= $product['sisa_gudang']  ?></td>                                                                                
                                    <?php else : ?>
                                        <td class="text-center table-danger"><?= $product['sisa_gudang']  ?></td>                                        
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
                <h6 class="m-0 font-weight-bold text-primary float-left">Total Produk Keluar</h6>
                <div>
                    <?php if (!is_null($date1)) : ?>
                        <a class="btn btn-success float-right" href="<?= base_url('/export-dash-produk-keluar/'. date('Y-m-d H:i:s', strtotime($date1)) . '/'. date('Y-m-d H:i:s', strtotime($date2))) ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>                            
                    <?php else : ?>
                        <a class="btn btn-success float-right" href="<?= base_url('/export-dash-produk-keluar') ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
                    <?php endif ?>
                    
                </div>
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
                                <th class="text-center">Size</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Qty</th>
                                
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php $no = 1; ?>
                            <?php if ($productsExp->getNumRows() > 0) : ?>                                
                                <?php foreach ($productsExp->getResultObject() as $product) : ?>
                                    <?php if (!is_null($product->id)) : ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td class="text-center"><?= $product->product_name ?></td>
                                            <td class="text-center"><?= $product->model_name ?></td>
                                            <td class="text-center"><?= $product->color ?></td>
                                            <td class="text-center"><?= is_null($product->size) ? '-' : $product->size ?></td>
                                            <td class="text-center"><?= date('d/m/Y', strtotime($product->updated_at)) ?></td>
                                            <td>1</td>
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
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left">Produk Masuk</h6>
                <div>
                    <?php if (!is_null($date1)) : ?>
                        <a class="btn btn-success float-right" href="<?= base_url('/export-dash-produk-masuk/'. date('Y-m-d H:i:s', strtotime($date1)) . '/'. date('Y-m-d H:i:s', strtotime($date2))) ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>                            
                    <?php else : ?>
                        <a class="btn btn-success float-right" href="<?= base_url('/export-dash-produk-masuk') ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
                    <?php endif ?>
                    
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable6" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th class="text-center">Jenis</th>
                                <th class="text-center">Model</th>
                                <th class="text-center">Warna</th>
                                <th class="text-center">Size</th>
                                <th class="text-center">Tanggal Masuk</th>
                                <th class="text-center">Stok</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php $no = 1; ?>
                            <?php if ($productsIn->getNumRows() > 0) : ?>
                                <?php foreach ($productsIn->getResultObject() as $product) : ?>
                                    <tr class="">
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td class="text-center"><?= $product->product_name ?></td>
                                        <td class="text-center"><?= $product->model_name ?></td>
                                        <td class="text-center"><?= $product->color ?></td>
                                        <td class="text-center"><?= is_null($product->size) ? '-' : $product->size ?></td>
                                        <td class="text-center"><?= $product->updated_at ?></td>
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
                <h6 class="m-0 font-weight-bold text-primary float-left">Produk Retur</h6>
                <div>
                    <?php if (!is_null($date1)) : ?>
                        <a class="btn btn-success float-right" href="<?= base_url('/export-dash-produk-retur/'. date('Y-m-d', strtotime($date1)) . '/'. date('Y-m-d H:i:s', strtotime($date2))) ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>                            
                    <?php else : ?>
                        <a class="btn btn-success float-right" href="<?= base_url('/export-dash-produk-retur') ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
                    <?php endif ?>
                    
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable5" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Jenis</th>
                                <th class="text-center">Model</th>
                                <th class="text-center">Warna</th>
                                <th class="text-center">Size</th>
                                <th class="text-center">Qty</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php $no = 1; ?>
                            <?php if ($productsRetur->getNumRows() > 0) : ?>
                                <?php foreach ($productsRetur->getResultObject() as $product) : ?>
                                    <tr class="table-danger">
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td class="text-center"><?= $product->created_at ?></td>
                                        <td><?= $product->product_name ?></td>
                                        <td><?= $product->model_name ?></td>
                                        <td><?= $product->color ?></td>
                                        <td class="text-center"><?= is_null($product->size) ? '-' : $product->size ?></td>
                                        <td class="text-center"><?= $product->qty ?></td>
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
                <h6 class="m-0 font-weight-bold text-primary float-left">Top 10 Produk/Brand</h6>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold active" data-toggle="tab" href="#lovish">LOVISH</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" data-toggle="tab" href="#odelia">ODELIA</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-bold" data-toggle="tab" href="#basundari">BASUNDARI</a>
                    </li>
                </ul>
                <div class="tab-content m-0">
                    <div id="lovish" class="tab-pane active"><br>  
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable7" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 5%">No</th>
                                        <th class="text-center">Jenis</th>
                                        <th class="text-center">Model</th>
                                        <th class="text-center">Total Qty</th>
                                        <th class="text-center">Brand</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php if ($top10Lovish->getNumRows() > 0) : ?>
                                        <?php foreach ($top10Lovish->getResultObject() as $product) : ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td><?= $product->product_name ?></td>
                                                <td><?= $product->model_name ?></td>                                                               
                                                <td class="text-center"><?= $product->total_qty ?></td>
                                                <td class="text-center"><?= $product->brand ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="odelia" class="tab-pane"><br>  
                        <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable7" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 5%">No</th>
                                            <th class="text-center">Jenis</th>
                                            <th class="text-center">Model</th>
                                            <th class="text-center">Total Qty</th>
                                            <th class="text-center">Brand</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php if ($top10Odelia->getNumRows() > 0) : ?>
                                            <?php foreach ($top10Odelia->getResultObject() as $product) : ?>
                                                <tr>
                                                    <td class="text-center"><?= $no++ ?></td>
                                                    <td><?= $product->product_name ?></td>
                                                    <td><?= $product->model_name ?></td>                                                               
                                                    <td class="text-center"><?= $product->total_qty ?></td>
                                                    <td class="text-center"><?= $product->brand ?></td>
                                                </tr>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </tbody>
                                </table>
                            </div>                        
                    </div>
                    <div id="basundari" class="tab-pane"><br>  
                        <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable7" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 5%">No</th>
                                            <th class="text-center">Jenis</th>
                                            <th class="text-center">Model</th>
                                            <th class="text-center">Total Qty</th>
                                            <th class="text-center">Brand</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        <?php $no = 1; ?>
                                        <?php if ($top10Basundari->getNumRows() > 0) : ?>
                                            <?php foreach ($top10Basundari->getResultObject() as $product) : ?>
                                                <tr>
                                                    <td class="text-center"><?= $no++ ?></td>
                                                    <td><?= $product->product_name ?></td>
                                                    <td><?= $product->model_name ?></td>                                                               
                                                    <td class="text-center"><?= $product->total_qty ?></td>
                                                    <td class="text-center"><?= $product->brand ?></td>
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
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left">Data Pengiriman</h6>
                <div>
                    <?php if (!is_null($date1)) : ?>
                        <a class="btn btn-success float-right" href="<?= base_url('/export-dash-pengiriman/'. date('Y-m-d H:i:s', strtotime($date1)) . '/'. date('Y-m-d H:i:s', strtotime($date2))) ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>                            
                    <?php else : ?>
                        <a class="btn btn-success float-right" href="<?= base_url('/export-dash-pengiriman') ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
                    <?php endif ?>
                    
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th class="text-center">Pengiriman</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">No. Resi</th>
                                <th class="text-center" style="width: 10%;"><i class="fas fa-info-circle"></i></th>                            
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php $no = 1; ?>
                            <?php if ($shippings->getNumRows() > 0) : ?>
                                <?php foreach ($shippings->getResultObject() as $ship) : ?>
                                    <?php if (is_null($ship->qrcode) || empty($ship->qrcode)) : ?>
                                        <tr>
                                            <td class="text-center align-middle"><?= $no++ ?></td>
                                            <td class="align-middle"><?= $ship->box_name ?></td>                       
                                            <td class="text-center align-middle"><?= $ship->created_at ?></td>
                                            <td class="text-center align-middle">
                                                <?php if (empty($ship->resi) || is_null($ship->resi)) : ?>
                                                    -
                                                <?php else : ?>
                                                    <?= $ship->resi ?>
                                                <?php endif ?>
                                            </td>
                                            <td class="text-center align-middle">                                           
                                                <a href="#" class="btn btn-default btn-icon-split btn-sm btn-detail-produk" data-id='<?= $ship->id ?>'>
                                                    <span class="icon text-white-25">
                                                        <i class="fas fa-box"></i>
                                                    </span>
                                                </a>
                                            </td>                                                                            
                                        </tr>
                                    <?php else :?>
                                        <tr class="table-info">
                                            <td class="text-center align-middle"><?= $no++ ?></td>
                                            <td class="align-middle"><?= $ship->box_name ?></td>                       
                                            <td class="text-center align-middle"><?= $ship->created_at ?></td>
                                            <td class="text-center align-middle"><?= $ship->resi ?></td>
                                            <td class="text-center align-middle">                                            
                                                <a href="#" class="btn btn-info btn-icon-split btn-sm btn-detail-produk" data-id='<?= $ship->id ?>'>
                                                    <span class="icon text-white-25">
                                                        <i class="fas fa-box"></i>
                                                    </span>
                                                </a>
                                            </td>                                                                                
                                        </tr>
                                    <?php endif ?>
                                <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal fade bd-example-modal-lg-produk-detail" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Detail Pengiriman</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <th style="width: 5%">No</th>
                                            <th>Produk</th>
                                            <th>Jumlah</th>
                                        </thead>
                                        <tbody id="detail-in">

                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>
    $('.btn-detail-produk').click(function(){
            const id = $(this).data('id');
            var no = 1;

            $('#detail-in').html("");
            $.get('/get-pengiriman-detail', {ship_id: id})
                .done(function(data) {
                    const product = JSON.parse(data);
                    for (var i = 0; i < product.length; i++) {
                        $('#detail-in').append('<tr>');
                        $('#detail-in').append('<td>'+ no++ +'</td>');
                        $('#detail-in').append('<td>'+ product[i]['product_name'] +' '+ product[i]['model_name'] +' '+ product[i]['color'] +'</td>');
                        $('#detail-in').append('<td class="text-center">'+ product[i]['qty'] +'</td>');
                        $('#detail-in').append('</tr>');
                    }
            });
            $('.bd-example-modal-lg-produk-detail').modal('show');
        });
         $('.daterange').daterangepicker({
            timePicker: true,        
            locale: {
                format: 'M/DD/YYYY hh:mm A'
            }
        });      

        $('.daterange').change(function() {
            $('#date').submit();
        })
</script>
<?= $this->endSection() ?>