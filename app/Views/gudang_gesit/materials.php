<?= $this->extend('gudang_gesit/layout/content') ?>
<style>
    div.dataTables_wrapper {
        width: 800px;
        margin: 0 auto;
    }
</style>

<?= $this->section('content') ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css" integrity="sha512-Fppbdpv9QhevzDE+UHmdxL4HoW8HantO+rC8oQB2hCofV+dWV2hePnP5SgiWR1Y1vbJeYONZfzQc5iII6sID2Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">Daftar Kain Masuk</h6>
        <button class="btn btn-primary float-right" data-toggle="modal" data-target=".bd-example-modal-lg-kain"><i class="fa fa-plus mr-2"></i>Tambah Kain</button>
        <div class="modal fade bd-example-modal-lg-kain" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">                    
                    <form id="form-kain" action="<?= base_url('/tambah-kain') ?>" method="post">
                        <?php csrf_field() ?>
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Kain Baru</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Jenis Kain*</label>
                                        <select class="form-control jenis-kain" name="jenis" required>
                                        <option value="">-</option>
                                            <?php if ($materials->getNumRows() > 0) : ?>
                                                <?php foreach ($materials->getResultObject() as $material) : ?>
                                                    <option value="<?= $material->id ?>"><?= $material->type ?></option>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                        </select>                             
                                    </div>                            
                                    <div class="form-group">
                                        <label for="">Warna*</label>
                                        <select class="form-control" name="warna">
                                            <option value="">-</option>
                                        <?php if ($colors->getNumRows() > 0) : ?>
                                            <?php foreach ($colors->getResultObject() as $color) : ?>
                                                <option value="<?= $color->id ?>"><?= $color->color ?></option>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                        </select>    
                    
                                    </div>                                   
                                    <div class="form-group">
                                        <label for="">Vendor Kain*</label>
                                        <select class="form-control vendor-kain" name="vendor" required>                                            
                                            <option value="">-</option>
                                            <?php if ($materialVendors->getNumRows() > 0) : ?>
                                                <?php foreach ($materialVendors->getResultObject() as $vendor) : ?>
                                                    <option value="<?= $vendor->id ?>"><?= $vendor->vendor ?></option>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                        </select>    
                    
                                    </div>
                                    <div class="form-group">
                                        <label for="">Harga Kain</label>
                                        <input type="text" class="form-control harga-kain" name="harga" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="..." required>                                
                                    </div> 
                                    <div class="form-group">
                                        <label for="">Berat (Kg)/Yard</label>
                                        <input type="text" class="form-control" name="berat" id="tambah-berat" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="...">                                        
                                    </div>  
                                    <div class="form-group">
                                        <label for="">Roll</label>
                                        <input type="text" class="form-control" name="roll" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" value="1" placeholder="Masukkan jumlah roll">                                
                                    </div>                                                                
                                </div>
                                <!-- <div class="col">
                                    <div class="form-group">
                                        <label for="">Tgl Cutting</label>
                                        <input type="text" class="form-control" name="tgl-cutting-old" value="-" disabled>                                
                                    </div>     
                                    <div class="form-group">
                                    <label for="">Gelar 1*</label>
                                        <select class="form-control" name="gelar1">
                                            <option value="">-</option>
                                        <?php if ($timGelars->getNumRows() > 0) : ?>
                                            <?php foreach ($timGelars->getResultObject() as $gelar1) : ?>
                                                <option value="<?= $gelar1->id ?>"><?= $gelar1->name ?></option>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                        </select>      
                    
                                    </div>
                                    <div class="form-group">
                                        <label for="">Gelar 2*</label>
                                        <select class="form-control" name="gelar2">
                                            <option value="">-</option>
                                        <?php if ($timGelars->getNumRows() > 0) : ?>
                                            <?php foreach ($timGelars->getResultObject() as $gelar2) : ?>
                                                <option value="<?= $gelar2->id ?>"><?= $gelar2->name ?></option>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                        </select>    
                                    </div>
                                    <div class="form-group">
                                        <label for="">PIC Cutting*</label>                                            
                                        <select class="form-control" name="pic-cutting">
                                        <option value="">-</option>
                                        <?php if ($picCutting->getNumRows() > 0) : ?>
                                            <?php foreach ($picCutting->getResultObject() as $cut) : ?>
                                                <option value="<?= $cut->id ?>"><?= $cut->name ?></option>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                        </select>    
                    
                                    </div>
                                    <div class="form-group">
                                        <label for="">Gudang*</label>                                            
                                        <select class="form-control" name="gudang">
                                        <?php if ($gudangs->getNumRows() > 0) : ?>
                                            <?php foreach ($gudangs->getResultObject() as $gudang) : ?>
                                                <option value="<?= $gudang->id ?>"><?= $gudang->gudang ?></option>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                        </select>                
                                    </div>
                                    
                                    
                                </div> -->
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" id="submit-form-kain" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive" id="tabel-kain">
            <table class="table table-bordered display nowrap" id="dataTable2" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th class="text-center" style="width: 5%">Kode Kain</th>
                        <th class="text-center">Jenis</th>
                        <th class="text-center">Warna</th>
                        <th class="text-center">Berat (Kg)/Yard</th>
                        <th class="text-center">Tgl Masuk</th>                                                
                        <th class="text-center">Vendor</th>
                        <th class="text-center">Harga</th>
                        <th class="text-center">Posisi Gd.</th>
                        <th class="text-right"><i class="fa fa-fas fa-angle-down"></i></th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php $no = 1; ?>
                    <?php if ($materialsIn->getNumRows() > 0) : ?>
                        <?php $id = ""; $timGelar = array('', ''); $len = count($materialsIn->getResultObject()); $i = 0;?>
                       
                        <?php foreach ($materialsIn->getResultObject() as $kain) : ?>                                                     
                            <tr>
                                <td class="text-center align-middle"><?= $no++ ?></td>    
                                <td class="text-center font-weight-bold align-middle"><?= $kain->material_id ?></td>                            
                                <td class="">
                                    <select class="form-control jenis" data-id="<?= $kain->id ?>" name="jenis">                                         
                                        <?php foreach ($materials->getResultObject() as $material) : ?>
                                            <option value="<?= $material->id ?>" <?= $material->id == $kain->material_type ? 'selected="selected" ' : ''; ?> ><?= $material->type ?></option>
                                        <?php endforeach ?>                                        
                                    </select>    
                                </td>
                                <td>
                                    <select class="form-control warna" name="warna" data-id='<?= $kain->id ?>'>
                                        <?php foreach ($colors->getResultObject() as $color) : ?>
                                            <option value="<?= $color->id ?>" <?= $color->id == $kain->color_id ? 'selected="selected"' : ''; ?> ><?= $color->color ?></option>
                                        <?php endforeach ?>
                                    </select>   
                                </td>                                
                                <td>
                                    <input type="text" class="form-control berat" name="weight" data-id='<?= $kain->id ?>' value="<?= number_format($kain->total_berat, 2) ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"></td>
                                </td>
                                <td class="text-center align-middle"><?= date('m/d/Y', strtotime($kain->created_at)) ?></td>                                
                                <td class="text-center">
                                    <select class="form-control vendor-kain-edit" name="vendor" data-id='<?= $kain->id ?>'>                                        
                                        <?php foreach ($materialVendors->getResultObject() as $vendor) : ?>
                                            <option value="<?= $vendor->id ?>" <?= $vendor->id == $kain->vendor_id ? 'selected="selected"' : '' ?> ><?= $vendor->vendor ?></option>
                                        <?php endforeach ?>
                                    </select>    
                                </td>
                                <td>
                                    <input type="text" class="form-control harga" name="price" data-id='<?= $kain->id ?>' value="<?= $kain->price ?>"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"></td>
                                </td>                                
                                <td class="text-center">
                                    <select class="form-control gudang" data-id="<?= $kain->id ?>" name="gudang" >
                                        <?php foreach ($gudangs->getResultObject() as $gudang) : ?>
                                            <option value="<?= $gudang->id ?>" <?= $gudang->id == $kain->gudang_id ? 'selected="selected"' : ''; ?> ><?= $gudang->gudang ?></option>
                                        <?php endforeach ?>
                                    </select> 
                                    
                                </td>                                                                
                                <td class="text-center">
                                    <div class="action">                                    
                                        <a href="" data-toggle="modal" class="btn btn-danger btn-icon-split btn-sm btn-hapus" data-id='<?= $kain->id ?>'>
                                            <span class="icon text-white-25">
                                                <i class="fas fas fa-trash"></i>
                                            </span>
                                        </a>
                                    </div>
                                </td>
                            </tr> 
                            <?php $id = $kain->id; $i++?>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
        
    </div>
</div>
<?php $access = json_decode(session()->get('accessibility')); ?>
<?php
    if (in_array("3", $access)) {
        ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary float-left">Data Cutting</h6>
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
                                    <th class="text-center">Size</th>
                                    <th class="text-center" style="width: 5%;">Qty</th>
                                    <th class="text-center">Berat (Kg)/Yard</th>
                                    <th class="text-center">Gelar 1</th>
                                    <th class="text-center">Gelar 2</th>                        
                                    <th class="text-center">PIC</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Ket COA</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php $no = 1; ?>
                                <?php if ($cuttings->getNumRows() > 0) : ?>
                                    <?php foreach ($cuttings->getResultObject() as $cutting) : ?>
                                        <?php if (is_null($cutting->pid)) : ?>
                                            <tr>
                                                <td class="text-center align-middle"><?= $no++ ?></td>
                                                <td class="text-center font-weight-bold align-middle"><?= $cutting->mid ?></td>
                                                <td class="text-center align-middle"><?= date('m/d/Y', strtotime($cutting->tgl)) ?></td>
                                                <td class="text-center align-middle">
                                                    <select class="form-control jenis-produk" name="nama_produk" data-id='<?= $cutting->id ?>'>
                                                        <option value=''>-</option>
                                                        <?php foreach ($models->getResultObject() as $model) : ?>
                                                            <option value="<?= $model->id ?>" <?= ($model->id == $cutting->model_id) ? 'selected="selected"': '' ?>><?= $model->model_name ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </td>
                                                <td class="text-center align-middle"><?= $cutting->color ?></td>
                                                <td class="text-center align-middle"><button class="btn btn-success btn-sm set-size" data-id="<?= $cutting->id ?>">Set Size</button></td>
                                                <td class="text-center align-middle">
                                                    <input type="text" class="form-control text-center qty-cutting" name="qty" data-id='<?= $cutting->id ?>' data-gelar='<?= $cutting->harga_gelar ?>' data-cutting='<?= $cutting->harga_cutting ?>'  value="<?= $cutting->qty ?>"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                </td>
                                                <td class="text-center align-middle">
                                                    <input type="text" class="form-control text-center berat-cutting" name="berat" data-id='<?= $cutting->id ?>' data-material='<?= $cutting->material_id ?>'  value="<?= number_format($cutting->berat, 1) ?>"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                </td>
                                                <td class="text-center align-middle">                                
                                                    <select name="gelar1" data-id="<?= $cutting->id ?>" class="form-control gelar1">
                                                        <option value="">-</option>
                                                       <?php foreach($timGelars->getResultObject() as $gelar) : ?>
                                                            <option value="<?= $gelar->id ?>" <?= ($gelar->id == $cutting->gelar1) ? 'selected' : '' ?>><?= $gelar->name ?></option>
                                                        <?php endforeach ?>
                                                    </select>                                                      
                                                    <small><mark id="gelar1_<?= $cutting->id ?>">Rp <?= number_format($cutting->biaya_gelar1, 0) ?></mark></small>
                                                </td>  
                                                <td class="text-center align-middle">   
                                                    <select name="gelar2" data-id="<?= $cutting->id ?>" class="form-control gelar2">
                                                        <option value="">-</option>
                                                       <?php foreach($timGelars->getResultObject() as $gelar) : ?>
                                                            <option value="<?= $gelar->id ?>" <?= ($gelar->id == $cutting->gelar2) ? 'selected' : '' ?>><?= $gelar->name ?></option>
                                                        <?php endforeach ?>
                                                    </select>                                                      
                                                    <small><mark id="gelar2_<?= $cutting->id ?>">Rp <?= number_format($cutting->biaya_gelar2, 0) ?></mark></small>
                                                </td>  
                                                <td class="text-center align-middle">                                
                                                    <select name="pic_cutting" data-id="<?= $cutting->id ?>" class="form-control pic">
                                                        <option value="">-</option>
                                                       <?php foreach ($picCutting->getResultObject() as $pic) : ?>
                                                            <option value="<?= $pic->id ?>" <?= ($pic->id == $cutting->pic) ? 'selected' : '' ?>><?= $pic->name ?></option>
                                                        <?php endforeach ?>
                                                    </select>                                                    
                                                    <small><mark id="pic_<?= $cutting->id ?>">Rp <?= number_format($cutting->biaya_cutting, 0) ?></mark></small>
                                                </td>  
                                                <td class="text-center font-weight-bold align-middle" id="total_<?= $cutting->id ?>">Rp <?= number_format($cutting->total) ?></td>  
                                                <td class="text-center align-middle">                                        
                                                    <a href="" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-info-circle fa-lg mr-2"></i></a>
                                                    <a href="" data-toggle="modal"  class="pola-out" data-id="<?= $cutting->id ?>" ><i class="fa fa-sign-out-alt fa-lg text-success mr-2"></i></a>
                                                    <a href="" data-toggle="modal"  class="delete-cutting" data-id="<?= $cutting->id ?>" ><i class="fa fa-minus-square fa-lg text-danger"></i></a>
                                                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
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
                                                                                <th scope="col">GELAR</th>
                                                                                <th scope="col">CUTTING</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>Rp <?= number_format($cutting->harga_gelar) ?></td>
                                                                                <td>Rp <?= number_format($cutting->harga_cutting) ?></td>
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
                                        <?php else : ?>
                                            <?php if ($cutting->status == 1) : ?>
                                                <tr class="table-active" id="td_<?= $cutting->id ?>">
                                            <?php elseif ($cutting->status == 2) : ?>
                                                
                                            <?php else : ?>
                                                <tr class="table-danger" id="td_<?= $cutting->id ?>">
                                            <?php endif ?>
                                                <td class="text-center align-middle"><?= $no++ ?></td>
                                                <td class="text-center font-weight-bold align-middle"><?= $cutting->mid ?></td>
                                                <td class="text-center align-middle"><?= date('m/d/Y h:i A', strtotime($cutting->tgl)) ?></td>
                                                <td class="text-center align-middle">
                                                    <select class="form-control jenis-produk-pola" name="nama_produk" data-id='<?= $cutting->id ?>' id="produk_edit_<?= $cutting->id ?>" disabled>
                                                        <option value='0'>-</option>
                                                        <?php foreach ($models->getResultObject() as $model) : ?>
                                                            <option value="<?= $model->id ?>" <?= ($model->id == $cutting->model_id) ? 'selected="selected"': '' ?>><?= $model->model_name ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </td>
                                                <td class="text-center align-middle"><?= $cutting->color ?></td>
                                                <td class="text-center align-middle"><button class="btn btn-secondary btn-sm" disabled data-id="<?= $cutting->id ?>">Set Size</button></td>
                                                <td class="text-center align-middle">
                                                    <input type="text" class="form-control text-center qty-cutting-pola" disabled id="qty_edit_<?= $cutting->id ?>" name="qty" data-id='<?= $cutting->id ?>' data-gelar='<?= $cutting->harga_gelar ?>' data-cutting='<?= $cutting->harga_cutting ?>'  value="<?= $cutting->qty ?>"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" >
                                                </td>
                                                <td class="text-center align-middle">
                                                    <input type="text" class="form-control text-center berat-cutting" id="berat_edit_<?= $cutting->id ?>" name="berat" data-id='<?= $cutting->id ?>' data-gelar='<?= $cutting->harga_gelar ?>' data-cutting='<?= $cutting->harga_cutting ?>'  value="<?= number_format($cutting->berat, 1) ?>"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" disabled>
                                                </td>
                                                <td class="text-center align-middle">                                
                                                    <select name="gelar1" id="" class="form-control" disabled>
                                                        <option value="">-</option>
                                                       <?php foreach($timGelars->getResultObject() as $gelar) : ?>
                                                            <option value="<?= $gelar->id ?>" <?= ($gelar->id == $cutting->gelar1) ? 'selected' : '' ?>><?= $gelar->name ?></option>
                                                        <?php endforeach ?>
                                                    </select>  
                                                    <small><mark id="gelar1_<?= $cutting->id ?>">Rp <?= number_format($cutting->biaya_gelar1, 0) ?></mark></small>
                                                </td>  
                                                <td class="text-center align-middle">   
                                                    <select name="gelar2" id="" class="form-control" disabled>
                                                        <option value="">-</option>
                                                       <?php foreach($timGelars->getResultObject() as $gelar) : ?>
                                                            <option value="<?= $gelar->id ?>" <?= ($gelar->id == $cutting->gelar2) ? 'selected' : '' ?>><?= $gelar->name ?></option>
                                                        <?php endforeach ?>
                                                    </select>  
                                                    <small><mark id="gelar2_<?= $cutting->id ?>">Rp <?= number_format($cutting->biaya_gelar2, 0) ?></mark></small>
                                                </td>  
                                                <td class="text-center align-middle">                                
                                                    <select name="pic_cutting" id="" class="form-control" disabled>
                                                       <?php foreach ($picCutting->getResultObject() as $pic) : ?>
                                                            <option value="<?= $pic->id ?>" <?= ($pic->id == $cutting->pic) ? 'selected' : '' ?>><?= $pic->name ?></option>
                                                        <?php endforeach ?>
                                                    </select>   
                                                    <small><mark id="pic_<?= $cutting->id ?>">Rp <?= number_format($cutting->biaya_cutting, 0) ?></mark></small>
                                                </td>  
                                                <td class="text-center font-weight-bold align-middle" id="total_<?= $cutting->id ?>">Rp <?= number_format($cutting->total) ?></td>  
                                                <td class="text-center align-middle">
                                                    <a href="" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-info-circle fa-lg mr-2"></i></a>
                                                    <a href="" data-toggle="modal" class="editable-cutting" data-id="<?= $cutting->id ?>"><i class="fa fa-edit fa-lg text-secondary"></i></a>
                                                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="diaxlog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
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
                                                                                <th scope="col">GELAR</th>
                                                                                <th scope="col">CUTTING</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>Rp <?= number_format($cutting->harga_gelar) ?></td>
                                                                                <td>Rp <?= number_format($cutting->harga_cutting) ?></td>
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
                        <div class="modal fade" id="modalSize" tabindex="-1" role="diaxlog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form id="form-size">
                                        <input type="hidden" name="cutting_id" class="cutting_id">
                                        <input type="hidden" class="total-qty">
                                        <div class="modal-header">                                    
                                            <h6><mark>Total Qty : <span id="total-qty"></span></mark></h6>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">                                            
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">S</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control size-s" name="s" value="0" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">M</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control size-m" name="m" value="0" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">L</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control size-l" name="l" value="0" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">XL</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control size-xl" name="xl" value="0" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">XXL</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control size-xxl" name="xxl" value="0" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="form-check">
                                                    <input class="form-check-input no-size" name="nosize" type="checkbox" value="1" id="flexCheckDefault">
                                                    <label class="form-check-label" for="flexCheckDefault" style="margin-top: 3px;">
                                                        Tidak ada size
                                                    </label>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary submit-size">Simpan</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modalSizeProduk" tabindex="-1" role="diaxlog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form id="form-size-produk">
                                        <input type="hidden" name="cutting_id" class="cutting_id">
                                        <input type="hidden" class="total-qty-produk">
                                        <div class="modal-header">                                    
                                            <h6><mark>Jumlah Setor : <span id="total-qty-produk"></span></mark></h6>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">                                            
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">S</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control size-s-produk" name="s" value="0" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">M</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control size-m-produk" name="m" value="0" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">L</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control size-l-produk" name="l" value="0" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">XL</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control size-xl-produk" name="xl" value="0" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-sm-2 col-form-label">XXL</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control size-xxl-produk" name="xxl" value="0" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="form-check">
                                                    <input class="form-check-input no-size-produk" name="nosize" onclick="return false;" type="checkbox" value="1" id="flexCheckDefault">
                                                    <label class="form-check-label" for="flexCheckDefault" style="margin-top: 3px;">
                                                        Tidak ada size
                                                    </label>
                                                </div>
                                            
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary submit-size">Create Produk</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="polaOutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form class="pola-out" action="<?= base_url('/save-pola-keluar') ?>" method="post">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="id" value="" id="cutting">
                                    <input type="hidden" name="berat" value="" id="berat-pola-out">
                                    <input type="hidden" name="material" value="" id="material-pola-out">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="">Input Pola</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="">Tanggal Ambil</label>
                                                <input type="text" name="tgl-pola" value="<?= date("m/d/Y h:i A") ?>"  class="form-control tgl-pola" readonly>                                    
                                            </div>
                                            <div class="form-group">
                                                <label for="">Jumlah Pola</label>
                                                <input type="text" name="jumlah-pola" class="form-control" id="jumlahPola" aria-describedby="" placeholder="Jumlah Pola" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">                                    
                                                <input type="hidden" name="total-pola" id="jumlahPolaHide">
                                            </div>
                                            <div class="form-group">
                                                <label for="">Vendor Pola</label>
                                                <select class="form-control" name="vendor">
                                                    <?php foreach($vendorPola->getResultObject() as $vendor) : ?>
                                                        <option value="<?= $vendor->id ?>"><?= $vendor->name ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        <?php
    }
?>
<?php 
    if (in_array("8", $access)) {
?>
        <div class="card shadow mb-4" id="pola-out-section">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left" >Data Pola (Keluar)</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="tabel-pola-out">
                    <table class="table table-bordered" id="dataTable5" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th class="text-center">Kode Kain</th>
                                <th class="text-center">Tgl Ambil</th>
                                <th class="text-center">Tgl Cutting</th>
                                <th class="text-center">Produk</th>
                                <th class="text-center">Warna</th>
                                <th class="text-center" style="width: 10%">Jumlah</th>
                                <th class="text-center">Bahan</th>
                                <th class="text-center">Vendor</th>
                                <th class="text-right" style="width: 7%"><i class="fa fa-ellipsis-v"></i></th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php $no = 1; ?>
                            <?php if ($polaOut->getNumRows() > 0) : ?>
                                <?php $temp = "" ?>
                                
                                <?php foreach ($polaOut->getResultObject() as $pola) : ?>
                                    <?php if ($temp == $pola->cutting_id) : ?>                                
                                        <?php continue ?>
                                    <?php else : ?>
                                        <?php $temp = $pola->cutting_id ?>
                                        
                                    <?php endif ?>
                                    <?php if ($pola->jum == '1') : ?>
                                        <tr id="td_pola_<?= $pola->id ?>">                                 
                                            <td class="text-center align-middle"><?= $no++ ?></td>
                                            <td class="text-center align-middle font-weight-bold"><?= $pola->material_id ?></td>
                                            <td class="text-center align-middle"><?= date('m/d/Y h:i A', strtotime($pola->tgl_ambil)) ?></td>
                                            <td class="text-center align-middle"><?= date('m/d/Y h:i A', strtotime($pola->tgl)) ?></td>
                                            <td class="text-center align-middle" id="pola_out_produk_<?= $pola->cutting_id ?>"><?= $pola->model_name ?></td>
                                            <td class="text-center align-middle"><?= $pola->color ?></td>
                                            <td class="text-center align-middle"><input type="text" id="pola_out_jumlah_<?= $pola->cutting_id ?>" value="<?= $pola->jumlah_pola ?>" data-id="<?= $pola->cutting_id ?>" data-jum="<?= $pola->jumlah_pola ?>" class="form-control text-center pola-out-jumlah-edit" disabled></td>
                                            <td class="text-center align-middle"><?= $pola->type ?></td>
                                            <td class="text-center align-middle">
                                                <select class="form-control" >
                                                    <?php foreach($vendorPola->getResultObject() as $vendor) : ?>
                                                        <option value="<?= $vendor->id ?>" <?= ($vendor->id == $pola->vendor_id) ? 'selected="selected"' : '' ?> > <?= $vendor->name ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </td>
                                            <td class="text-center align-middle">                                        
                                                <a href="" class="pola-in" data-toggle="modal" data-id="<?= $pola->id ?>" data-jumlah="<?= $pola->jumlah_pola ?>"><i class="fa fa-sign-in-alt fa-lg text-secondary"></i></a>                                    
                                            </td>  
                                        </tr>
                                    <?php else : ?>
                                            <tr class="table-active" id="td_pola_<?= $pola->id ?>">
                                                <td class="text-center align-middle"><?= $no++ ?></td>
                                                <td class="text-center align-middle font-weight-bold"><?= $pola->material_id ?></td>
                                                <td class="text-center align-middle"><?= date('m/d/Y h:i A', strtotime($pola->tgl_ambil)) ?></td>
                                                <td class="text-center align-middle"><?= date('m/d/Y h:i A', strtotime($pola->tgl)) ?></td>
                                                <td class="text-center align-middle" id="pola_out_produk_<?= $pola->cutting_id ?>"><?= $pola->model_name ?></td>
                                                <td class="text-center align-middle"><?= $pola->color ?></td>
                                                <td class="text-center align-middle"><input type="text" id="pola_out_jumlah_<?= $pola->cutting_id ?>" value="<?= $pola->sisa ?>" data-id="<?= $pola->cutting_id ?>" data-jum="<?= $pola->sisa ?>" class="form-control text-center pola-out-jumlah-edit" disabled></td>
                                                <td class="text-center align-middle"><?= $pola->type ?></td>
                                                <td class="text-center align-middle">
                                                    <select class="form-control pola-out-vendor-edit" data-id="<?= $pola->cutting_id ?> " id="pola_out_vendor_<?= $pola->id ?>" disabled>
                                                        <?php foreach($vendorPola->getResultObject() as $vendor) : ?>
                                                            <option value="<?= $vendor->id  ?>" <?= ($vendor->id == $pola->vendor_id) ? 'selected="selected"' : '' ?> > <?= $vendor->name ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <a href="" data-toggle="modal" class="editable-polaout" data-id="<?= $pola->id ?>"><i class="fa fa-edit fa-lg text-secondary"></i></a>
                                                    <a href="" class="pola-in" data-toggle="modal" data-id="<?= $pola->id ?>" data-jumlah="<?= $pola->sisa ?>"><i class="fa fa-sign-in-alt fa-lg text-secondary"></i></a>                                    
                                                </td>  
                                            </tr>
                                    <?php endif ?>
                                <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal fade" id="polaInModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form action="<?= base_url('/save-pola-masuk') ?>" method="post">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="" id="pid">
                            <input type="hidden" name="cutting-id" value="" id="cuttingid">
                            <input type="hidden" name="vendor-id" value="" id="vendorid">
                            <input type="hidden" name="model-id" value="" id="modelid">
                            <input type="hidden" name="hargajahit" value="" id="modelharga">
                            <input type="hidden" name="tgl-ambil" value="" id="tglambil">
                            <input type="hidden" name="jumlah" value="" id="jumlah">                    
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="">Input Pola Masuk</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Tanggal Setor</label>
                                        <input type="text" name="tgl-setor" value="<?= date("m/d/Y h:i A") ?>"  class="form-control tgl-pola" readonly>                                    
                                    </div>
                                    <div class="form-group">
                                        <label for="">Jumlah Setor <small>(Jumlah ambil: <b id="jumlah-ambil">0</b>)</small></label>
                                        <input type="text" name="jumlah-setor" class="form-control" aria-describedby="" placeholder="Jumlah Pola" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">                                    
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="">Reject</label>
                                        <input type="text" name="reject" class="form-control" aria-describedby="" placeholder="Jumlah Reject" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">                                    
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="card shadow mb-4" id="tabel-pola-in">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left">Data Pola (Masuk)</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered display nowrap"  id="dataTable4" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th class="text-center" style="width: 5%">Kode Kain</th>                        
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
                                        <?php if (is_null($pola->pola_id)) : ?>
                                            <tr class="table-info" id="td_polain_<?= $pola->id ?>">
                                        <?php else : ?>
                                            <tr class="table-success" id="td_polain_<?= $pola->id ?>">
                                        <?php endif ?>
                                            <td class="text-center align-middle"><?= $no++ ?></td>
                                            <td class="text-center align-middle" font-weight-bold"><?= $pola->material_id ?></td>
                                            <td class="text-center align-middle"><?= date('m/d/Y h:i A', strtotime($pola->tgl_ambil)) ?></td>                                
                                            <td class="text-center align-middle" id="pola_in_produk_<?= $pola->id ?>"><?= $pola->model_name ?></td>
                                            <td class="text-center align-middle"><?= $pola->color ?></td>
                                            <td class="text-center align-middle" id="pola_in_jumlah_<?= $pola->cutting_id ?>"><?= $pola->jumlah_pola ?></td>
                                            <td class="text-center align-middle"><?= $pola->type ?></td>
                                            <td class="text-center align-middle" id="pola_in_vendor_<?= $pola->cutting_id ?>"><?= $pola->name ?></td>
                                            <td class="text-center align-middle"><?= date('m/d/Y h:i A', strtotime($pola->tgl_setor)) ?></td>                                
                                            <td class="text-center align-middle">
                                                <input type="text" class="form-control text-center pola-in-jumlah-setor" id="pola_in_jumlah_setor_<?= $pola->id ?>" data-id="<?= $pola->id ?>" value="<?= $pola->jumlah_setor ?>" disabled>
                                            </td>
                                            <td class="text-center align-middle">
                                                <input type="text" class="form-control text-center pola-in-reject" id="pola_in_reject_<?= $pola->id ?>" data-id="<?= $pola->id ?>" value="<?= $pola->reject ?>" disabled>
                                            </td>
                                            <td class="text-center align-middle" id="pola_in_sisa_<?= $pola->id ?>"><?= ($pola->jumlah_pola - ($pola->jumlah_setor + $pola->reject) ) ?></td>
                                            <td class="text-center align-middle" id="pola_in_sisa_<?= $pola->id ?>"><?= $pola->harga_jahit ?></td>
                                            <td class="text-center align-middle">Rp <?= number_format($pola->hpp, 0) ?></td>
                                            <td class="text-center align-middle">Rp <?= number_format($pola->hpp * $pola->jumlah_setor, 0) ?></td>
                                            <td class="text-center align-middle">
                                                <a href="" data-toggle="modal" data-target="#infoPolaIn"><i class="fa fa-info-circle fa-lg mr-2"></i></a>                                
                                                <?php if (is_null($pola->pola_id)) : ?>
                                                    <a href="" data-toggle="modal" class="editable-polain" data-id="<?= $pola->id ?>"><i class="fa fa-edit fa-lg text-secondary mr-2"></i></a>
                                                    <a href="" data-toggle="modal" class="create-produk" data-id="<?= $pola->id ?>"><i class="fa fa-sign-out-alt fa-lg text-primary"></i></a>
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
                                                <?php endif ?>
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
<?php
    }
    
?>



<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js" integrity="sha512-efUTj3HdSPwWJ9gjfGR71X9cvsrthIA78/Fvd/IN+fttQVy7XWkOAXb295j8B3cmm/kFKVxjiNYzKw9IQJHIuQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {    
    
        $('.tgl-pola').datepicker();
        $('.tgl-cutting-edit').datepicker();
                
    });

    $(document).on('click', '.btn-edit', function() {
        const id = $(this).data('id');
        $.get('/get-size-cutting', {material_id: id})
            .done(function(data) {
                const size = JSON.parse(data);
                
            });
        $('.').modal('show');
    });

    $(document).on('click', '.btn-edit', function() {
        const id = $(this).data('id');
        $.get('/get-kain-detail', {id: id})
            .done(function(data) {
                const kain = JSON.parse(data);
                
                $('#id-kain').val(kain['id']);
                $('#jenis').val(kain['material_id']);
                $('#warna').val(kain['color_id']);
                $('#berat').val(kain['weight']);
                $('.vendor-kain-edit').val(kain['vendor_id']);
                $('.harga-kain-edit').val(kain['price']);
                $('#gudang').val(kain['gudang_id']);
            });
        $('.bd-example-modal-lg-kain-edit').modal('show');
    });

    $(document).on('click', '.btn-hapus', function() {
        const id = $(this).data('id');
        swal({
            title: "Apakah anda yakin?",
            text: "Data yang anda hapus tidak akan kembali lagi",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                swal("Poof! Data berhasil dihapus!", {
                icon: "success",
                });
                $.post('/delete-kain-detail', {material_id: id})
                    .done(function(data) {
                        setTimeout(location.reload.bind(location), 1000);                           
                    });
            } else {
                swal("Data tidak jadi dihapus!");
            }
        });
    });

    $(document).on('click', '.delete-cutting', function() {
        const id = $(this).data('id');
        swal({
            title: "Apakah anda yakin?",
            text: "Data yang anda hapus tidak akan kembali lagi",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                swal("Poof! Data berhasil dihapus!", {
                icon: "success",
                });
                $.post('/delete-cutting-pola', {cutting: id})
                    .done(function(data) {
                        setTimeout(location.reload.bind(location), 1000);                           
                    });
            } else {
                swal("Data tidak jadi dihapus!");
            }
        });
    });

    $(document).on('click', '.create-produk', function() {
        const id = $(this).data('id');
        $('#total-qty-produk').html("");
        $('.total-qty-produk').html("");
        $('.size-s-produk').val("");
        $('.size-m-produk').val("");
        $('.size-l-produk').val("");
        $('.size-xl-produk').val("");
        $('.size-xxl-produk').val("");
        $.get('/get-size-pola', {id: id} ,function(data) {
            const res = JSON.parse(data);
            $('#total-qty-produk').html(res['qty']);
            $('.total-qty-produk').val(res['qty']);
            $('.cutting_id').val(id);        
            
            if (res['nosize'] != null) {
                $('.no-size-produk').val(res['qty']);
                $('.no-size-produk').prop('checked', true);
                $('.size-s-produk').prop('disabled', true);
                $('.size-m-produk').prop('disabled', true);
                $('.size-l-produk').prop('disabled', true);
                $('.size-xl-produk').prop('disabled', true);
                $('.size-xxl-produk').prop('disabled', true);
            } else {
                $('.size-s-produk').val(res['s']);
                $('.size-m-produk').val(res['m']);
                $('.size-l-produk').val(res['l']);
                $('.size-xl-produk').val(res['xl']);
                $('.size-xxl-produk').val(res['xxl']);
                $('.no-size-produk').prop('checked', false);
                $('.no-size-produk').prop('disabled', true);
                $('.size-s-produk').prop('disabled', false);
                $('.size-m-produk').prop('disabled', false);
                $('.size-l-produk').prop('disabled', false);
                $('.size-xl-produk').prop('disabled', false);
                $('.size-xxl-produk').prop('disabled', false);
            }
            $('#modalSizeProduk').modal('show');
        });        
    });

    $('form#form-size-produk').on('submit', function (e) {
        e.preventDefault();
        var s = $('.size-s-produk').val();
        var m = $('.size-m-produk').val();
        var l = $('.size-l-produk').val();
        var xl = $('.size-xl-produk').val();
        var xxl = $('.size-xxl-produk').val();
        var qty = $('.total-qty-produk').val();

        var total = (parseInt(s) + parseInt(m) + parseInt(l) + parseInt(xl) + parseInt(xxl));
        console.log(qty);
        if (qty != total )  {
            if ($('input.no-size-produk').prop('checked')) {
                $.post('/create-produk', $('form#form-size-produk').serialize(), function(data) {            
                $.notify('Produk Berhasi dimuat', "success"); 
                $('#modalSizeProduk').modal('hide');
            });
            } else {
                $.notify('Total size berbeda dengan jumlah setor', "error"); 
            }
            
        } else {
            $.post('/create-produk', $('form#form-size-produk').serialize(), function(data) {            
                $.notify('Size berhasil disimpan', "success"); 
                $('#modalSizeProduk').modal('hide');
            });
        }
        
    });

    $('.pola-out').on('click', function() {
        const id = $(this).data('id');
        $.get('/get-cutting', {id: id}, function(data) {
            const cutting = JSON.parse(data);   
            console.log(cutting);
            $('#jumlahPola').val(cutting['qty']);
            $('#jumlahPolaHide').val(cutting['qty']);
            $('#cutting').val(id);
            $('#berat-pola-out').val(cutting['berat']);
            $('#material-pola-out').val(cutting['material_id']);
            if (cutting['s'] == null && cutting['nosize'] == null) {
                swal("Size belum di-set");
            } else {
                $('#polaOutModal').modal('show');
            }
            
        });
    });

    $('.pola-in').on('click', function() {
        const id = $(this).data('id');
        const jumlah = $(this).data('jumlah');
        var total = 0;
        $('#jumlah-ambil').html("");
        $('#pid').val(id);
        $('#jumlah-ambil').html(jumlah);

        $.get('/get-pola-out', {id: id}, function(data) {
            const pola = JSON.parse(data);   
            console.log(pola);
            $('#cuttingid').val(pola['cutting_id']);
            $('#vendorid').val(pola['vendor_id']);
            $('#tglambil').val(pola['tgl_ambil']);
            $('#jumlah').val(jumlah);
            $('#modelid').val(pola['model_id']);
            $('#modelharga').val(pola['harga_jahit']);
            $('#polaInModal').modal('show');
            
        });
        
    });

    // kain    
    $('.jenis-kain').change(function() {
        const id = $(this).val();
        $.get('/get-jenis-kain', {id: id}, function(data) {
            const price = JSON.parse(data);            
            $('.harga-kain').val(price[0]['harga']);
        })
    });

    $('.jenis').on('change', function() {
        const id = $(this).data('id');
        const type = $(this).val();
        $.post('/on-change-material-type', {id: id, type: type})
            .done(function(data) {
                $.notify('Jenis kain berhasil diubah', "success");
            });
    });   
    
    $('.warna').on('change', function() {
        const id = $(this).data('id');
        const warna = $(this).val();
        $.post('/on-change-material-color', {id: id, color: warna})
            .done(function(data) {
                $.notify('Warna kain berhasil diubah', "success");
            });   
    }); 
    
    $('.berat').on('change', function() {
        const id = $(this).data('id');
        const berat = $(this).val();
        $.post('/on-change-material-weight', {id: id, weight: berat})
            .done(function(data) {
                $.notify('Berat kain berhasil diubah', "success");
            });   
    });

    $('.harga').on('change', function() {
        const id = $(this).data('id');
        const harga = $(this).val();
        $.post('/on-change-material-price', {id: id, harga: harga})
            .done(function(data) {
                $.notify('Harga kain berhasil diubah', "success");
            });   
    });

    $('.vendor-kain-edit').on('change', function() {
        const id = $(this).data('id');
        const vendor = $(this).val();
        var temp = $(this).closest('tr').find('.harga');
        $.post('/on-change-material-vendor', {id: id, vendor: vendor})
            .done(function(data) {
                const price = JSON.parse(data);                    
                console.log(price);
                temp.val(price[0].harga);
                $.notify('Vendor kain berhasil diubah', "success");
            });   
    });

    $('.gudang').on('change', function() {
        const id = $(this).data('id');
        const gudang = $(this).val();
        $.post('/on-change-material-gudang', {id: id, gudang: gudang})
            .done(function(data) {
                $.notify('Gudang kain berhasil diubah', "success");
            });   
    });

    $('.cutting').on('change', function() {
        const id = $(this).data('id');
        const pic = $(this).val();
        $.post('/on-change-material-pic-cutting', {id: id, pic: pic})
            .done(function(data) {
                $.notify('PIC Cutting kain berhasil diubah', "success");
            });   
    });

    $('.gelar1').on('change', function() {
        const id = $(this).data('id');
        const gelar = $(this).val();
        $.post('/on-change-cutting-gelar1', {id: id, gelar: gelar})
            .done(function(data) {
                $.notify('Tim Gelar kain berhasil diubah', "success");
            });   
    });

    $('.gelar2').on('change', function() {
        const id = $(this).data('id');
        const gelar = $(this).val();
        $.post('/on-change-cutting-gelar2', {id: id, gelar: gelar})
            .done(function(data) {
                $.notify('Tim Gelar kain berhasil diubah', "success");
            });   
    });

    $('.pic').on('change', function() {
        const id = $(this).data('id');
        const pic = $(this).val();
        $.post('/on-change-cutting-pic', {id: id, pic: pic})
            .done(function(data) {
                $.notify('PIC Cutting kain berhasil diubah', "success");
            });   
    });
    
    $('.tgl-cutting-edit').on('change', function() {
        const id = $(this).data('id');
        const tgl = $(this).val();
        $.post('/on-change-material-tgl-cutting', {id: id, tgl: tgl})
            .done(function(data) {
                $.notify('Tgl Cutting kain berhasil diubah', "success");
            });   
    });


    $('.vendor-pola').on('change', function() {
        const id = $(this).data('id');
        const ven = $(this).val();
        $.post('/on-change-material-vendor-pola', {id: id, ven: ven})
            .done(function(data) {
                $.notify('Vendor pola berhasil diubah', "success");
            });   
    });

    // cutting
    $('.jenis-produk').on('change', function() {
        const id = $(this).data('id');
        const prod = $(this).val();
        $.post('/on-change-cutting-product-type', {id: id, type: prod})
            .done(function(data) {  
                
                $.notify('Produk berhasil diubah', "success"); 
            });
    });

    $('.jenis-produk-pola').on('change', function() {
        const id = $(this).data('id');
        const prod = $(this).val();
        $.post('/on-change-cutting-product-type-pola', {id: id, type: prod})
            .done(function(data) {  
                const produk = JSON.parse(data);
                console.log(produk);
                $('#pola_out_produk_'+id).html(produk['model_name']);
                $.notify('Produk berhasil diubah', "success"); 
            });
    });

    $('.qty-cutting').on('change', function() {
        const id = $(this).data('id');
        const qty = $(this).val();
        const gelar = $(this).data('gelar');
        const cutting = $(this).data('cutting');
        $.post('/on-change-cutting-qty', {id: id, qty: qty, gelar: gelar,cutting: cutting})
            .done(function(data) {
                const res = JSON.parse(data);
                $('#gelar1_'+id).html('Rp. '+ numberForm(res['gelar1']));
                $('#gelar2_'+id).html('Rp. '+ numberForm(res['gelar2']));
                $('#pic_'+id).html('Rp. '+ numberForm(res['cutting']));
                $('#total_'+id).html('Rp. '+ numberForm(res['total']));                
                $.notify('Qty berhasil diubah', "success"); 
            });
    });

    $('.berat-cutting').on('change', function() {
        const id = $(this).data('id');
        const material = $(this).data('material');
        const berat = $(this).val();
        $.post('/on-change-cutting-berat', {id: id, berat: berat, material: material})
            .done(function(data) {
                $.notify('Berat berhasil diubah', "success"); 
                setTimeout(location.reload.bind(location), 1000);  
            });
    });

    $('.qty-cutting-pola').on('change', function() {
        const id = $(this).data('id');
        const qty = $(this).val();
        const gelar = $(this).data('gelar');
        const cutting = $(this).data('cutting');
        $.post('/on-change-cutting-qty-pola', {id: id, qty: qty, gelar: gelar,cutting: cutting})
            .done(function(data) {
                const res = JSON.parse(data);
                $('#gelar1_'+id).html('Rp. '+ numberForm(res['gelar1']));
                $('#gelar2_'+id).html('Rp. '+ numberForm(res['gelar2']));
                $('#pic_'+id).html('Rp. '+ numberForm(res['cutting']));
                $('#total_'+id).html('Rp. '+ numberForm(res['total']));                
                $('#pola_out_jumlah_'+id).val(res['qty']);
                $.notify('Qty berhasil diubah', "success"); 
                console.log("test"+id);
            });
    });

    $('.pola-out-jumlah-edit').on('change', function() {
        const id = $(this).data('id');
        const jum = $(this).val()
        $.post('/on-change-jumlah-pola-out', {id: id, jum: jum})
            .done(function(data) {
                $('#pola_in_jumlah_'+id).html(jum);
                $.notify('Jumlah Pola berhasil diubah', "success"); 
            });
    });

    $('.pola-out-vendor-edit').on('change', function() {
        const id = $(this).data('id');
        const vendor = $(this).val();

        $.post('/on-change-vendor-pola-out', {id: id, vendor: vendor})
            .done(function(data) {
                const res = JSON.parse(data);
                
                $('#pola_in_vendor_'+id).html(res['name']);
                $.notify('Vendor Pola berhasil diubah', "success"); 
            });
    });

    $('.pola-in-jumlah-setor').on('change', function() {
        const id = $(this).data('id');
        const jum = $(this).val();

        $.post('/on-change-jumlah-setor-pola-in', {id: id, jum: jum})
            .done(function(data) {
                const res = JSON.parse(data);
                $('#pola_in_sisa_'+id).html(res['sisa']);
                $.notify('Jumlah Setor Pola berhasil diubah', "success"); 
                setTimeout(location.reload.bind(location), 1000);  
            });
    });

    $('.pola-in-reject').on('change', function() {
        const id = $(this).data('id');
        const reject = $(this).val();

        $.post('/on-change-reject', {id: id, reject: reject})
            .done(function(data) {
                const res = JSON.parse(data);
                console.log(res);
                $.notify('Jumlah Reject berhasil diubah', "success"); 
                setTimeout(location.reload.bind(location), 1000);  
            });
    });

    function numberForm(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    $('.editable-cutting').click(function() {
        const id = $(this).data('id');
        if ($('#td_'+id).hasClass('table-active')) {
            $('#td_'+id).removeClass('table-active');
            $('#produk_edit_'+id).prop('disabled', false);
            $('#qty_edit_'+id).prop('disabled', false);
            $('#berat_edit_'+id).prop('disabled', false);
        } else {
            $('#td_'+id).addClass('table-active');
            $('#produk_edit_'+id).prop('disabled', true);
            $('#qty_edit_'+id).prop('disabled', true);
            $('#berat_edit_'+id).prop('disabled', true);
        }
    });

    $('.editable-polaout').click(function() {
        const id = $(this).data('id');        
        if ($('#td_pola_'+id).hasClass('table-active')) {
            $('#td_pola_'+id).removeClass('table-active');
            
            $('#pola_out_vendor_'+id).prop('disabled', false);
        } else {
            $('#td_pola_'+id).addClass('table-active');
        }
    });

    $('.editable-polain').click(function() {
        const id = $(this).data('id');        
        if ($('#td_polain_'+id).hasClass('table-info')) {
            $('#td_polain_'+id).removeClass('table-info');
            $('#pola_in_jumlah_setor_'+id).prop('disabled', false);
            $('#pola_in_reject_'+id).prop('disabled', false);
        } else {
            $('#td_polain_'+id).addClass('table-info');
            $('#pola_in_jumlah_setor_'+id).prop('disabled', true);
            $('#pola_in_reject_'+id).prop('disabled', true);
        }
    });

    $('.set-size').click(function() {
        const id = $(this).data('id'); 
        $('#total-qty').html("");
        $('#total-qty').html("");
        $('.size-s').val("");
        $('.size-m').val("");
        $('.size-l').val("");
        $('.size-xl').val("");
        $('.size-xxl').val("");
        $.get('/get-size-cutting', {id: id} ,function(data) {
            const res = JSON.parse(data);
            $('#total-qty').html(res['qty']);
            $('.total-qty').val(res['qty']);
            $('.cutting_id').val(id);
            if (res['nosize'] != "1") {
                $('.size-s').prop('disabled', false);
                $('.size-m').prop('disabled', false);
                $('.size-l').prop('disabled', false);
                $('.size-xl').prop('disabled', false);
                $('.size-xxl').prop('disabled', false);
                $('input.no-size').prop('checked', false);
                $('.size-s').val(res['s']);
                $('.size-m').val(res['m']);
                $('.size-l').val(res['l']);
                $('.size-xl').val(res['xl']);
                $('.size-xxl').val(res['xxl']);
            } else {
                $('.size-s').prop('disabled', true);
                $('.size-m').prop('disabled', true);
                $('.size-l').prop('disabled', true);
                $('.size-xl').prop('disabled', true);
                $('.size-xxl').prop('disabled', true);   
                $('input.no-size').prop('checked', true);
            }
            
            $('#modalSize').modal('show');
        });
    });

    $('form#form-size').on('submit', function (e) {
        e.preventDefault();
        var s = parseInt($('.size-s').val()) || 0;
        var m = parseInt($('.size-m').val()) || 0;
        var l = parseInt($('.size-l').val()) || 0;
        var xl = parseInt($('.size-xl').val()) || 0;
        var xxl = parseInt($('.size-xxl').val()) || 0;
        var qty = parseInt($('.total-qty').val()) || 0;

        var total = (parseInt(s) + parseInt(m) + parseInt(l) + parseInt(xl) + parseInt(xxl));
        
        if (qty != total) {
            if ($('input.no-size').prop('checked')) {
                $.post('/simpan-size', $('form#form-size').serialize(), function(data) {            
                    $.notify('Size berhasil disimpan', "success"); 
                    $('#modalSize').modal('hide');
                });
            } else {
                $.notify('Total size berbeda dengan total Qty', "error"); 
            }
            
        } else {
            $.post('/simpan-size', $('form#form-size').serialize(), function(data) {            
                $.notify('Size berhasil disimpan', "success"); 
                $('#modalSize').modal('hide');
            });
        }
        
    });

    $('.no-size').click(function() {        
        if ($('input.no-size').prop('checked')) {
            $('.size-s').prop('disabled', true);
            $('.size-m').prop('disabled', true);
            $('.size-l').prop('disabled', true);
            $('.size-xl').prop('disabled', true);
            $('.size-xxl').prop('disabled', true);            
        } else {
            $('.size-s').prop('disabled', false);
            $('.size-m').prop('disabled', false);
            $('.size-l').prop('disabled', false);
            $('.size-xl').prop('disabled', false);
            $('.size-xxl').prop('disabled', false);
        }
    });

</script>
<?= $this->endSection() ?>