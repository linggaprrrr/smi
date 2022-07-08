<?= $this->extend('gudang_gesit/layout/content') ?>
<style>
    div.dataTables_wrapper {
        width: 800px;
        margin: 0 auto;
    }
</style>
<?= $this->section('content') ?>
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
                                <label for="">Berat (gr)</label>
                                <input type="text" class="form-control" name="berat" id="tambah-berat" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="...">
                                <small id="modelName" class="form-text text-muted">Contoh 1,5 kg menjadi <b>1500</b> </small>
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
                        <?php foreach ($materialsIn->getResultObject() as $kain) : ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>                                
                                <td class="">
                                    <select class="form-control jenis" data-id="<?= $kain->id ?>" name="jenis">                                        
                                        <?php foreach ($materials->getResultObject() as $material) : ?>
                                            <option value="<?= $material->id ?>" <?= $material->id == $kain->material_id ? 'selected="selected" ' : ''; ?> ><?= $material->type ?></option>
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
                                    <input type="text" class="form-control berat" name="weight" data-id='<?= $kain->id ?>' value="<?= number_format($kain->weight/1000, 2) ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"></td>
                                </td>
                                <td class="text-center"><?= date('j F, Y', strtotime($kain->created_at)) ?></td>
                                <td class="text-center"><?= $kain->roll ?></td>
                                <td class="text-center">
                                    <select class="form-control vendor-kain" name="vendor" data-id='<?= $kain->id ?>'>                                        
                                        <?php foreach ($materialVendors->getResultObject() as $vendor) : ?>
                                            <option value="<?= $vendor->id ?>" <?= $vendor->id == $kain->vendor_id ? 'selected="selected"' : '' ?> ><?= $vendor->vendor ?></option>
                                        <?php endforeach ?>
                                    </select>    
                                </td>
                                <td>
                                    <input type="text" class="form-control harga" name="price" data-id='<?= $kain->id ?>' value="<?= $kain->price ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"></td>
                                </td>
                                <td class="text-center"><?= date('j F, Y', strtotime($kain->tgl_cutting)) ?></td>
                                <td class="text-center"><?= $kain->tim_gelar ?></td>
                                <td class="text-center">
                                    <select class="form-control gudang" data-id="<?= $kain->id ?>" name="gudang">
                                        <?php foreach ($gudangs->getResultObject() as $gudang) : ?>
                                            <option value="<?= $gudang->id ?>" <?= $gudang->id == $kain->gudang_id ? 'selected="selected"' : ''; ?> ><?= $gudang->gudang ?></option>
                                        <?php endforeach ?>
                                    </select> 
                                    
                                </td>                                
                                <td class="text-center"><?= $kain->name ?></td>
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
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
        <div class="modal fade bd-example-modal-lg-kain-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="<?= base_url('/update-kain-detail') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Kain</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Jenis Kain*</label>
                                <input type="hidden" name="id" id="id-kain" >
                                <select class="form-control"  name="jenis" id="jenis">
                                    <?php if ($materials->getNumRows() > 0) : ?>
                                        <?php foreach ($materials->getResultObject() as $material) : ?>
                                            <option value="<?= $material->id ?>"><?= $material->type ?></option>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </select>                                   
                            </div>                            
                            <div class="form-group">
                                <label for="">Warna*</label>
                                <select class="form-control" name="warna" id="warna" >
                                <?php if ($colors->getNumRows() > 0) : ?>
                                    <?php foreach ($colors->getResultObject() as $color) : ?>
                                        <option value="<?= $color->id ?>"><?= $color->color ?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                                </select>  
            
                            </div>
                            <div class="form-group">
                                <label for="">Berat (gr)</label>
                                <input type="text" class="form-control" name="berat" id="berat" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="Masukkan berat produk">
                                <small id="modelName" class="form-text text-muted">Contoh 1,5 kg menjadi <b>1500</b> </small>
                            </div>
                            <div class="form-group">
                                <label for="">Gudang*</label>
                                <select class="form-control" name="gudang" id="gudang">
                                <?php if ($gudangs->getNumRows() > 0) : ?>
                                    <?php foreach ($gudangs->getResultObject() as $gudang) : ?>
                                        <option value="<?= $gudang->id ?>"><?= $gudang->gudang ?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                                </select>  
                            </div>
                            <div class="form-group">
                                <label for="">Vendor Kain*</label>
                                <select class="form-control vendor-kain-edit" name="vendor" required>
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
                                <input type="text" class="form-control harga-kain-edit" name="harga" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="..." required>                                
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">Daftar Kain Keluar (Pola)</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive" id="tabel-kain">
            <table class="table table-bordered" id="dataTable3" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th class="text-center">Tanggal Masuk</th>
                        <th class="text-center">Jenis</th>
                        <th class="text-center">Warna</th>
                        <th class="text-center">Berat (kg)</th>
                        <th class="text-center">Roll</th>
                        <th class="text-center">Tanggal Keluar</th>
                        <th class="text-center">PIC</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php $no = 1; ?>
                    <?php if ($materialsOut->getNumRows() > 0) : ?>
                        <?php foreach ($materialsOut->getResultObject() as $kain) : ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="text-center"><?= $kain->created_at ?></td>
                                <td class=""><?= $kain->type ?></td>
                                <td><?= $kain->color ?></td>
                                <td><?= number_format($kain->weight/1000, 2) ?></td>
                                <td class="text-center"><?= $kain->roll ?></td>
                                <td class="text-center"><?= $kain->created_at_pola ?></td>
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
<script>
    $(document).ready(function() {    
    

                
    });

    $(document).on('click', '.btn-edit', function() {
        const id = $(this).data('id');
        $.get('/get-kain-detail', {material_id: id})
            .done(function(data) {
                const kain = JSON.parse(data);
                console.log(kain);
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

    $('.vendor-kain-edit').change(function() {
        const id = $(this).val();
        $.get('/get-vendor-kain', {id: id}, function(data) {
            const price = JSON.parse(data);            
            $('.harga-kain-edit').val(price[0]['harga']);
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

    $('.vendor-kain').on('change', function() {
        const id = $(this).data('id');
        const vendor = $(this).val();
        $.post('/on-change-material-vendor', {id: id, vendor: vendor})
            .done(function(data) {
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

</script>
<?= $this->endSection() ?>