<?= $this->extend('gudang_gesit/layout/content') ?>
<style>
    option {
    background:transparent; 
}
</style>
<?= $this->section('content') ?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <!-- <h6 class="m-0 font-weight-bold text-primary float-left">List Produk Reject</h6> -->
        <!-- <a href="" class="btn btn-primary float-right" data-toggle="modal"><i class="fa fa-plus mr-2"></i>Replace SO</a>         -->
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link font-weight-bold active" data-toggle="tab" href="#home">Penjualan Reject</a>
            </li>
            <li class="nav-item">
                <a class="nav-link font-weight-bold" data-toggle="tab" href="#menu1">List Produk Reject</a>
            </li>
        </ul>
        <div class="tab-content m-0">
            <div id="home" class="tab-pane active"><br>                
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary float-left">Data Penjualan Reject</h6>                            
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable20" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 5%">No</th>
                                        <th class="text-center">Tanggal Reject</th>   
                                        <th class="text-center">Tanggal Jual</th>   
                                        <th class="text-center">Produk</th>   
                                        <th class="text-center">Model</th>   
                                        <th class="text-center">Warna</th>   
                                        <th class="text-center">Jenis Reject</th>   
                                        <th class="text-center">Harga Jual</th>   
                                    
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php if ($rejectedSold->getNumRows() > 0) : ?>
                                        <?php foreach ($rejectedSold->getResultObject() as $product) : ?>
                                            <?php if ($product->status == '2') : ?>
                                                <tr class="table-secondary">
                                                    <td class="text-center"><?= $no++ ?></td>
                                                    <td class="text-center"><?= date('m/d/Y', strtotime($product->date)) ?></td> 
                                                    <td class="text-center"><?= date('m/d/Y', strtotime($product->tanggal_jual)) ?></td> 
                                                    <td><div><?= $product->product_name ?></div></td>
                                                    <td class="text-center"><?= $product->model_name ?></td>                                
                                                    <td class="text-center"><?= $product->color ?></td>                         
                                                    <td class="text-center"><?= strtoupper($product->category) ?></td>                                       
                                                    <td class="text-center">Rp <?= number_format($product->hpp, 0) ?></td>
                                                </tr>
                                            <?php else : ?>
                                                <tr class="">
                                                    <td class="text-center"><?= $no++ ?></td>
                                                    <td class="text-center"><?= date('m/d/Y', strtotime($product->date)) ?></td> 
                                                    <td class="text-center">-</td> 
                                                    <td><div><?= $product->product_name ?></div></td>
                                                    <td class="text-center"><?= $product->model_name ?></td>                                
                                                    <td class="text-center"><?= $product->color ?></td>                         
                                                    <td class="text-center"><?= strtoupper($product->category) ?></td>                                                                                       
                                                    <td><input type="text" name="hpp[]" class="form-control" placeholder="Rp ..."></td>
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
            <div id="menu1" class="tab-pane fade"><br>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary float-left">Data Produk Reject</h6>                            
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable20" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 5%">No</th>
                                        <th class="text-center">Tanggal Reject</th>   
                                        <th class="text-center">Jenis Produk</th>   
                                        <th class="text-center">Model</th>   
                                        <th class="text-center">Warna</th>   
                                        <th class="text-center">Jenis Reject</th>   
                                    
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php if ($rejectedProducts->getNumRows() > 0) : ?>
                                        <?php foreach ($rejectedProducts->getResultObject() as $product) : ?>
                                            <?php if ($product->status == '3') : ?>
                                                <tr>
                                                    <td class="text-center"><?= $no++ ?></td>
                                                    <td class="text-center"><?= date('m/d/Y', strtotime($product->date)) ?></td> 
                                                    <td><div><?= $product->product_name ?></div></td>
                                                    <td class="text-center"><?= $product->model_name ?></td>                                
                                                    <td class="text-center"><?= $product->color ?></td>                         
                                                    <td class="text-center"><?= strtoupper($product->category) ?></td>                                       
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
                    $.post('/delete-product-detail-lovish', {product_id: id})
                        .done(function(data) {
                            setTimeout(location.reload.bind(location), 1000);
                        });
                } else {
                    swal("Data tidak jadi dihapus!");
                }
            });
        })
        
        $('.hpp-jual').change(function() {
            const id = $(this).data('id');
            const model = $(this).data('model');
            const size = $(this).data('size');
            const hpp = $(this).val();
            $.post('/update-hpp-jual', {product_id: id, model_id: model, size: size, hpp: hpp}, function(data) {
                $.notify('HPP Jual berhasil diubah', "success");
                setTimeout(location.reload.bind(location), 1000);
            });
        });

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