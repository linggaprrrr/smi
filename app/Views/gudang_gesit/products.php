<?= $this->extend('gudang_gesit/layout/content') ?>

<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">Daftar Produk (Gesit)</h6>
    
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
<script>
   
    
</script>
<?= $this->endSection() ?>