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
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= (is_null($totalGudang['stok']) ? "0" : $totalGudang['stok']) ?></div>
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
                            Stok Masuk <mark>(<?= date('F') ?>)</mark></div>
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
                            Total Keluar <mark>(<?= date('F') ?>)</mark></div>
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
                            Produk Retur <mark>(<?= date('F') ?>)</mark></div>
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
                            Total Nilai Barang <mark>(<?= date('F') ?>)</mark></div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Rp. <?= (is_null($totalNilaiBarang) ? "0" : number_format($totalNilaiBarang, 0, ',', '.')) ?></div>
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
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left">Stok Gudang</h6>
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
                            <?php if ($productLovish->getNumRows() > 0) : ?>
                                <?php foreach ($productLovish->getResultObject() as $product) : ?>
                                    <?php $sisa =  ($product->stok + $product->stok_masuk - ($product->penjualan - $product->stok_retur)) ?>
                                    <tr class="">
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $product->product_name ?></td>
                                        <td><?= $product->model_name ?></td>
                                        <td><?= $product->color ?></td>
                                        <td class="text-center"><?= is_null($product->size) ? '-' : $product->size ?></td>
                                    <?php if ($sisa > 20) : ?>
                                        <td class="text-center"><?= $sisa ?></td>                                        
                                    <?php elseif ($sisa > 10 && $sisa < 20): ?>
                                        <td class="text-center table-warning"><?= $sisa ?></td>                                                                                
                                    <?php else : ?>
                                        <td class="text-center table-danger"><?= $sisa ?></td>                                        
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
                                            <td class="text-center"><?= date('d/m/Y', strtotime($product->created_at)) ?></td>
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
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable5" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
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
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left">Data Pengiriman</h6>
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
                                            <td class="text-center align-middle"><?= date('j F Y, H:m', strtotime($ship->created_at)) ?></td>
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
                                            <td class="text-center align-middle"><?= date('j F Y, H:m', strtotime($ship->created_at)) ?></td>
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
</script>
<?= $this->endSection() ?>