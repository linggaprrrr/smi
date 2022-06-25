<?= $this->extend('gudang_gesit/layout/content') ?>

<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">Daftar Produk (Gesit)</h6>
        <button class="btn btn-primary float-right" data-toggle="modal" data-target=".bd-example-modal-lg-produk"><i class="fa fa-plus mr-2"></i>Tambah Produk</button>
        <div class="modal fade bd-example-modal-lg-produk" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="<?= base_url('/tambah-produk') ?>" method="post">
                    <?php csrf_field() ?>
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Produk Baru</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Nama Produk*</label>
                                <select class="form-control" name="nama_produk">
                                    <?php if ($products->getNumRows() > 0) : ?>
                                        <?php foreach ($products->getResultObject() as $product) : ?>
                                            <option value="<?= $product->id ?>"><?= $product->product_name ?></option>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </select>
                                                       
                            </div>
                            <div class="form-group">
                                <label for="">Model*</label>
                                <select class="form-control" name="model">
                                    <?php if ($models->getNumRows() > 0) : ?>
                                        <?php foreach ($models->getResultObject() as $model) : ?>
                                            <option value="<?= $model->id ?>"><?= $model->model_name ?></option>
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
                                <input type="text" class="form-control" name="berat" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="Masukkan berat produk">
                                <small id="modelName" class="form-text text-muted">Contoh 1,5 kg menjadi <b>1500</b> </small>
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
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th class="text-center">Jenis Produk</th>
                        <th class="text-center">Model</th>
                        <th class="text-center">Warna</th>
                        <th class="text-center">Berat (gr)</th>
                        <th class="text-center">Tanggal Masuk</th>
                        <th class="text-center">PIC</th>
                        <th class="text-right"><i class="fa fa-fas fa-angle-down"></i></th>
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
                                <td class="text-center"><?= $product->name ?></td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-warning btn-icon-split btn-sm btn-edit-produk" data-id='<?= $product->id ?>'>
                                        <span class="icon text-white-25">
                                            <i class="fas fa-pen"></i>
                                        </span>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-icon-split btn-sm btn-hapus-produk" data-id='<?= $product->id ?>'>
                                        <span class="icon text-white-25">
                                            <i class="fas fas fa-trash"></i>
                                        </span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
        <div class="modal fade bd-example-modal-lg-produk-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="<?= base_url('/update-produk-detail') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Produk</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Nama Produk*</label>
                                <input type="hidden" name="id" id="id-produk">
                                <select class="form-control" name="nama_produk" id="nama-produk">
                                    <?php if ($products->getNumRows() > 0) : ?>
                                        <?php foreach ($products->getResultObject() as $product) : ?>
                                            <option value="<?= $product->id ?>"><?= $product->product_name ?></option>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </select>
                                                          
                            </div>
                            <div class="form-group">
                                <label for="">Model*</label>
                                <select class="form-control" id="model-produk" name="model">
                                    <option value="">-</option>
                                    <?php if ($models->getNumRows() > 0) : ?>
                                        <?php foreach ($models->getResultObject() as $model) : ?>
                                            <option value="<?= $model->id ?>"><?= $model->model_name ?></option>
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
        <h6 class="m-0 font-weight-bold text-primary float-left">Daftar Produk Masuk (Lovish)</h6>
        <!-- <button class="btn btn-primary float-right" data-toggle="modal" data-target=".bd-example-modal-lg-produk"><i class="fa fa-plus mr-2"></i>Tambah Produk</button> -->
        
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th class="text-center">Jenis Produk</th>
                        <th class="text-center">Model</th>
                        <th class="text-center">Warna</th>
                        <th class="text-center">Berat (gr)</th>
                        <th class="text-center">Tanggal Masuk</th>
                        <th class="text-center">PIC</th>
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
                                <td class="text-center"><?= $product->name ?></td>
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
        $('.btn-edit-produk').click(function(){
            const id = $(this).data('id');
            $('.bd-example-modal-lg-produk-edit').modal('show');
            $.get('/get-produk-detail', {product_id: id})
                .done(function(data) {
                    const product = JSON.parse(data);
                    $('#id-produk').val(product['id']);
                    $('#nama-produk').val(product['product_id']);
                    $('#model-produk').val(product['model_id']);
                    $('#warna').val(product['color_id']);
                    $('#berat').val(product['weight']);
            });
        });
        $('.btn-hapus-produk').click(function() {
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
                        $.post('/delete-product-detail', {product_id: id})
                            .done(function(data) {
                                setTimeout(location.reload.bind(location), 1000);
                            });
                    } else {
                        swal("Data tidak jadi dihapus!");
                    }
                });
        });   

        $('.btn-edit-model').click(function(){
            const id = $(this).data('id');
            $('.bd-example-modal-lg-model-edit').modal('show');
            $.get('/get-model', {model_id: id})
                .done(function(data) {
                    const model = JSON.parse(data);
                    $('#id-model').val(model['id']);
                    $('#nama-model').val(model['model_name']);
                    $('#harga-jahit').val(model['jahit_price']);
                    $('#hpp').val(model['hpp_price']);
                    $('#vendor').val(model['vendor']);
            });
        });
        $('.btn-hapus-model').click(function() {
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
                        $.post('/delete-model', {model_id: id})
                            .done(function(data) {
                                setTimeout(location.reload.bind(location), 1000);
                            });
                    } else {
                        swal("Data tidak jadi dihapus!");
                    }
                });
        }); 
    });
    
</script>
<?= $this->endSection() ?>