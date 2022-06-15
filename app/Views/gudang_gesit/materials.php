<?= $this->extend('gudang_gesit/layout/content') ?>

<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">Daftar Kain Masuk</h6>
        
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
                    </tr>
                </thead>
                
                <tbody>
                    <?php $no = 1; ?>
                    <?php if ($materials->getNumRows() > 0) : ?>
                        <?php foreach ($materials->getResultObject() as $kain) : ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class=""><?= $kain->type ?></td>
                                <td><?= $kain->color ?></td>
                                <td><?= number_format($kain->weight, 2) ?></td>
                                <td class="text-center"><?= $kain->created_at ?></td>
                                
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
                        <th class="text-center">Tanggal Masuk</th>
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
                                <td><?= number_format($kain->weight, 2) ?></td>
                                <td class="text-center"><?= $kain->created_at ?></td>
                                
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