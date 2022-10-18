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
                            <input type="text" name="dates" class="form-control text-center daterange" value="<?= date('m/d/Y') ?> - <?= date('m/d/Y') ?>" readonly />            
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
                        <a class="btn btn-success float-right" href="<?= base_url('/export-data-stok-produk') ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
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
                                    <th class="text-center">Scan In</th>
                                    <th class="text-center">Stok Retur</th>
                                    <th class="text-center">Penjualan</th>
                                    <th class="text-center">Sisa Stok</th>
                                    <th class="text-center">HPP Gesit</th>
                                    <th class="text-center">HPP Jual</th>
                                    <th class="text-center">Nilai Barang</th>
                                    <th class="text-center">Nilai Jual</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php $no = 1; ?>
                                <?php if (count($stokProduk) > 0) : ?>
                                    <?php foreach ($stokProduk as $product) : ?>                                                    
                                        <tr>
                                            <td class="text-center align-middle"><?= $no++ ?></td>
                                            <td><?= $product['product_name'] ?> <?= $product['model_name'] ?> <?= $product['color'] ?></td>
                                            <td class="text-center align-middle"><?= $product['stok'] > 0 ? $product['stok'] : '-' ?></td>
                                            <td class="text-center align-middle"><?= $product['stok_masuk'] > 0 ? $product['stok_masuk'] : '-' ?></td>
                                            <td class="text-center align-middle"><?= $product['scan_in'] > 0 ? $product['scan_in'] : '-' ?></td>
                                            <td class="text-center align-middle"><?= $product['stok_retur'] > 0 ? $product['stok_retur'] : '-' ?></td>
                                            <td class="text-center align-middle"><?= $product['penjualan'] > 0 ? $product['penjualan'] : '-' ?></td>
                                            <?php if ($product['sisa'] > 20) : ?>
                                                <td class="text-center align-middle"><?= $product['sisa'] ?></td>                                        
                                            <?php elseif ($product['sisa'] > 10 && $product['sisa'] < 20): ?>
                                                <td class="text-center align-middle table-warning"><?= $product['sisa'] ?></td>                                                                                
                                            <?php else : ?>
                                                <td class="text-center align-middle table-danger"><?= $product['sisa'] ?></td>                                        
                                            <?php endif ?>
                                            <td class="text-center align-middle">Rp <?= number_format($product['hpp'], 0) ?></td>
                                            <td class="text-center align-middle"><input type="text" name="hpp-jual" data-id="<?= $product['product_id'] ?>" data-model="<?= $product['model_id'] ?>" data-size="<?= $product['size'] ?>" class="form-control hpp-jual" value="<?= $product['hpp_jual'] ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" disabled></td>
                                            <td class="text-center align-middle">Rp <?= number_format(($product['hpp'] * $product['sisa']), 0) ?></td>                            
                                            <td class="text-center align-middle">Rp <?= number_format(($product['hpp_jual'] * $product['sisa']), 0) ?></td>
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
                        <a class="btn btn-success float-right" href="<?= base_url('/export-pengiriman') ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
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
                                    <th class="text-center" style="width: 10%;"><i class="fas fa-info"></i></th>
                                    <th class="text-center" style="width: 5%;"><input type="checkbox" id="select-all" /></th>
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
                                                    <a href="#" class="btn btn-warning btn-icon-split btn-sm btn-resi-produk" data-id='<?= $ship->id ?>'>
                                                        <span class="icon text-white-25">
                                                            <i class="fas fa-pen"></i>
                                                        </span>
                                                    </a>
                                                    <a href="#" class="btn btn-default btn-icon-split btn-sm btn-detail-produk" data-id='<?= $ship->id ?>'>
                                                        <span class="icon text-white-25">
                                                            <i class="fas fa-box"></i>
                                                        </span>
                                                    </a>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <input type="checkbox"  class="unprinted" name="print[]" value="<?= $ship->id ?>" />
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
                                                    <a href="#" class="btn btn-info btn-icon-split btn-sm btn-detail-produk" data-id='<?= $ship->id ?>'>
                                                        <span class="icon text-white-25">
                                                            <i class="fas fa-box"></i>
                                                        </span>
                                                    </a>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <input type="checkbox" name="print[]" value="<?= $ship->id ?>" />
                                                </td>
                                                
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
            <div id="menu2" class="tab-pane fade"><br>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary float-left">Data Pola (Keluar)</h6>
                        <a class="btn btn-success float-right" href="<?= base_url('/export-data-pola-out') ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 5%">No</th>
                                        <th class="text-center">Kode Kain</th>
                                        <th class="text-center">Tgl Ambil</th>
                                        <th class="text-center">Tgl Cutting</th>
                                        <th class="text-center">Produk</th>
                                        <th class="text-center">Warna</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-center">Bahan</th>
                                        <th class="text-center">Vendor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php if ($polaOut->getNumRows() > 0) : ?>
                                        <?php foreach ($polaOut->getResultObject() as $pola) : ?>
                                            <?php if ($pola->jum == '1') : ?>
                                                <tr>                                    
                                                    <td class="text-center"><?= $no++ ?></td>
                                                    <td class="text-center font-weight-bold"><?= $pola->material_id ?></td>
                                                    <td class="text-center"><?= date('m/d/Y', strtotime($pola->tgl_ambil)) ?></td>
                                                    <td class="text-center"><?= date('m/d/Y', strtotime($pola->tgl)) ?></td>
                                                    <td class="text-center"><?= $pola->model_name ?></td>
                                                    <td class="text-center"><?= $pola->color ?></td>
                                                    <td class="text-center"><?= $pola->jumlah_pola ?></td>
                                                    <td class="text-center"><?= $pola->type ?></td>
                                                    <td class="text-center"><?= $pola->name ?></td>
                                                    
                                                </tr>                                            
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </tbody>
                                
                            </table>
                        </div>
                        
                    </div>
                </div>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary float-left">Data Pola (Masuk)</h6>
                        <a class="btn btn-success float-right" href="<?= base_url('/export-data-pola-in') ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable3" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 5%">No</th>
                                        <th class="text-center">Kode Kain</th>                        
                                        <th class="text-center">Tgl Ambil</th>                        
                                        <th class="text-center">Produk</th>
                                        <th class="text-center">Warna</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-center">Bahan</th>
                                        <th class="text-center">Vendor</th>
                                        <th class="text-center">Tgl Setor</th>
                                        <th class="text-center">Jumlah Setor</th>
                                        <th class="text-center">Reject</th>
                                        <th class="text-center">Sisa</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">Total Harga</th>
                                        <th class="text-right" style="width: 7%"><i class="fa fa-ellipsis-v"></i></th>
                                    </tr>
                                </thead>   
                                
                                <tbody>
                    <?php $no = 1; ?>
                    <?php if ($polaIn->getNumRows() > 0) : ?>
                        <?php foreach ($polaIn->getResultObject() as $pola) : ?>
                            <?php if ($pola->status == '2') : ?>
                                <tr class="">
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td class="text-center font-weight-bold"><?= $pola->material_id ?></td>
                                    <td class="text-center"><?= date('m/d/Y', strtotime($pola->tgl_ambil)) ?></td>                                
                                    <td class="text-center"><?= $pola->model_name ?></td>
                                    <td class="text-center"><?= $pola->color ?></td>
                                    <td class="text-center"><?= $pola->jumlah_pola ?></td>
                                    <td class="text-center"><?= $pola->type ?></td>
                                    <td class="text-center"><?= $pola->name ?></td>
                                    <td class="text-center"><?= date('m/d/Y', strtotime($pola->tgl_setor)) ?></td>                                
                                    <td class="text-center"><?= $pola->jumlah_setor ?></td>
                                    <td class="text-center"><?= $pola->reject ?></td>
                                    <td class="text-center"><?= $pola->sisa ?></td>
                                    <td class="text-center"><?= $pola->harga ?></td>
                                    <td class="text-center"><?= $pola->total_harga ?></td>
                                    <td class="text-center align-middle">
                                        <a href="#" data-toggle="modal" data-target="#infoPolaIn"><i class="fa fa-info-circle fa-lg mr-2"></i></a>                                
                                        <div class="modal fade" id="infoPolaIn" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">Biaya</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table class="table">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">GELAR 1</th>
                                                                    <th scope="col">GELAR 2</th>
                                                                    <th scope="col">PIC Cutting</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><?= $pola->gelar1 ?></td>
                                                                    <td><?= $pola->gelar2 ?></td>
                                                                    <td><?= $pola->pic ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>
    $('.daterange').daterangepicker();    

    $('.daterange').change(function() {
        $('#date').submit();
    })
    
</script>
<?= $this->endSection() ?>