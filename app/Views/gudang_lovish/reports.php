<?= $this->extend('gudang_lovish/layout/content') ?>

<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-xl-3">
                <form method="GET" action="<?= base_url('/operasional/laporan') ?>" id="date" >
                    <div class="form-group">
                        <label for="">Date Range: </label>
                        <?php if (is_null($date1)) : ?>
                            <input type="text" name="dates" class="form-control text-center daterange" value="<?= date('m/d/Y H:i') ?> - <?= date('m/d/Y H:i') ?>" readonly />            
                        <?php else : ?>
                            <input type="text" name="dates" class="form-control text-center daterange" value="<?= $date1 ?> - <?= $date2 ?>" readonly />            
                        <?php endif ?>
                    </div>    
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">        
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link font-weight-bold active" data-toggle="tab" href="#home">Produk</a>
            </li>
            <li class="nav-item">
                <a class="nav-link font-weight-bold" data-toggle="tab" href="#menu1">Pengiriman</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content m-0">
            <div id="home" class="tab-pane active"><br>                
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary float-left">Data Stok Produk</h6>
                        <?php if (!is_null($date1)) : ?>
                            <a class="btn btn-success float-right" href="<?= base_url('/export-data-stok-produk/'. date('Y-m-d', strtotime($date1)) . '/'. date('Y-m-d H:i:s', strtotime($date2))) ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>                            
                        <?php else : ?>
                            <a class="btn btn-success float-right" href="<?= base_url('/export-data-stok-produk') ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
                        <?php endif ?>
                    </div>
                    <div class="card-body">        
                        <div class="table-responsive">
                          <table class="table table-bordered" id="dataTable20" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 5%">No</th>
                                    <th class="text-center">Produk</th>                        
                                    <th class="text-center">Stok Awal</th>
                                    <th class="text-center">Stok Masuk (Gesit)</th>                        
                                    <th class="text-center">Stok Retur</th>
                                    <th class="text-center">Penjualan Langsung</th>
                                    <th class="text-center">Pengiriman</th>
                                    <th class="text-center">Sisa Stok</th>
                                    <th class="text-center">HPP Gesit</th>
                                    <th class="text-center">HPP Jual</th>
                                    <th class="text-center">Nilai Barang</th>
                                    <th class="text-center">Nilai Jual</th>
                                    <th class="text-center">Margin Tetap</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php $no = 1; ?>
                                <?php if ($stokProduk->getNumRows() > 0) : ?>
                                    <?php foreach ($stokProduk->getResultArray() as $product) : ?>     
                                        <?php 
                                            $alert = 0;
                                            $stok = $product['stok'] + $product['stok_masuk'];
                                            $keluar = $product['penjualan'] - $product['stok_retur'];
                                            if ($stok > 0 && $keluar > 0) {                                        
                                                $alert = 100 - (($keluar / $stok) * 100);
                                            } else if ($stok == 0){
                                                $alert = 100;
                                            } else if ($keluar == 0) {
                                                $alert = 100;
                                            }                  
                                        ?>                                               
                                        <tr>
                                            <td class="text-center align-middle"><?= $no++ ?></td>
                                            <td><?= $product['product_name'] ?> <?= $product['model_name'] ?> <?= $product['color'] ?></td>
                                            <td class="text-center align-middle"><?= $product['stok'] > 0 ? $product['stok'] : '-' ?></td>
                                            <td class="text-center align-middle"><?= $product['stok_masuk'] > 0 ? $product['stok_masuk'] : '-' ?></td>                                                                
                                            <td class="text-center align-middle"><?= $product['stok_retur'] > 0 ? $product['stok_retur'] : '-' ?></td>
                                            <td class="text-center align-middle"><?= $product['penjualan'] > 0 ? $product['penjualan'] : '-' ?></td>
                                            <td class="text-center align-middle"><?= $product['pengiriman'] > 0 ? $product['pengiriman'] : '-' ?></td>                                
                                            <?php if ($alert >= 70) : ?>
                                                <td class="text-center align-middle"><?= $product['sisa'] ?></td>                                        
                                            <?php elseif ($alert >= 50 && $alert < 69): ?>
                                                <td class="text-center align-middle table-warning"><?= $product['sisa'] ?></td>                                                                                
                                            <?php elseif ($alert >= 21 && $alert < 49): ?>
                                                <td class="text-center align-middle" style="background-color: #ffcf77;"><?= $product['sisa'] ?></td>                                                                                
                                            <?php elseif ($alert >= 0 && $alert < 20) : ?>
                                                <td class="text-center align-middle table-danger"><?= $product['sisa'] ?></td>
                                            <?php else : ?>
                                              <td class="text-center align-middle table-danger"><?= $product['sisa'] ?></td>      
                                            <?php endif ?>
                                            <td class="text-center align-middle">Rp <?= number_format($product['hpp'], 0) ?></td>
                                            <td class="text-center align-middle">Rp <?= number_format($product['hpp_jual'], 0) ?></td>
                                            <td class="text-center align-middle">Rp <?= number_format(($product['hpp'] * $product['sisa']), 0) ?></td>                            
                                            <td class="text-center align-middle">Rp <?= number_format(($product['hpp_jual'] * $product['sisa']), 0) ?></td>
                                            <td class="text-center align-middle"><mark>Rp <?= number_format(($product['hpp_jual'] * $product['sisa']) - ($product['hpp'] * $product['sisa']), 0) ?></mark></td>
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
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary float-left">Data Pengiriman</h6>
                         <?php if (!is_null($date1)) : ?>
                            <a class="btn btn-success float-right" href="<?= base_url('/export-pengiriman/'. date('Y-m-d', strtotime($date1)) . '/'. date('Y-m-d H:i:s', strtotime($date2))) ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>                            
                        <?php else : ?>
                            <a class="btn btn-success float-right" href="<?= base_url('/export-pengiriman') ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
                        <?php endif ?>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="tabel-kain">
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
                                                    <a href="#" class="btn btn-warning btn-icon-split btn-sm btn-resi-produk" data-id='<?= $ship->id ?>'>
                                                        <span class="icon text-white-25">
                                                            <i class="fas fa-pen"></i>
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
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>
    $('.daterange').daterangepicker({
        timePicker: true,
        timePicker24Hour: true,
        startDate: moment().startOf('hour'),
        endDate: moment().startOf('hour').add(32, 'hour'),
        locale: {
            format: 'M/D/YYYY HH:MM'
        }
    });      

    $('.daterange').change(function() {
        $('#date').submit();
    })
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