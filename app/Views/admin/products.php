<?= $this->extend('admin/layout/content') ?>
<style>
    option {
    background:transparent; 
}
</style>
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
                                <select class="form-control model-hpp" name="model">
                                    <option value="-">-</option>
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
                            <div class="form-group">
                                <label for="">Qty</label>
                                <input type="text" class="form-control" name="qty" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="..." value="1">                                
                            </div>
                            <div class="form-group">
                                <label for="">HPP</label>
                                <input type="text" class="form-control set-hpp" name="harga" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" value="0">
                               
                            </div>
                            <div class="form-group">
                                <label for="">Vendor</label>
                                <select class="form-control" name="vendor">
                                    <?php if ($vendors->getNumRows() > 0) : ?>
                                        <?php foreach ($vendors->getResultObject() as $vendor) : ?>
                                            <option value="<?= $vendor->id ?>"><?= $vendor->vendor ?></option>
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
                        <th class="text-center">Qty</th>
                        <th class="text-center">HPP</th>
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
                                <td>
                                <select class="form-control jenis-produk" name="nama_produk" data-id='<?= $product->id ?>'>
                                    <?php foreach ($products->getResultObject() as $pr) : ?>
                                        <option value="<?= $pr->id ?>" <?= $pr->id == $product->product_id ? 'selected="selected"' : ''; ?> ><?= $pr->product_name ?></option>
                                    <?php endforeach ?>
                                </select>
                                </td>
                                <td class="text-center">
                                    <select class="form-control model" name="model" data-id='<?= $product->id ?>'>
                                        <?php foreach ($models->getResultObject() as $model) : ?>
                                                <option value="<?= $model->id ?>" <?= $model->id == $product->model_id ? 'selected="selected"' : ''; ?> ><?= $model->model_name ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control warna" name="warna" data-id='<?= $product->id ?>'>
                                        <?php foreach ($colors->getResultObject() as $color) : ?>
                                            <option value="<?= $color->id ?>" <?= $color->id == $product->color_id ? 'selected="selected"' : ''; ?> ><?= $color->color ?></option>
                                        <?php endforeach ?>
                                    </select>      
                                </td>
                                <td><input type="text" class="form-control berat" name="weight" data-id='<?= $product->id ?>' value="<?= $product->weight ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"></td>
                                <td><input type="text" class="form-control qty" name="qty" data-id='<?= $product->id ?>' value="<?= $product->qty ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"></td>        
                                <td><input type="text" class="form-control hpp" name="price" data-id='<?= $product->id ?>' value="<?= $product->price ?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"></td>                                
                                <td class="text-center align-middle"><?= $product->created_at ?></td>
                                <td class="text-center align-middle"><?= $product->name ?></td>
                                <td class="text-center">                                    
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
                        <th class="text-center">Qty</th>
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
                                <td><div contenteditable><?= $product->product_name ?></div></td>
                                <td class="text-center"><?= $product->model_name ?></td>
                                <td><?= $product->color ?></td>
                                <td><?= $product->weight ?></td>
                                <td class="text-center"><?= $product->qty ?></td>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js" integrity="sha512-efUTj3HdSPwWJ9gjfGR71X9cvsrthIA78/Fvd/IN+fttQVy7XWkOAXb295j8B3cmm/kFKVxjiNYzKw9IQJHIuQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {

        $(document).on('click', '.btn-hapus-produk', function() {
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
        })
     

        $('.jenis-produk').on('change', function() {
            const id = $(this).data('id');
            const jenis = $(this).val();
            $.post('/on-change-product-type', {product: id, type: jenis})
                .done(function(data) {
                    $.notify('Jenis produk berhasil diubah', "success");
                });
        });

        $('.model').on('change', function() {
            const id = $(this).data('id');
            const model = $(this).val();
            $.post('/on-change-model-name', {product: id, model: model})
                .done(function(data) {
                    $.notify('Model produk berhasil diubah', "success");
                });   
        });  
        
        $('.warna').on('change', function() {
            const id = $(this).data('id');
            const warna = $(this).val();
            $.post('/on-change-product-color', {product: id, color: warna})
                .done(function(data) {
                    $.notify('Warna produk berhasil diubah', "success");
                });   
        }); 
        
        $('.berat').on('change', function() {
            const id = $(this).data('id');
            const berat = $(this).val();
            $.post('/on-change-product-weight', {product: id, weight: berat})
                .done(function(data) {
                    $.notify('Berat produk berhasil diubah', "success");
                });   
        });

        $('.qty').on('change', function() {
            const id = $(this).data('id');
            const qty = $(this).val();
            $.post('/on-change-product-qty', {product: id, qty: qty})
                .done(function(data) {
                    $.notify('Qty produk berhasil diubah', "success");
                });   
        });


        $('.hpp').on('change', function() {
            const id = $(this).data('id');
            const hpp = $(this).val();
            $.post('/on-change-product-hpp', {product: id, hpp: hpp})
                .done(function(data) {
                    $.notify('HPP produk berhasil diubah', "success");
                });   
        });

        $('.model-hpp').on('change', function() {
            const id = $(this).val();
            $.get('/get-hpp-product', {id: id}, function(data) {
                const hpp = JSON.parse(data);            
                $('.set-hpp').val(hpp['hpp']);
            })
        });
    });
    
</script>
<?= $this->endSection() ?>