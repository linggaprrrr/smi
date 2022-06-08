<?= $this->extend('admin/layout/content') ?>

<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <button class="btn btn-primary float-right"><i class="fa fa-plus mr-2"></i>Tambah User</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable3" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Username</th>
                        <th class="text-center">Role</th>
                        <th class="text-right" style="width: 15%;"><i class="fa fa-fas fa-angle-down"></i></th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php $no = 1; ?>
                    <?php if ($users->getNumRows() > 0) : ?>
                        <?php foreach ($users->getResultObject() as $user) : ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class=""><?= $user->name ?></td>
                                <td><?= $user->username ?></td>
                                <td class="text-center"><b><?= $user->role ?></b></td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-warning btn-icon-split btn-sm">
                                        <span class="icon text-white-25">
                                            <i class="fas fa-pen"></i>
                                        </span>
                                        <span class="text">Edit</span>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-icon-split btn-sm">
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
    </div>
</div>
<?= $this->endSection() ?>