<?= $this->extend('admin/layout/content') ?>

<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">History Hari ini</h6>
        
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th class="text-center">Aktivitas</th>
                        <th class="text-center" style="width: 20%">Waktu</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php $no = 1; ?>
                    <?php if ($dailyLogs->getNumRows() > 0) : ?>
                        <?php foreach ($dailyLogs->getResultObject() as $log) : ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class=""><b><?= $log->name ?></b> <?= $log->description ?></td>
                                <td class="text-center"><?= date('g:i:s a', strtotime($log->created_at))  ?></td>
                            
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
        <h6 class="m-0 font-weight-bold text-primary float-left">History Sebelumnya</h6>
        
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable4" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th class="text-center">Aktivitas</th>
                        <th class="text-center" style="width: 20%">Waktu</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php $no = 1; ?>
                    <?php if ($logs->getNumRows() > 0) : ?>
                        <?php foreach ($logs->getResultObject() as $log) : ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class=""><b><?= $log->name ?></b> <?= $log->description ?></td>
                                <td class="text-center"><?= date('F j, Y - g:i a', strtotime($log->created_at)) ?></td>
                            
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
    
</script>
<?= $this->endSection() ?>