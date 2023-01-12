<?= $this->extend('gudang_lovish/layout/content') ?>
<style>
    option {
    background:transparent; 
}
</style>
<?= $this->section('content') ?>

<div class="card shadow mb-4">
    <div class="card-header py-3">        
        <?php if (!is_null($date1)) : ?>
            <a class="btn btn-success float-right" href="<?= base_url('/export-produk-masuk-gudang/'. date('Y-m-d', strtotime($date1)) . '/'. date('Y-m-d H:i:s', strtotime($date2))) ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>                            
        <?php else : ?>
            <a class="btn btn-success float-right" href="<?= base_url('/export-produk-masuk-gudang') ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>
        <?php endif ?>
        <div class="float-left">
            <form method="GET" action="<?= base_url('/operasional/produk') ?>" id="date" >
                <div class="form-group" style="width: 280px;">
                       
                    <div class="form-group">
                        <label for="">Date Range: </label>
                        <?php if (is_null($date1)) : ?>                        
                            <input type="text" name="dates" value="<?= date('m/d/Y 07:00') ?> - <?= date('m/d/Y 17:00') ?>" class="form-control text-center daterange" readonly />            
                        <?php else : ?>
                            <input type="text" name="dates" class="form-control text-center daterange" value="<?= $date1 ?>" readonly />            
                        <?php endif ?> 
                    </div>                  
                    
                </div>    
            </form>
        </div>
    </div>
    <div class="card-body">
        <h6 class="m-0 font-weight-bold text-primary float-left">Daftar Produk Masuk Dari Gesit</h6>
        <br>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable3" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th class="text-center">Jenis Produk</th>
                        <th class="text-center">Model</th>
                        <th class="text-center">Warna</th>
                        <th class="text-center">Size</th>
                        <th class="text-center">Qty</th>
                        <th class="text-center">Tanggal Masuk</th>
                        <th class="text-center">PIC</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php $no = 1; ?>
                    <?php if ($productsOut->getNumRows() > 0) : ?>
                        <?php foreach ($productsOut->getResultObject() as $product) : ?>
                            <?php if (!is_null($product->model_name)) : ?>
                                <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="text-center"><div><?= $product->product_name ?></div></td>
                                <td class="text-center"><?= $product->model_name ?></td>
                                <td><?= $product->color ?></td>
                                <td class="text-center align-middle"><?= (is_null($product->size) ? '-' : $product->size) ?></td>
                                <td class="text-center">1</td>
                                <td class="text-center"><?= $product->created_at ?></td>
                                <td class="text-center"><?= $product->name ?></td>
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
        <h6 class="m-0 font-weight-bold text-primary float-left">Data Stok Gudang Lama</h6>
        
        <button class="btn btn-success float-right mr-2" data-toggle="modal" data-target=".export-produk"><i class="fa fa-file-excel mr-2"></i>Import</button>
        <a class="btn float-right" href="<?= base_url('download/import produk gudang template.xlsx') ?>" download><i class="fa fa-download"></i> Template</a>
        <div class="modal fade export-produk" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="<?= base_url('/import-product') ?>" method="post" enctype="multipart/form-data">                    
                    <?php csrf_field() ?>
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Produk Baru</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>File:</label>
                                <label class="custom-file">
                                    <input type="file" name="file" class="custom-file-input" id="file-upload" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                    <span class="custom-file-label" id="file-upload-filename">Choose file</span>
                                </label>
                                <span class="form-text text-muted">Accepted formats: xls. Max file size 10Mb</span>
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
        <div class="modal fade bd-example-modal-lg-produk" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="<?= base_url('/tambah-produk-lovish') ?>" method="post">                    
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
                                    <?php if ($types->getNumRows() > 0) : ?>
                                        <?php foreach ($types->getResultObject() as $product) : ?>
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
                        <th class="text-center">Produk</th>
                        <th class="text-center">Model</th>
                        <th class="text-center">Warna</th>
                        <th class="text-center">Size</th>
                        <th class="text-center">Qty</th>
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
                                <td class="text-center"><div><?= $product->product_name ?></div></td>
                                <td class="text-center"><div><?= $product->model_name ?></div></td>
                                <td class="text-center"><div><?= $product->color ?></div></td>
                                <td class="text-center align-middle"><?= (is_null($product->size) ? '-' : $product->size) ?></td>                            
                                <td class="text-center"><div><?= $product->qty ?></div></td>
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


<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js" integrity="sha512-efUTj3HdSPwWJ9gjfGR71X9cvsrthIA78/Fvd/IN+fttQVy7XWkOAXb295j8B3cmm/kFKVxjiNYzKw9IQJHIuQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>
    $(document).ready(function() {
        $('.daterange').daterangepicker({
            timePicker: true,        
            locale: {
                format: 'M/DD/YYYY hh:mm A'
            }
        });  

        $('.daterange').change(function() {
            $('#date').submit();
        })

        var input = document.getElementById('file-upload');
        var infoArea = document.getElementById('file-upload-filename');
        input.addEventListener('change', showFileName);
    
        function showFileName(event) {
            var input = event.srcElement;
            var fileName = input.files[0].name;
            infoArea.textContent = '' + fileName;
        }

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
                    $.post('/delete-product-detail-lovish', {product_id: id})
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
            $.post('/on-change-product-type-lovish', {product: id, type: jenis})
                .done(function(data) {
                    $.notify('Jenis produk berhasil diubah', "success");
                });
        });

        $('.model').on('change', function() {
            const id = $(this).data('id');
            const model = $(this).val();
            $.post('/on-change-model-name-lovish', {product: id, model: model})
                .done(function(data) {
                    $.notify('Model produk berhasil diubah', "success");
                });   
        });  
        
        $('.warna').on('change', function() {
            const id = $(this).data('id');
            const warna = $(this).val();
            $.post('/on-change-product-color-lovish', {product: id, color: warna})
                .done(function(data) {
                    $.notify('Warna produk berhasil diubah', "success");
                });   
        }); 
        
        $('.berat').on('change', function() {
            const id = $(this).data('id');
            const berat = $(this).val();
            $.post('/on-change-product-weight-lovish', {product: id, weight: berat})
                .done(function(data) {
                    $.notify('Berat produk berhasil diubah', "success");
                });   
        });

        $('.qty').on('change', function() {
            const id = $(this).data('id');
            const qty = $(this).val();
            $.post('/on-change-product-qty-lovish', {product: id, qty: qty})
                .done(function(data) {
                    $.notify('Qty produk berhasil diubah', "success");
                });   
        });


        $('.hpp').on('change', function() {
            const id = $(this).data('id');
            const hpp = $(this).val();
            $.post('/on-change-product-hpp-lovish', {product: id, hpp: hpp})
                .done(function(data) {
                    $.notify('HPP produk berhasil diubah', "success");
                });   
        });

        $('.model-hpp').on('change', function() {
            const id = $(this).val();
            $.get('/get-hpp-product-lovish', {id: id}, function(data) {
                const hpp = JSON.parse(data);            
                $('.set-hpp').val(hpp['hpp']);
            })
        });
    });
    
</script>
<?= $this->endSection() ?>