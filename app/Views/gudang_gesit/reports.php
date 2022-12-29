<?= $this->extend('gudang_gesit/layout/content') ?>

<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="row">
            <div class="col-xl-3">
            <form method="GET" action="<?= base_url('/gudang-gesit/laporan') ?>" id="date" >
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
    </div>
    <div class="card-body">        
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link font-weight-bold active" data-toggle="tab" href="#home">Kain</a>
            </li>
            <li class="nav-item">
                <a class="nav-link font-weight-bold" data-toggle="tab" href="#retur">Kain Retur</a>
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
            <li class="nav-item">
                <a class="nav-link font-weight-bold" data-toggle="tab" href="#menu4">Penjualan Reject</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content m-0">
            <div id="home" class="tab-pane active"><br>                
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary float-left">Data Kain</h6>
                        <?php if (!is_null($date1)) : ?>
                            <a class="btn btn-success float-right" href="<?= base_url('/export-data-kain/'. date('Y-m-d H:i:s', strtotime($date1)) . '/'. date('Y-m-d H:i:s', strtotime($date2))) ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
                        <?php else : ?>
                            <a class="btn btn-success float-right" href="<?= base_url('/export-data-kain') ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
                        <?php endif ?>
                        
                    </div>
                    <div class="card-body">        
                        <div class="table-responsive">            
                            <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 5%">No</th>
                                        <th class="text-center">Jenis</th>
                                        <th class="text-center">Warna</th>
                                        <th class="text-center">Berat (kg)/Yard</th>
                                        <th class="text-center">Tanggal Masuk</th>
                                        <th class="text-center">Vendor</th>
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
                                                <td><?= $kain->weight ?></td>
                                                <td class="text-center"><?= $kain->created_at ?></td>
                                                <td class="text-center"><?= $kain->vendor ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div id="retur" class="tab-pane fade"><br>                
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary float-left">Data Kain Retur</h6>
                        <?php if (!is_null($date1)) : ?>
                            <a class="btn btn-success float-right" href="<?= base_url('/export-data-kain-retur/'. date('Y-m-d H:i:s', strtotime($date1)) . '/'. date('Y-m-d H:i:s', strtotime($date2))) ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
                        <?php else : ?>
                            <a class="btn btn-success float-right" href="<?= base_url('/export-data-kain-retur') ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
                        <?php endif ?>
                        
                    </div>
                    <div class="card-body">        
                        <div class="table-responsive">            
                            <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 5%">No</th>
                                        <th class="text-center">Jenis</th>
                                        <th class="text-center">Warna</th>
                                        <th class="text-center">Berat (kg)/Yard</th>
                                        <th class="text-center">Tanggal Retur</th>
                                        <th class="text-center">Vendor</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php if ($kainRetur->getNumRows() > 0) : ?>
                                        <?php foreach ($kainRetur->getResultObject() as $kain) : ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td class=""><?= $kain->type ?></td>
                                                <td><?= $kain->color ?></td>
                                                <td><?= $kain->weight ?></td>
                                                <td class="text-center"><?= $kain->updated_at ?></td>
                                                <td class="text-center"><?= $kain->vendor ?></td>
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
                        <?php if (!is_null($date1)) : ?>
                            <a class="btn btn-success float-right" href="<?= base_url('/export-data-cutting/'. date('Y-m-d H:i:s', strtotime($date1)) . '/'. date('Y-m-d H:i:s', strtotime($date2))) ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>                            
                        <?php else : ?>
                            <a class="btn btn-success float-right" href="<?= base_url('/export-data-cutting') ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
                        <?php endif ?>
                        
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
                                                <td class="text-center align-middle"><?= $cutting->tgl?></td>
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
                                                    <?php foreach($timGelars->getResultObject() as $gelar) : ?>
                                                        <?php if ($gelar->id == $cutting->gelar1) :  ?>
                                                            <?= $gelar->name ?>
                                                        <?php endif ?>
                                                    <?php endforeach ?>
                                                    <br>
                                                    <small><mark id="gelar1_<?= $cutting->id ?>">Rp <?= number_format($cutting->biaya_gelar1, 0) ?></mark></small>
                                                </td>  
                                                <td class="text-center align-middle">   
                                                    <?php foreach($timGelars->getResultObject() as $gelar) : ?>
                                                        <?php if ($gelar->id == $cutting->gelar2) :  ?>
                                                            <?= $gelar->name ?>
                                                        <?php endif ?>
                                                    <?php endforeach ?>
                                                    <br>
                                                    <small><mark id="gelar2_<?= $cutting->id ?>">Rp <?= number_format($cutting->biaya_gelar2, 0) ?></mark></small>
                                                </td>  
                                                <td class="text-center align-middle">                                
                                                    <?php foreach($picCutting->getResultObject() as $pic) : ?>
                                                        <?php if ($pic->id == $cutting->pic) :  ?>
                                                            <?= $pic->name ?>
                                                        <?php endif ?>
                                                    <?php endforeach ?>
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
                        <?php if (!is_null($date1)) : ?>
                            <a class="btn btn-success float-right" href="<?= base_url('/export-data-pola-out/'. date('Y-m-d H:i:s', strtotime($date1)) . '/'. date('Y-m-d H:i:s', strtotime($date2))) ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>                            
                        <?php else : ?>
                            <a class="btn btn-success float-right" href="<?= base_url('/export-data-pola-out') ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
                        <?php endif ?>
                        
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
                                            <?php if ($pola->status == '1') : ?>
                                                <tr>                                    
                                                    <td class="text-center"><?= $no++ ?></td>
                                                    <td class="text-center font-weight-bold"><?= $pola->material_id ?></td>
                                                    <td class="text-center"><?= $pola->tgl_ambil?></td>
                                                    <td class="text-center"><?= $pola->tgl ?></td>
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
                        <?php if (!is_null($date1)) : ?>
                            <a class="btn btn-success float-right" href="<?= base_url('/export-data-pola-in/'. date('Y-m-d H:i:s', strtotime($date1)) . '/'. date('Y-m-d H:i:s', strtotime($date2))) ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
                        <?php else : ?>
                            <a class="btn btn-success float-right" href="<?= base_url('/export-data-pola-in') ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
                        <?php endif ?>
                        
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
                                        <th class="text-center">Harga Jahit</th>
                                        <th class="text-center">Harga HPP</th>
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
                                    <td class="text-center"><?= $pola->tgl_ambil ?></td>                                
                                    <td class="text-center"><?= $pola->model_name ?></td>
                                    <td class="text-center"><?= $pola->color ?></td>
                                    <td class="text-center"><?= $pola->jumlah_pola ?></td>
                                    <td class="text-center"><?= $pola->type ?></td>
                                    <td class="text-center"><?= $pola->name ?></td>
                                    <td class="text-center"><?= $pola->tgl_setor ?></td>                                
                                    <td class="text-center"><?= $pola->jumlah_setor ?></td>
                                    <td class="text-center"><?= $pola->reject ?></td>
                                    <td class="text-center"><?= $pola->sisa ?></td>
                                    <td class="text-center"><?= $pola->harga_jahit ?></td>
                                    <td class="text-center"><?= $pola->hpp ?></td>
                                    <td class="text-center"><?= $pola->hpp * $pola->jumlah_setor ?></td>
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
                        <?php if (!is_null($date1)) : ?>
                            <a class="btn btn-success float-right" href="<?= base_url('/export-produk-gesit/'. date('Y-m-d H:i:s', strtotime($date1)) . '/'. date('Y-m-d H:i:s', strtotime($date2))) ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
                        <?php else : ?>
                            <a class="btn btn-success float-right" href="<?= base_url('/export-produk-gesit') ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
                        <?php endif ?>
                       
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
                                        <th class="text-center">Qty</th>
                                        <th class="text-center">Tanggal Masuk</th>
                                        
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php if ($productsIn->getNumRows() > 0) : ?>
                                        <?php foreach ($productsIn->getResultObject() as $product) : ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td class="text-center"><?= $product->product_name ?></td>
                                                <td class="text-center"><?= $product->model_name ?></td>
                                                <td class="text-center"><?= $product->color ?></td>
                                                <td class="text-center"><?= $product->size ?></td>
                                                <td class="text-center"><?= $product->qty ?></td>
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
                        <?php if (!is_null($date1)) : ?>                            
                            <a class="btn btn-success float-right" href="<?= base_url('/export-produk-masuk-lovish/'. date('Y-m-d H:i:s', strtotime($date1)) . '/'. date('Y-m-d H:i:s', strtotime($date2))) ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
                        <?php else : ?>
                            <a class="btn btn-success float-right" href="<?= base_url('/export-produk-masuk-lovish') ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
                        <?php endif ?>
                        
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
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">Size</th>
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
                                                <td><?= $product->size ?></td>
                                                <td>Rp <?= number_format($product->price, 0) ?></td>
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
                        <h6 class="m-0 font-weight-bold text-primary float-left">Data Produk Reject</h6>
                        <?php if (!is_null($date1)) : ?>                            
                            <a class="btn btn-success float-right" href="<?= base_url('/export-produk-reject/'. date('Y-m-d H:i:s', strtotime($date1)) . '/'. date('Y-m-d H:i:s', strtotime($date2))) ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
                        <?php else : ?>
                            <a class="btn btn-success float-right" href="<?= base_url('/export-produk-reject') ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
                        <?php endif ?>
                        
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
                                        <th class="text-center">Size</th>
                                        <th class="text-center">Keterangan</th>
                                        <th class="text-center">Tanggal</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php if ($productReject->getNumRows() > 0) : ?>
                                        <?php foreach ($productReject->getResultObject() as $product) : ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td><?= $product->product_name ?></td>
                                                <td class="text-center"><?= $product->model_name ?></td>
                                                <td><?= $product->color ?></td>
                                                <td><?= $product->size ?></td>
                                                <td><?= strtoupper($product->category)?></td>
                                                <td class="text-center"><?= $product->date ?></td>
                                                
                                            </tr>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div id="menu4" class="tab-pane fade"><br>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary float-left">Data Penjualan Reject</h6>
                        <?php if (!is_null($date1)) : ?>
                            <a class="btn btn-success float-right" href="<?= base_url('/export-produk-penjualan-reject/'. date('Y-m-d H:i:s', strtotime($date1)) . '/'. date('Y-m-d H:i:s', strtotime($date2))) ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>                            
                        <?php else : ?>
                            <a class="btn btn-success float-right" href="<?= base_url('/export-produk-penjualan-reject') ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
                        <?php endif ?>
                        
                    </div>
                    <div class="card-body">
                        
                        <div class="table-responsive" id="tabel-penjualan-reject">
                            <table class="table table-bordered" id="dataTable6" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 5%">No</th>
                                        <th class="text-center">Tanggal Reject</th>   
                                        <th class="text-center">Tanggal Jual</th>   
                                        <th class="text-center">Produk</th>   
                                        <th class="text-center">Model</th>   
                                        <th class="text-center">Warna</th>   
                                        <th class="text-center">Size</th>   
                                        <th class="text-center">Jenis Reject</th>   
                                        <th class="text-center">Harga Jual</th>   
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $no = 1; ?>
                                    <?php if ($rejectedSold->getNumRows() > 0) : ?>
                                        <?php foreach ($rejectedSold->getResultObject() as $product) : ?>
                                            <tr class="">
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td class="text-center"><?= $product->date ?></td> 
                                                <td class="text-center"><?= $product->tanggal_jual ?></td> 
                                                <td><div><?= $product->product_name ?></div></td>
                                                <td class="text-center"><?= $product->model_name ?></td>                                
                                                <td class="text-center"><?= $product->color ?></td>   
                                                <td class="text-center"><?= $product->size ?></td>                         
                                                <td class="text-center"><?= strtoupper($product->category) ?></td>                                                                                       
                                                <td>Rp <?= number_format($product->hpp, 0) ?></td>
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