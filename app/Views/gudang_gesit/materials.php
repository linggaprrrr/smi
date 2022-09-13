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
                                        <select class="form-control" name="jenis">
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
                                            <option>-</option>
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
                                        <label for="">Berat (gr)</label>
                                        <input type="text" class="form-control" name="berat" id="tambah-berat" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="...">
                                        <small id="modelName" class="form-text text-muted">Contoh 1,5 kg menjadi <b>1500</b> </small>
                                    </div>                                                                  
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="">Tgl Cutting</label>
                                        <input type="text" class="form-control" name="tgl-cutting-old" value="-" disabled>                                
                                    </div>     
                                    <div class="form-group">
                                    <label for="">Gelar 1*</label>
                                        <select class="form-control" name="gelar1">
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
                                    
                                    <div class="form-group">
                                        <label for="">Roll</label>
                                        <input type="text" class="form-control" name="roll" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" value="1" placeholder="Masukkan jumlah roll" disabled>                                
                                    </div>
                                </div>
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
                        <th class="text-center">Jenis</th>
                        <th class="text-center">Warna</th>
                        <th class="text-center">Berat (kg)</th>
                        <th class="text-center">Tgl Masuk</th>                        
                        <th class="text-center">Roll</th>
                        <th class="text-center">Vendor</th>
                        <th class="text-center">Harga</th>
                        <th class="text-center">Tgl Cutting</th>
                        <th class="text-center">Tim Gelar</th>
                        <th class="text-center">Posisi Gd.</th>
                        <th class="text-center">PIC Cutting</th>
                        <th class="text-right"><i class="fa fa-fas fa-angle-down"></i></th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php $no = 1; ?>
                    <?php if ($materialsIn->getNumRows() > 0) : ?>
                        <?php $id = ""; $timGelar = array('', ''); $len = count($materialsIn->getResultObject()); $i = 0;?>
                       
                        <?php foreach ($materialsIn->getResultObject() as $kain) : ?>                                                     
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>                                
                                <td class="">
                                    <select class="form-control jenis" data-id="<?= $kain->id ?>" name="jenis" style="width: 140px">                                         
                                        <?php foreach ($materials->getResultObject() as $material) : ?>
                                            <option value="<?= $material->id ?>" <?= $material->id == $kain->material_id ? 'selected="selected" ' : ''; ?> ><?= $material->type ?></option>
                                        <?php endforeach ?>                                        
                                    </select>    
                                </td>
                                <td>
                                    <select class="form-control warna" name="warna" data-id='<?= $kain->id ?>' style="width: 90px">
                                        <?php foreach ($colors->getResultObject() as $color) : ?>
                                            <option value="<?= $color->id ?>" <?= $color->id == $kain->color_id ? 'selected="selected"' : ''; ?> ><?= $color->color ?></option>
                                        <?php endforeach ?>
                                    </select>   
                                </td>                                
                                <td>
                                    <input type="text" class="form-control berat" name="weight" data-id='<?= $kain->id ?>' style="width: 90px" value="<?= number_format($kain->weight/1000, 2) ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"></td>
                                </td>
                                <td class="text-center align-middle"><?= date('m/d/Y', strtotime($kain->created_at)) ?></td>
                                <td class="text-center align-middle"><?= $kain->roll ?></td>
                                <td class="text-center">
                                    <select class="form-control vendor-kain-edit" name="vendor" data-id='<?= $kain->id ?>' style="width: 160px">                                        
                                        <?php foreach ($materialVendors->getResultObject() as $vendor) : ?>
                                            <option value="<?= $vendor->id ?>" <?= $vendor->id == $kain->vendor_id ? 'selected="selected"' : '' ?> ><?= $vendor->vendor ?></option>
                                        <?php endforeach ?>
                                    </select>    
                                </td>
                                <td>
                                    <input type="text" class="form-control harga" name="price" data-id='<?= $kain->id ?>' value="<?= $kain->price ?>"  style="width: 90px" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"></td>
                                </td>
                                <?php if (is_null($kain->tgl_cutting)) : ?>
                                    <td class="text-center"><input type="text" class="form-control tgl-cutting-edit" name="tgl-cutting" data-id='<?= $kain->id ?>' value="-" disabled>  </td>
                                <?php else : ?>
                                    <td class="text-center"><input type="text" class="form-control tgl-cutting-edit" name="tgl-cutting" data-id='<?= $kain->id ?>' value="<?= date("m/d/Y", strtotime($kain->tgl_cutting)) ?>" disabled>  </td>
                                <?php endif ?>
                                <td class="text-center">
                                    <form>
                                        <div class="form-row">
                                            <div class="col">
                                                <select class="form-control gelar1" data-id="<?= $kain->id ?>" name="gelar" style="width: 90px">
                                                    <option value="0">-</option>
                                                    <?php foreach ($timGelars->getResultObject() as $gelar) : ?>
                                                        <option value="<?= $gelar->id ?>" <?= $gelar->id == $kain->gelar1 ? 'selected="selected"' : ''; ?> ><?= $gelar->name ?></option>
                                                    <?php endforeach ?>
                                                </select> 
                                            </div>
                                            <div class="col">
                                                <select class="form-control gelar2" data-id="<?= $kain->id ?>" name="gelar" style="width: 90px">
                                                <option value="0">-</option>
                                                    <?php foreach ($timGelars->getResultObject() as $gelar) : ?>
                                                        <option value="<?= $gelar->id ?>" <?= $gelar->id == $kain->gelar2 ? 'selected="selected"' : ''; ?> ><?= $gelar->name ?></option>
                                                    <?php endforeach ?>
                                                </select> 
                                            </div>
                                        </div>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <select class="form-control gudang" data-id="<?= $kain->id ?>" name="gudang" style="width: 90px">
                                        <?php foreach ($gudangs->getResultObject() as $gudang) : ?>
                                            <option value="<?= $gudang->id ?>" <?= $gudang->id == $kain->gudang_id ? 'selected="selected"' : ''; ?> ><?= $gudang->gudang ?></option>
                                        <?php endforeach ?>
                                    </select> 
                                    
                                </td>                                
                                <td class="text-center">
                                    <select class="form-control cutting" data-id="<?= $kain->id ?>" name="pic_cutting" style="width: 90px">
                                        <?php foreach ($picCutting->getResultObject() as $pic) : ?>
                                            <option value="<?= $pic->id ?>" <?= $pic->id == $kain->pic_cutting ? 'selected="selected"' : ''; ?> ><?= $pic->name ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                                <td class="text-center">
                                    <div class="action">
                                    
                                        <a href="#" class="btn btn-danger btn-icon-split btn-sm btn-hapus" data-id='<?= $kain->id ?>'>
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
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">Daftar Data Cutting</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive" id="tabel-kain">
            <table class="table table-bordered" id="dataTable3" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Produk</th>
                        <th class="text-center">Warna</th>
                        <th class="text-center">Qty</th>
                        <th class="text-center">Gelar 1</th>
                        <th class="text-center">Gelar 2</th>                        
                        <th class="text-center">PIC</th>
                        <th class="text-center">Total</th>
                        <th class="text-right"><i class="fa fa-ellipsis-v"></i></th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php $no = 1; ?>
                    <?php if ($cuttings->getNumRows() > 0) : ?>
                        <?php foreach ($cuttings->getResultObject() as $cutting) : ?>
                            <tr>
                                <td class="text-center align-middle"><?= $no++ ?></td>
                                <td class="text-center align-middle"><?= date('m/d/Y', strtotime($cutting->tgl)) ?></td>
                                <td class="text-center align-middle"><?= $cutting->type ?></td>
                                <td class="text-center align-middle"><?= $cutting->color ?></td>
                                <td class="text-center align-middle">
                                    <input type="text" class="form-control qty-cutting" name="qty" data-id='<?= $cutting->id ?>' value="<?= $cutting->qty ?>"  style="width: 90px" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                </td>
                                <td class="text-center align-middle">                                
                                    <?= $cutting->gelar1 ?>
                                    <br>
                                    <small><mark>Rp <?= number_format($cutting->biaya_gelar1, 0) ?></mark></small>
                                </td>  
                                <td class="text-center align-middle">   
                                    <?= $cutting->gelar2 ?>                             
                                    <br>
                                    <small><mark>Rp <?= number_format($cutting->biaya_gelar2, 0) ?></mark></small>
                                </td>  
                                <td class="text-center align-middle">                                
                                    <?= $cutting->gelar1 ?>
                                    <br>
                                    <small><mark>Rp <?= number_format($cutting->biaya_cutting, 0) ?></mark></small>
                                </td>  
                                <td class="text-center font-weight-bold align-middle">Rp <?= number_format($cutting->total) ?></td>  
                                <td class="text-center align-middle">
                                    <a href="#" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-info-circle"></i></a>
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
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
           
        </div>
        
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">Daftar Kain Keluar (Pola)</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive" id="tabel-kain">
            <table class="table table-bordered" id="dataTable5" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th class="text-center">Tanggal Masuk</th>
                        <th class="text-center">Jenis</th>
                        <th class="text-center">Warna</th>
                        <th class="text-center">Berat (kg)</th>
                        <th class="text-center">Roll</th>
                        <th class="text-center">Tanggal Keluar</th>
                        <th class="text-center">Vendor Pola</th>
                        <th class="text-ce  nter">PIC</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php $no = 1; ?>
                    <?php if ($materialsOut->getNumRows() > 0) : ?>
                        <?php foreach ($materialsOut->getResultObject() as $kain) : ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="text-center"><?= date('m/d/Y', strtotime($kain->created_at)) ?></td>
                                <td class=""><?= $kain->type ?></td>
                                <td><?= $kain->color ?></td>
                                <td><?= number_format($kain->weight/1000, 2) ?></td>
                                <td class="text-center"><?= $kain->roll ?></td>
                                <td class="text-center"><?= date('m/d/Y', strtotime($kain->created_at_pola)) ?></td>
                                <td class="text-center">
                                    <select class="form-control vendor-pola" data-id="<?= $kain->id ?>" name="vendor-pola">
                                        <option value="0">-</option>
                                        <?php foreach ($vendorPola->getResultObject() as $ven) : ?>
                                            <option value="<?= $ven->id ?>" <?= $ven->id == $kain->vendor_pola ? 'selected="selected"' : ''; ?> ><?= $ven->name ?></option>
                                        <?php endforeach ?>
                                    </select> 
                                    
                                </td>  
                                <td class="text-center"><?= $kain->name ?></td>
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
        <h6 class="m-0 font-weight-bold text-primary float-left">Daftar Kain Masuk (Pola)</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive" id="tabel-kain">
            <table class="table table-bordered" id="dataTable4" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th class="text-center">Tanggal Masuk</th>
                        <th class="text-center">Jenis</th>
                        <th class="text-center">Warna</th>
                        <th class="text-center">Berat (kg)</th>
                        <th class="text-center">Roll</th>
                        <th class="text-center">Vendor Pola</th>
                        <th class="text-center">PIC</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php $no = 1; ?>
                    <?php if ($materialsPolaIn->getNumRows() > 0) : ?>
                        <?php foreach ($materialsPolaIn->getResultObject() as $kain) : ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="text-center"><?= $kain->updated_at ?></td>
                                <td class=""><?= $kain->type ?></td>
                                <td><?= $kain->color ?></td>
                                <td><?= number_format($kain->weight/1000, 2) ?></td>
                                <td class="text-center"><?= $kain->roll ?></td>
                                <td class="text-center"><?= $kain->vendor_pola ?></td>
                                <td class="text-center"><?= $kain->name ?></td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
        
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js" integrity="sha512-efUTj3HdSPwWJ9gjfGR71X9cvsrthIA78/Fvd/IN+fttQVy7XWkOAXb295j8B3cmm/kFKVxjiNYzKw9IQJHIuQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {    
    
        $('.tgl-cutting').datepicker();
        $('.tgl-cutting-edit').datepicker();
                
    });

    $(document).on('click', '.btn-edit', function() {
        const id = $(this).data('id');
        $.get('/get-kain-detail', {material_id: id})
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

    $('.vendor-kain').change(function() {
        const id = $(this).val();
        $.get('/get-vendor-kain', {id: id}, function(data) {
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
        $.post('/on-change-material-pic-gelar1', {id: id, gelar: gelar})
            .done(function(data) {
                $.notify('Tim Gelar kain berhasil diubah', "success");
            });   
    });

    $('.gelar2').on('change', function() {
        const id = $(this).data('id');
        const gelar = $(this).val();
        $.post('/on-change-material-pic-gelar2', {id: id, gelar: gelar})
            .done(function(data) {
                $.notify('Tim Gelar kain berhasil diubah', "success");
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

</script>
<?= $this->endSection() ?>