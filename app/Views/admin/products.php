<?= $this->extend('admin/layout/content') ?>

<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">Daftar Produk (Gesit)</h6>
        <button class="btn btn-primary float-right" data-toggle="modal" data-target=".bd-example-modal-lg-produk"><i class="fa fa-plus mr-2"></i>Tambah Produk</button>
        <div class="modal fade bd-example-modal-lg-produk" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="<?= base_url('/simpan-produk') ?>" method="post">
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
                                <input type="text" class="form-control" name="nama_produk" placeholder="Masukkan Nama Produk" required>                                
                            </div>
                            <div class="form-group">
                                <label for="">Model*</label>
                                <select class="form-control" name="model">
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
                                <input type="text" class="form-control" name="warna" placeholder="Masukkan Warna Produk" required> 
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
                        <th class="text-center">Nama Produk</th>
                        <th class="text-center">Model</th>
                        <th class="text-center">Warna</th>
                        <th class="text-center">Berat (gr)</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-right" style="width: 15%;"><i class="fa fa-fas fa-angle-down"></i></th>
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
                                <td class="text-center">
                                    <a href="#" class="btn btn-warning btn-icon-split btn-sm btn-edit-produk" data-id='<?= $product->id ?>'>
                                        <span class="icon text-white-25">
                                            <i class="fas fa-pen"></i>
                                        </span>
                                        <span class="text">Edit</span>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-icon-split btn-sm btn-hapus-produk" data-id='<?= $product->id ?>'>
                                        <span class="icon text-white-25">
                                            <i class="fas fas fa-trash"></i>
                                        </span>
                                        <span class="text">Hapus</span>
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
                    <form action="<?= base_url('/update-produk') ?>" method="post">
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
                                <input type="text" class="form-control" id="nama-produk" name="nama_produk" placeholder="Masukkan Nama Model" required>                                
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
                                <input type="text" class="form-control" id="warna"  name="warna" placeholder="Masukkan Warna Produk" required> 
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

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">Daftar Produk Keluar (Lovish)</h6>
        <!-- <button class="btn btn-primary float-right" data-toggle="modal" data-target=".bd-example-modal-lg-produk"><i class="fa fa-plus mr-2"></i>Tambah Produk</button> -->
        
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
                    <?php if ($productsExp->getNumRows() > 0) : ?>
                        <?php foreach ($productsExp->getResultObject() as $product) : ?>
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
        <h6 class="m-0 font-weight-bold text-primary float-left">Model</h6>
        <button class="btn btn-primary float-right" data-toggle="modal" data-target=".bd-example-modal-lg-model"><i class="fa fa-plus mr-2"></i>Tambah Model</button>

        <div class="modal fade bd-example-modal-lg-model" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="<?= base_url('/simpan-model') ?>" method="post">
                        <?php csrf_field() ?>
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Model Baru</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Nama Model*</label>
                                <input type="text" class="form-control" name="nama_model" placeholder="Masukkan Nama Model" required>
                                <small id="modelName" class="form-text text-muted">Pastikan nama model tidak ada dalam list.</small>
                            </div>
                            <div class="form-group">
                                <label for="">Harga Jahit</label>
                                <input type="text" class="form-control" name="harga_jahit" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="Rp...">
                                <small id="modelName" class="form-text text-muted">Contoh Rp 10.500 menjadi <b>10500</b> </small>
                            </div>
                            <div class="form-group">
                                <label for="">HPP Lovish</label>
                                <input type="text" class="form-control" name="hpp" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="Rp...">
                                <small id="modelName" class="form-text text-muted">Contoh Rp 10.500 menjadi <b>10500</b> </small>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-form-label">Vendor:</label>
                                <input type="text" class="form-control" name="vendor" placeholder="Masukkan Nama Vendor">
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
            <table class="table table-bordered" id="dataTable3" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th class="text-center">Nama Model</th>
                        <th class="text-center">Harga Jahit</th>
                        <th class="text-center">HPP Lovish</th>
                        <th class="text-center">Vendor</th>
                        <th class="text-right" style="width: 15%;"><i class="fa fa-fas fa-angle-down"></i></th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php $no = 1; ?>
                    <?php if ($models->getNumRows() > 0) : ?>
                        <?php foreach ($models->getResultObject() as $model) : ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class=""><?= $model->model_name ?></td>
                                <td>Rp. <?= number_format($model->jahit_price, 0) ?></td>
                                <td>Rp. <?= number_format($model->hpp_price) ?></td>
                                <td class="text-center"><?= $model->vendor ?></td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-warning btn-icon-split btn-sm btn-edit-model" data-id="<?= $model->id ?>">
                                        <span class="icon text-white-25">
                                            <i class="fas fa-pen"></i>
                                        </span>
                                        <span class="text">Edit</span>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-icon-split btn-sm btn-hapus-model" data-id="<?= $model->id ?>">
                                        <span class="icon text-white-25">
                                            <i class="fas fas fa-trash"></i>
                                        </span>
                                        <span class="text">Hapus</span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
        <div class="modal fade bd-example-modal-lg-model-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="<?= base_url('/update-model') ?>" method="post">
                        <?php csrf_field() ?>
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Model</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="">Nama Model*</label>
                                <input type="hidden" name="id" id="id-model" >
                                <input type="text" class="form-control" name="nama_model" id="nama-model" placeholder="Masukkan Nama Model" required>
                                <small id="modelName" class="form-text text-muted">Pastikan nama model tidak ada dalam list.</small>
                            </div>
                            <div class="form-group">
                                <label for="">Harga Jahit</label>
                                <input type="text" class="form-control" name="harga_jahit" id="harga-jahit" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="Rp...">
                                <small id="modelName" class="form-text text-muted">Contoh Rp 10.500 menjadi <b>10500</b> </small>
                            </div>
                            <div class="form-group">
                                <label for="">HPP Lovish</label>
                                <input type="text" class="form-control" name="hpp" id="hpp" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="Rp...">
                                <small id="modelName" class="form-text text-muted">Contoh Rp 10.500 menjadi <b>10500</b> </small>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-form-label">Vendor:</label>
                                <input type="text" class="form-control" name="vendor" id="vendor" placeholder="Masukkan Nama Vendor">
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

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
        $('.btn-edit-produk').click(function(){
            const id = $(this).data('id');
            $('.bd-example-modal-lg-produk-edit').modal('show');
            $.get('/get-product', {product_id: id})
                .done(function(data) {
                    const product = JSON.parse(data);
                    $('#id-produk').val(product['id']);
                    $('#nama-produk').val(product['product_name']);
                    $('#model-produk').val(product['model_id']);
                    $('#warna').val(product['color']);
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
                        $.post('/delete-product', {product_id: id})
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