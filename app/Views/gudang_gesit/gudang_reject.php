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
                <div class="row">
                    <div class="col-xl-4 col-md-4 mb-4">
                            <div class="card border-left-secondary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                                                Total Nilai Jual</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= (is_null($totalNilaiJual) ? "0" : $totalNilaiJual) ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-cubes fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>          
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
                                                    <td><input type="text" name="hpp[]" class="form-control harga-jual" data-id='<?= $product->id ?>' value="<?= $product->hpp ?>" placeholder="Rp ..."></td>
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
                                            <?php if (strpos($product->category, 'permanent') !== false) : ?>
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
        $('.harga-jual').change(function() {
            const id = $(this).data('id');
            const harga = $(this).val();
            $.post('/update-harga-jual', {reject_id: id, harga: harga}, function(data) {
                $.notify('Harga Jual berhasil diubah', "success");
            });
        });

        
    });
    
</script>
<?= $this->endSection() ?>