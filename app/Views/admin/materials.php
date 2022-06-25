<?= $this->extend('admin/layout/content') ?>

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
                                <label for="">Gudang*</label>
                                <select class="form-control" name="gudang">
                                <?php if ($gudangs->getNumRows() > 0) : ?>
                                    <?php foreach ($gudangs->getResultObject() as $gudang) : ?>
                                        <option value="<?= $gudang->id ?>"><?= $gudang->gudang ?></option>
                                    <?php endforeach ?>
                                <?php endif ?>
                                </select>    
            
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
            <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th class="text-center">Jenis</th>
                        <th class="text-center">Warna</th>
                        <th class="text-center">Berat (kg)</th>
                        <th class="text-center">Tanggal Masuk</th>
                        <th class="text-center">Posisi Gd.</th>
                        <th class="text-center">PIC</th>
                        <th class="text-right"><i class="fa fa-fas fa-angle-down"></i></th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php $no = 1; ?>
                    <?php if ($materialsIn->getNumRows() > 0) : ?>
                        <?php foreach ($materialsIn->getResultObject() as $kain) : ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class=""><?= $kain->type ?></td>
                                <td><?= $kain->color ?></td>
                                <td><?= number_format($kain->weight/1000, 2) ?></td>
                                <td class="text-center"><?= $kain->created_at ?></td>
                                <td class="text-center"><?= $kain->gudang ?></td>
                                <td class="text-center"><?= $kain->name ?></td>
                                <td class="text-center">
                                    <div class="action">
                                        <a href="#" class="btn btn-warning btn-icon-split btn-sm btn-edit" data-id='<?= $kain->id ?>'>
                                            <span class="icon text-white-25">
                                                <i class="fas fa-pen"></i>
                                            </span>
                                        </a>
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
        <h6 class="m-0 font-weight-bold text-primary float-left">Daftar Kain Keluar</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive" id="tabel-kain">
            <table class="table table-bordered" id="dataTable3" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th class="text-center">Jenis</th>
                        <th class="text-center">Warna</th>
                        <th class="text-center">Berat (kg)</th>
                        <th class="text-center">Tanggal Keluar</th>
                        <th class="text-center">Posisi Gd.</th>
                        <th class="text-center">PIC</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php $no = 1; ?>
                    <?php if ($materialsOut->getNumRows() > 0) : ?>
                        <?php foreach ($materialsOut->getResultObject() as $kain) : ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class=""><?= $kain->type ?></td>
                                <td><?= $kain->color ?></td>
                                <td><?= number_format($kain->weight/1000, 2) ?></td>
                                <td class="text-center"><?= $kain->created_at ?></td>
                                <td class="text-center"><?= $kain->gudang ?></td>
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
</script>
<?= $this->endSection() ?>