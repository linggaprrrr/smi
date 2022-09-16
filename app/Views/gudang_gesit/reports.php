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
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary float-left">Data Cutting</h6>
                        <a class="btn btn-success float-right" href="<?= base_url('/export-data-cutting') ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="tabel-kain">
                            <table class="table table-bordered" id="dataTable3" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 5%">No</th>
                                        <th class="text-center">Kode Kain</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Produk</th>
                                        <th class="text-center">Warna</th>
                                        <th class="text-center" style="width: 10%;">Qty</th>
                                        <th class="text-center">Gelar 1</th>
                                        <th class="text-center">Gelar 2</th>                        
                                        <th class="text-center">PIC</th>
                                        <th class="text-center">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php if ($cuttings->getNumRows() > 0) : ?>
                                        <?php foreach ($cuttings->getResultObject() as $cutting) : ?>
                                            <tr>
                                                <td class="text-center align-middle"><?= $no++ ?></td>
                                                <td class="text-center font-weight-bold align-middle"><?= $cutting->mid ?></td>
                                                <td class="text-center align-middle"><?= date('m/d/Y', strtotime($cutting->tgl)) ?></td>
                                                <td class="text-center align-middle">
                                                    <select class="form-control jenis-produk" name="nama_produk" data-id='<?= $cutting->id ?>' disabled> 
                                                        <option value='0'>-</option>
                                                        <?php foreach ($models->getResultObject() as $model) : ?>
                                                            <option value="<?= $model->id ?>" <?= ($model->id == $cutting->model_id) ? 'selected="selected"': '' ?>><?= $model->model_name ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </td>
                                                <td class="text-center align-middle"><?= $cutting->color ?></td>
                                                <td class="text-center align-middle">
                                                    <input type="text" class="form-control text-center qty-cutting" name="qty" disabled data-id='<?= $cutting->id ?>' data-gelar='<?= $cutting->harga_gelar ?>' data-cutting='<?= $cutting->harga_cutting ?>'  value="<?= $cutting->qty ?>"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                </td>
                                                <td class="text-center align-middle">                                
                                                    <?= $cutting->gelar1 ?>
                                                    <br>
                                                    <small><mark id="gelar1_<?= $cutting->id ?>">Rp <?= number_format($cutting->biaya_gelar1, 0) ?></mark></small>
                                                </td>  
                                                <td class="text-center align-middle">   
                                                    <?= $cutting->gelar2 ?>                             
                                                    <br>
                                                    <small><mark id="gelar2_<?= $cutting->id ?>">Rp <?= number_format($cutting->biaya_gelar2, 0) ?></mark></small>
                                                </td>  
                                                <td class="text-center align-middle">                                
                                                    <?= $cutting->pic ?>
                                                    <br>
                                                    <small><mark id="pic_<?= $cutting->id ?>">Rp <?= number_format($cutting->biaya_cutting, 0) ?></mark></small>
                                                </td>  
                                                <td class="text-center font-weight-bold align-middle" id="total_<?= $cutting->id ?>">Rp <?= number_format($cutting->total) ?></td>  
                                                            
                                            </tr>  
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
<script>
    $(document).ready(function() {


    });
    
</script>
<?= $this->endSection() ?>