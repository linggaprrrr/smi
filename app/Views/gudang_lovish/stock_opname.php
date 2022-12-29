<?= $this->extend('gudang_lovish/layout/content') ?>
<style>
    option {
    background:transparent; 
}
</style>
<?= $this->section('content') ?>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">Stok Produk</h6>
        <a class="btn btn-success float-right ml-2" href="<?= base_url('/export-so') ?>"  target="_blank"><i class="fa fa-file-excel mr-2"></i>Export</a>        
        <button class="btn btn-primary float-right reset" data-toggle="modal">Reset SO</button>  
         
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable20" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th class="text-center">Produk</th>                        
                        <th class="text-center">Sisa Stok</th>
                        <th class="text-center">Scan SO</th>
                        <th class="text-center">Selisih</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php $no = 1; ?>
                    <?php if (count($products) > 0) : ?>
                        <?php foreach ($products as $product) : ?>    
                            <?php 
                                $selisih = $product['sisa_gudang'] - $product['scan_in'];
                                ?>                                                
                            <tr>
                                <td class="text-center align-middle"><?= $no++ ?></td>
                                <td><?= $product['product_name'] ?> <?= $product['model_name'] ?> <?= $product['color'] ?></td>
                                <td class="text-center align-middle"><?= $product['sisa_gudang'] ?></td>                                                                        
                                <td class="text-center align-middle"><?= $product['scan_in'] > 0 ? $product['scan_in'] : '-' ?></td>
                                <?php if ($selisih > 0) :  ?>
                                    <td class="text-center align-middle table-warning"><?= $selisih > 0 ? $selisih : '-' ?></td>
                                <?php else : ?>
                                    <td class="text-center align-middle"><?= $selisih > 0 ? $selisih : '-' ?></td>
                                <?php endif ?>
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
                    $.post('/delete-product-detail-lovish', {product_id: id})
                        .done(function(data) {
                            setTimeout(location.reload.bind(location), 1000);
                        });
                } else {
                    swal("Data tidak jadi dihapus!");
                }
            });
        })
        
        $(document).on('click', '.reset', function() {
            const id = '1';
            swal({
                    title: "Apakah anda yakin?",
                    text: "Data yang hasil scan so akan dihapus selamanya",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
            .then((willDelete) => {
                if (willDelete) {
                    swal("Poof! Data berhasil dihapus!", {
                    icon: "success",
                    });
                    $.post('/reset-so', {product_id: id})
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