<?= $this->extend('admin/layout/content') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left">Daftar Kain</h6>
                <button class="btn btn-primary float-right" data-toggle="modal" data-target=".bd-example-modal-lg-kain"><i class="fa fa-plus mr-2"></i>Tambah Kain</button>
                <button type="button" class="btn btn-secondary float-right mr-2" data-toggle="modal" data-target="#importkain"><i class="fa fa-file-excel mr-2"></i>
                    Import
                </button>

                <!-- Modal -->
                <div class="modal fade" id="importkain" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="<?= base_url('/upload-jenis-kain') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Upload Jenis Kain</h5>
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
                                    <span class="form-text text-muted">Accepted formats: xls/xlsx. Max file size 10Mb</span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
                <div class="modal fade bd-example-modal-lg-kain" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">                    
                            <form id="form-kain">
                                <?php csrf_field() ?>
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Kain Baru</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Jenis Kain*</label>
                                        <input type="text" class="form-control" name="jenis" id="tambah-jenis" placeholder="Masukkan jenis kain..." required>                                
                                    </div>  
                                    <div class="form-group">
                                        <label for="">Harga Kain*</label>                                        
                                        <input type="text" class="form-control" name="harga" id="harga-kain" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required>                                
                                    </div> 
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" id="submit-form-kain" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="tabel-kain">
                    <table class="table table-bordered" id="dataTable11" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th class="text-center">Jenis</th>
                                <th class="text-center">Harga</th>
                                <th class="text-right" style="width: 20%;"><i class="fa fa-fas fa-angle-down"></i></th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php $no = 1; ?>
                            <?php if ($materials->getNumRows() > 0) : ?>
                                <?php foreach ($materials->getResultObject() as $kain) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td class=""><?= $kain->type ?></td>
                                        <td class=""><?= $kain->harga ?></td>
                                        <td class="text-center">
                                            <div class="action">
                                                <a href="" data-toggle="modal" class="btn btn-warning btn-icon-split btn-sm btn-edit-kain" data-id='<?= $kain->id ?>'>
                                                    <span class="icon text-white-25">
                                                        <i class="fas fa-pen"></i>
                                                    </span>
                                                </a>
                                                <a href="" data-toggle="modal" class="btn btn-danger btn-icon-split btn-sm btn-hapus-kain" data-id='<?= $kain->id ?>'>
                                                    <span class="icon text-white-25">
                                                        <i class="fas fas fa-trash"></i>
                                                    </span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal fade bd-example-modal-lg-kain-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="<?= base_url('/update-kain') ?>" method="post">
                                <?= csrf_field() ?>
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Kain</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Jenis Kain*</label>
                                        <input type="hidden" name="id" id="id-kain" >
                                        <input type="text" class="form-control" name="jenis" id="jenis" placeholder="Masukkan Jenis Kain" required>                                
                                    </div> 
                                    <div class="form-group">
                                        <label for="">Harga Kain*</label>                                        
                                        <input type="text" class="form-control" name="harga" id="harga-kain" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required>                                
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
    </div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left">Daftar Model</h6>
                <button class="btn btn-primary float-right" data-toggle="modal" data-target=".bd-example-modal-lg-model"><i class="fa fa-plus mr-2"></i>Tambah Model</button>
                <button type="button" class="btn btn-secondary float-right mr-2" data-toggle="modal" data-target="#importmodel"><i class="fa fa-file-excel mr-2"></i>
                    Import
                </button>

                <!-- Modal -->
                <div class="modal fade" id="importmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="<?= base_url('/upload-jenis-model') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Upload Jenis Model</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>File:</label>
                                    <label class="custom-file">

                                        <input type="file" name="file" class="custom-file-input" id="file-upload2" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                        <span class="custom-file-label" id="file-upload-filename2">Choose file</span>
                                    </label>
                                    <span class="form-text text-muted">Accepted formats: xls/xlsx. Max file size 10Mb</span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
                <div class="modal fade bd-example-modal-lg-model" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form id="form-model">
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
                                        <input type="text" class="form-control" name="nama_model" id="tambah-model" placeholder="Masukkan Nama Model" required>
                                        <small id="modelName" class="form-text text-muted">Pastikan nama model tidak ada dalam list.</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Harga Jahit</label>
                                        <input type="text" class="form-control set-jahit" name="jahit" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" value="0">
                                    
                                    </div>
                                    <div class="form-group">
                                        <label for="">HPP</label>
                                        <input type="text" class="form-control set-hpp" name="hpp" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" value="0">
                                    
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" id="submit-form-model" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" id="tabel-model">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable12" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th class="text-center">Nama Model</th>
                                <th class="text-center">Harga Jahit</th>
                                <th class="text-center">HPP</th>
                                <th class="text-right" style="width: 20%;"><i class="fa fa-fas fa-angle-down"></i></th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php $no = 1; ?>
                            <?php if ($models->getNumRows() > 0) : ?>
                                <?php foreach ($models->getResultObject() as $model) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td class=""><?= $model->model_name ?></td>
                                        <td class=""><?= $model->harga_jahit ?></td>
                                        <td class=""><?= $model->hpp ?></td>
                                        <td class="text-center">
                                            <a href="" data-toggle="modal" class="btn btn-warning btn-icon-split btn-sm btn-edit-model" data-id="<?= $model->id ?>">
                                                <span class="icon text-white-25">
                                                    <i class="fas fa-pen"></i>
                                                </span>
                                            </a>
                                            <a href="" data-toggle="modal" class="btn btn-danger btn-icon-split btn-sm btn-hapus-model" data-id="<?= $model->id ?>">
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
                                        <input type="text" class="form-control" id="set-jahit"  name="jahit" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" value="0">
                                    
                                    </div>
                                    <div class="form-group">
                                        <label for="">HPP</label>
                                        <input type="text" class="form-control" id="set-hpp" name="hpp" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" value="0">
                                    
                                    </div>
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit"  class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>                   
    </div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left">Daftar Produk</h6>
                <button class="btn btn-primary float-right" data-toggle="modal" data-target=".bd-example-modal-lg-produk"><i class="fa fa-plus mr-2"></i>Tambah Produk</button>
                <button type="button" class="btn btn-secondary float-right mr-2" data-toggle="modal" data-target="#importproduk"><i class="fa fa-file-excel mr-2"></i>
                    Import
                </button>

                <!-- Modal -->
                <div class="modal fade" id="importproduk" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="<?= base_url('/upload-jenis-produk') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Upload Jenis Produk</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>File:</label>
                                    <label class="custom-file">

                                        <input type="file" name="file" class="custom-file-input" id="file-upload3" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                        <span class="custom-file-label" id="file-upload-filename3">Choose file</span>
                                    </label>
                                    <span class="form-text text-muted">Accepted formats: xls/xlsx. Max file size 10Mb</span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
                <div class="modal fade bd-example-modal-lg-produk" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">                
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form id="form-produk">
                            <?php csrf_field() ?>
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Produk Baru</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Jenis Produk*</label>
                                        <input type="text" class="form-control" name="nama_produk" placeholder="Masukkan Nama Produk" required>                                
                                    </div>
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" id="submit-form-produk" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive" id="tabel-produk">
                    <table class="table table-bordered" id="dataTable13" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th class="text-center">Jenis Produk</th>
                                <th class="text-right" style="width: 20%;"><i class="fa fa-fas fa-angle-down"></i></th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php $no = 1; ?>
                            <?php if ($products->getNumRows() > 0) : ?>
                                <?php foreach ($products->getResultObject() as $product) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $product->product_name ?></td>
                                        <td class="text-center">
                                            <a href="" data-toggle="modal" class="btn btn-warning btn-icon-split btn-sm btn-edit-produk" data-id='<?= $product->id ?>'>
                                                <span class="icon text-white-25">
                                                    <i class="fas fa-pen"></i>
                                                </span>
                                            </a>
                                            <a href="" data-toggle="modal" class="btn btn-danger btn-icon-split btn-sm btn-hapus-produk" data-id='<?= $product->id ?>'>
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
                                        <label for="">Jenis Produk*</label>
                                        <input type="hidden" name="id" id="id-produk">
                                        <input type="text" class="form-control" id="nama-produk" name="nama_produk" placeholder="Masukkan Nama Model" required>                                
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
    </div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left">Daftar Warna</h6>
                <button class="btn btn-primary float-right" data-toggle="modal" data-target=".bd-example-modal-lg-warna"><i class="fa fa-plus mr-2"></i>Tambah Warna</button>
                <button type="button" class="btn btn-secondary float-right mr-2" data-toggle="modal" data-target="#importwarna"><i class="fa fa-file-excel mr-2"></i>
                    Import
                </button>

                <!-- Modal -->
                <div class="modal fade" id="importwarna" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="<?= base_url('/upload-warna') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Upload Warna</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>File:</label>
                                    <label class="custom-file">

                                        <input type="file" name="file" class="custom-file-input" id="file-upload4" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                        <span class="custom-file-label" id="file-upload-filename4">Choose file</span>
                                    </label>
                                    <span class="form-text text-muted">Accepted formats: xls/xlsx. Max file size 10Mb</span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
                <div class="modal fade bd-example-modal-lg-warna" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="<?= base_url('/simpan-warna') ?>" method="post">
                            <?php csrf_field() ?>
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Warna Baru</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Warna*</label>
                                        <input type="text" class="form-control" name="warna" placeholder="Masukkan Warna" required>                                
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
                    <table class="table table-bordered" id="dataTable14" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th class="text-center">Warna</th>
                                <th class="text-right" style="width: 20%;"><i class="fa fa-fas fa-angle-down"></i></th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php $no = 1; ?>
                            <?php if ($colors->getNumRows() > 0) : ?>
                                <?php foreach ($colors->getResultObject() as $col) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $col->color ?></td>
                                        <td class="text-center">
                                            <a href="" data-toggle="modal" class="btn btn-warning btn-icon-split btn-sm btn-edit-warna" data-id='<?= $col->id ?>'>
                                                <span class="icon text-white-25">
                                                    <i class="fas fa-pen"></i>
                                                </span>
                                            </a>
                                            <a href="" data-toggle="modal" class="btn btn-danger btn-icon-split btn-sm btn-hapus-warna" data-id='<?= $col->id ?>'>
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
                <div class="modal fade bd-example-modal-lg-warna-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="<?= base_url('/update-warna') ?>" method="post">
                                <?= csrf_field() ?>
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Warna</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Warna*</label>
                                        <input type="hidden" name="id" id="id-warna">
                                        <input type="text" class="form-control" id="nama-warna" name="warna" placeholder="Masukkan warna" required>                                
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
    </div>
   
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left">Daftar Vendor Supplier Kain</h6>
                <button class="btn btn-primary float-right" data-toggle="modal" data-target=".bd-example-modal-lg-vendorsupplier"><i class="fa fa-plus mr-2"></i>Tambah Vendor</button>
                <button type="button" class="btn btn-secondary float-right mr-2" data-toggle="modal" data-target="#importsupplier"><i class="fa fa-file-excel mr-2"></i>
                    Import
                </button>

                <!-- Modal -->
                <div class="modal fade" id="importsupplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="<?= base_url('/upload-vendor-supplier') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Upload Vendor Supplier</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>File:</label>
                                    <label class="custom-file">

                                        <input type="file" name="file" class="custom-file-input" id="file-upload5" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                        <span class="custom-file-label" id="file-upload-filename5">Choose file</span>
                                    </label>
                                    <span class="form-text text-muted">Accepted formats: xls/xlsx. Max file size 10Mb</span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
                <div class="modal fade bd-example-modal-lg-vendorsupplier" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="<?= base_url('/simpan-vendor-supplier') ?>" method="post">
                            <?php csrf_field() ?>
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Vendor Supplier Kain</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Vendor*</label>
                                        <input type="text" class="form-control" name="vendor" placeholder="Masukkan vendor" required>                                
                                    </div>
                                    <div class="form-group">
                                        <label for="">Harga Kain</label>
                                        <input type="text" class="form-control harga-kain-edit" name="harga" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="..." required>                                
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
                    <table class="table table-bordered" id="dataTable17" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th class="text-center">Vendor</th>
                                <th class="text-center">Harga</th>
                                
                                <th class="text-right" style="width: 20%;"><i class="fa fa-fas fa-angle-down"></i></th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php $no = 1; ?>
                            <?php if ($vendorKain->getNumRows() > 0) : ?>
                                <?php foreach ($vendorKain->getResultObject() as $vendor) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $vendor->vendor ?></td>
                                        <td><?= $vendor->harga ?></td>
                                        <td class="text-center">
                                            <a href="" data-toggle="modal" class="btn btn-warning btn-icon-split btn-sm btn-edit-vendorsupplier" data-id='<?= $vendor->id ?>'>
                                                <span class="icon text-white-25">
                                                    <i class="fas fa-pen"></i>
                                                </span>
                                            </a>
                                            <a href="" data-toggle="modal" class="btn btn-danger btn-icon-split btn-sm btn-hapus-vendorsupplier" data-id='<?= $vendor->id ?>'>
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
                <div class="modal fade bd-example-modal-lg-vendorsupplier-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="<?= base_url('/update-vendor-supplier') ?>" method="post">
                                <?= csrf_field() ?>
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Vendor Supplier</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Vendor*</label>
                                        <input type="hidden" name="id" id="id-supplier">
                                        <input type="text" class="form-control" id="vendor-supplier" name="vendor" placeholder="Masukkan vendor" required>                                
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
    </div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left">Daftar Vendor Penjualan</h6>
                <button class="btn btn-primary float-right" data-toggle="modal" data-target=".bd-example-modal-lg-vendorpenjualan"><i class="fa fa-plus mr-2"></i>Tambah Vendor</button>
                <button type="button" class="btn btn-secondary float-right mr-2" data-toggle="modal" data-target="#importvendorselling"><i class="fa fa-file-excel mr-2"></i>
                    Import
                </button>

                <!-- Modal -->
                <div class="modal fade" id="importvendorselling" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="<?= base_url('/upload-vendor-penjualan') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Upload Vendor Penjualan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>File:</label>
                                    <label class="custom-file">

                                        <input type="file" name="file" class="custom-file-input" id="file-upload6" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                        <span class="custom-file-label" id="file-upload-filename6">Choose file</span>
                                    </label>
                                    <span class="form-text text-muted">Accepted formats: xls/xlsx. Max file size 10Mb</span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
                <div class="modal fade bd-example-modal-lg-vendorpenjualan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="<?= base_url('/simpan-vendor-penjualan') ?>" method="post">
                            <?php csrf_field() ?>
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Vendor Penjualan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Vendor*</label>
                                        <input type="text" class="form-control" name="vendor" placeholder="Masukkan vendor" required>                                
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
                    <table class="table table-bordered" id="dataTable18" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th class="text-center">Vendor</th>
                                <th class="text-right" style="width: 20%;"><i class="fa fa-fas fa-angle-down"></i></th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php $no = 1; ?>
                            <?php if ($vendorPenjualan->getNumRows() > 0) : ?>
                                <?php foreach ($vendorPenjualan->getResultObject() as $vendor) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $vendor->vendor ?></td>
                                        <td class="text-center">
                                            <a href="" data-toggle="modal" class="btn btn-warning btn-icon-split btn-sm btn-edit-vendorpenjualan" data-id='<?= $vendor->id ?>'>
                                                <span class="icon text-white-25">
                                                    <i class="fas fa-pen"></i>
                                                </span>
                                            </a>
                                            <a href="" data-toggle="modal" class="btn btn-danger btn-icon-split btn-sm btn-hapus-vendorpenjualan" data-id='<?= $vendor->id ?>'>
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
                <div class="modal fade bd-example-modal-lg-vendorpenjualan-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="<?= base_url('/update-vendor-penjualan') ?>" method="post">
                                <?= csrf_field() ?>
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Vendor Penjualan</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Vendor*</label>
                                        <input type="hidden" name="id" id="id-penjualan">
                                        <input type="text" class="form-control" id="vendor-penjualan" name="vendor" placeholder="Masukkan Nama Vendor" required>                                
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
    </div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left">Daftar Vendor Pola</h6>
                <button class="btn btn-primary float-right" data-toggle="modal" data-target=".bd-example-modal-lg-vendorpola"><i class="fa fa-plus mr-2"></i>Tambah Vendor</button>
                <button type="button" class="btn btn-secondary float-right mr-2" data-toggle="modal" data-target="#importvendorpola"><i class="fa fa-file-excel mr-2"></i>
                    Import
                </button>

                <!-- Modal -->
                <div class="modal fade" id="importvendorpola" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="<?= base_url('/upload-vendor-pola') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Upload Vendor Pola</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>File:</label>
                                    <label class="custom-file">

                                        <input type="file" name="file" class="custom-file-input" id="file-upload6" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                        <span class="custom-file-label" id="file-upload-filename6">Choose file</span>
                                    </label>
                                    <span class="form-text text-muted">Accepted formats: xls/xlsx. Max file size 10Mb</span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
                <div class="modal fade bd-example-modal-lg-vendorpola" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="<?= base_url('/simpan-vendor-pola') ?>" method="post">
                            <?php csrf_field() ?>
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Vendor Pola</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Vendor*</label>
                                        <input type="text" class="form-control" name="vendor" placeholder="Masukkan vendor" required>                                
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
                    <table class="table table-bordered" id="dataTable20" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th class="text-center">Vendor</th>
                                <th class="text-right" style="width: 20%;"><i class="fa fa-fas fa-angle-down"></i></th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php $no = 1; ?>
                            <?php if ($vendorPola->getNumRows() > 0) : ?>
                                <?php foreach ($vendorPola->getResultObject() as $vendor) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $vendor->name ?></td>
                                        <td class="text-center">
                                            <a href="" data-toggle="modal" class="btn btn-warning btn-icon-split btn-sm btn-edit-vendorpola" data-id='<?= $vendor->id ?>'>
                                                <span class="icon text-white-25">
                                                    <i class="fas fa-pen"></i>
                                                </span>
                                            </a>
                                            <a href="" data-toggle="modal" class="btn btn-danger btn-icon-split btn-sm btn-hapus-vendorpola" data-id='<?= $vendor->id ?>'>
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
                <div class="modal fade bd-example-modal-lg-vendorpola-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="<?= base_url('/update-vendor-pola') ?>" method="post">
                                <?= csrf_field() ?>
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Vendor Pola</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Vendor*</label>
                                        <input type="hidden" name="id" id="id-pola">
                                        <input type="text" class="form-control" id="vendor-pola" name="vendor" placeholder="Masukkan Nama Vendor" required>                                
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
    </div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left">Daftar Tim Gelar</h6>
                <button class="btn btn-primary float-right" data-toggle="modal" data-target=".bd-example-modal-lg-gelar"><i class="fa fa-plus mr-2"></i>Tambah Tim Gelar</button>
                <button type="button" class="btn btn-secondary float-right mr-2" data-toggle="modal" data-target="#importgelar"><i class="fa fa-file-excel mr-2"></i>
                    Import
                </button>

                <!-- Modal -->
                <div class="modal fade" id="importgelar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="<?= base_url('/upload-gelar') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Upload Tim Gelar</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>File:</label>
                                    <label class="custom-file">

                                        <input type="file" name="file" class="custom-file-input" id="file-upload7" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                        <span class="custom-file-label" id="file-upload-filename7">Choose file</span>
                                    </label>
                                    <span class="form-text text-muted">Accepted formats: xls/xlsx. Max file size 10Mb</span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
                <div class="modal fade bd-example-modal-lg-gelar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="<?= base_url('/simpan-gelar') ?>" method="post">
                            <?php csrf_field() ?>
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Tim Gelar</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Nama*</label>
                                        <input type="text" class="form-control" name="name" required>                                
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
                    <table class="table table-bordered" id="dataTable21" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th class="text-center">Nama</th>
                                <th class="text-right" style="width: 20%;"><i class="fa fa-fas fa-angle-down"></i></th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php $no = 1; ?>
                            <?php if ($timGelar->getNumRows() > 0) : ?>
                                <?php foreach ($timGelar->getResultObject() as $gelar) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $gelar->name ?></td>
                                        <td class="text-center">
                                            <a href="" data-toggle="modal" class="btn btn-warning btn-icon-split btn-sm btn-edit-gelar" data-id='<?= $gelar->id ?>'>
                                                <span class="icon text-white-25">
                                                    <i class="fas fa-pen"></i>
                                                </span>
                                            </a>
                                            <a href="" data-toggle="modal" class="btn btn-danger btn-icon-split btn-sm btn-hapus-gelar" data-id='<?= $gelar->id ?>'>
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
                <div class="modal fade bd-example-modal-lg-gelar-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="<?= base_url('/update-gelar') ?>" method="post">
                                <?= csrf_field() ?>
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Tim Gelar</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Nama*</label>
                                        <input type="hidden" name="id" id="id-pola">
                                        <input type="text" class="form-control" id="vendor-pola" name="name" required>                                
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
                <h6 class="m-0 font-weight-bold text-primary float-left">Daftar Tim Cutting</h6>
                <button class="btn btn-primary float-right" data-toggle="modal" data-target=".bd-example-modal-lg-cutting"><i class="fa fa-plus mr-2"></i>Tambah Tim Cutting</button>
                <button type="button" class="btn btn-secondary float-right mr-2" data-toggle="modal" data-target="#importcutting"><i class="fa fa-file-excel mr-2"></i>
                    Import
                </button>

                <!-- Modal -->
                <div class="modal fade" id="importcutting" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="<?= base_url('/upload-cutting') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Upload Tim Cutting</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>File:</label>
                                    <label class="custom-file">

                                        <input type="file" name="file" class="custom-file-input" id="file-upload8" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                        <span class="custom-file-label" id="file-upload-filename8">Choose file</span>
                                    </label>
                                    <span class="form-text text-muted">Accepted formats: xls/xlsx. Max file size 10Mb</span>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
                <div class="modal fade bd-example-modal-lg-cutting" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="<?= base_url('/simpan-cutting') ?>" method="post">
                            <?php csrf_field() ?>
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Tim Cutting</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Nama*</label>
                                        <input type="text" class="form-control" name="name" required>                                
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
                    <table class="table table-bordered" id="dataTable22" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th class="text-center">Nama</th>
                                <th class="text-right" style="width: 20%;"><i class="fa fa-fas fa-angle-down"></i></th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php $no = 1; ?>
                            <?php if ($timCutting->getNumRows() > 0) : ?>
                                <?php foreach ($timCutting->getResultObject() as $cutting) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $cutting->name ?></td>
                                        <td class="text-center">
                                            <a href="" data-toggle="modal" class="btn btn-warning btn-icon-split btn-sm btn-edit-cutting" data-id='<?= $cutting->id ?>'>
                                                <span class="icon text-white-25">
                                                    <i class="fas fa-pen"></i>
                                                </span>
                                            </a>
                                            <a href="" data-toggle="modal" class="btn btn-danger btn-icon-split btn-sm btn-hapus-cutting" data-id='<?= $cutting->id ?>'>
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
                <div class="modal fade bd-example-modal-lg-cutting-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="<?= base_url('/update-gelar') ?>" method="post">
                                <?= csrf_field() ?>
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Tim Cutting</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">Nama*</label>
                                        <input type="hidden" name="id" id="id-pola">
                                        <input type="text" class="form-control" id="vendor-pola" name="name" required>                                
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
                <h6 class="m-0 font-weight-bold text-primary float-left">COA</h6>                
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable22" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th class="text-center">COA</th>
                                <th class="text-center">Biaya</th>
                                <th class="text-right" style="width: 20%;"><i class="fa fa-fas fa-angle-down"></i></th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($coa as $co) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td><?= $co->ket ?></td>
                                    <td><?= $co->biaya ?></td>
                                    <td class="text-center">
                                        <a href="" data-toggle="modal" class="btn btn-warning btn-icon-split btn-sm btn-edit-coa" data-id='<?= $co->id ?>'>
                                            <span class="icon text-white-25">
                                                <i class="fas fa-pen"></i>
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal fade bd-example-modal-lg-coa-edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <form action="<?= base_url('/update-coa') ?>" method="post">
                                <?= csrf_field() ?>
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit COA</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="">COA*</label>
                                        <input type="hidden" name="id" id="id-coa">
                                        <input type="text" class="form-control" id="coa" name="ket" required>                                
                                    </div>
                                    <div class="form-group">
                                        <label for="">Biaya*</label>                                        
                                        <input type="text" class="form-control" name="biaya" id="biaya" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required>                                
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
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {    
        $('#submit-form-kain').click(function() {                        
            $.post('/simpan-kain', $('form#form-kain').serialize())
                .done(function(data) {
                    setTimeout(location.reload.bind(location), 1); 
                    $('#tambah-jenis').val("");                       
                });
        });

        $('#submit-form-produk').click(function() {                        
            $.post('/simpan-produk', $('form#form-produk').serialize())
                .done(function(data) {
                    setTimeout(location.reload.bind(location), 1); 
                    $('#tambah-produk').val("");                      
                });
        });

        $('#submit-form-model').click(function() {                        
            $.post('/simpan-model', $('form#form-model').serialize())
                .done(function(data) {
                    setTimeout(location.reload.bind(location), 1); 
                    $('#tambah-model').val("");                   
                });
        });

        

                
    });

    $(document).on('click', '.btn-edit-kain', function() {
        const id = $(this).data('id');
        $.get('/get-kain', {material_id: id})
            .done(function(data) {
                const kain = JSON.parse(data);
                $('#id-kain').val(kain['id']);
                $('#jenis').val(kain['type']);
            });
        $('.bd-example-modal-lg-kain-edit').modal('show');
    });

    $('.btn-edit-produk').click(function(){
        const id = $(this).data('id');
        $('.bd-example-modal-lg-produk-edit').modal('show');
        $.get('/get-produk', {product_id: id})
            .done(function(data) {
                const product = JSON.parse(data);
                $('#id-produk').val(product['id']);
                $('#nama-produk').val(product['product_name']);
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
                $('#set-jahit').val(model['harga_jahit']);
                $('#set-hpp').val(model['hpp']);
        });
    });

    $('.btn-edit-warna').click(function(){
        const id = $(this).data('id');
        $('.bd-example-modal-lg-warna-edit').modal('show');
        $.get('/get-warna', {color_id: id})
            .done(function(data) {
                const model = JSON.parse(data);
                $('#id-warna').val(model['id']);
                $('#nama-warna').val(model['color']);
        });
    });

    $('.btn-edit-vendorsupplier').click(function(){
        const id = $(this).data('id');
        $('.bd-example-modal-lg-vendorsupplier-edit').modal('show');
        $.get('/get-vendor-supplier', {vendor_id: id})
            .done(function(data) {
                const model = JSON.parse(data);
                console.log(model);
                $('#id-supplier').val(model['id']);
                $('#vendor-supplier').val(model['vendor']);
                $('#harga-supplier').val(model['harga']);
        });
    });

    $('.btn-edit-vendorpenjualan').click(function(){
        const id = $(this).data('id');
        $('.bd-example-modal-lg-vendorpenjualan-edit').modal('show');
        $.get('/get-vendor-penjualan', {vendor_id: id})
            .done(function(data) {
                const model = JSON.parse(data);
                $('#id-penjualan').val(model['id']);
                $('#vendor-penjualan').val(model['vendor']);
        });
    });

    $('.btn-edit-vendorpola').click(function(){
        const id = $(this).data('id');
        $('.bd-example-modal-lg-vendorpola-edit').modal('show');
        $.get('/get-vendor-pola', {vendor_id: id})
            .done(function(data) {
                const model = JSON.parse(data);
                $('#id-pola').val(model['id']);
                $('#vendor-pola').val(model['name']);
        });
    });

    $('.btn-edit-coa').click(function(){
        const id = $(this).data('id');
        $('.bd-example-modal-lg-coa-edit').modal('show');
        $.get('/get-coa', {vendor_id: id})
            .done(function(data) {
                const model = JSON.parse(data);
                $('#id-coa').val(model['id']);
                $('#coa').val(model['ket']);
                $('#biaya').val(model['biaya']);
        });
    });

    


    $(document).on('click', '.btn-hapus-kain', function() {
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
                $.post('/delete-kain', {material_id: id})
                    .done(function(data) {
                        setTimeout(location.reload.bind(location), 1000);                         
                    });
            } else {
                swal("Data tidak jadi dihapus!");
            }
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
    
    $('.btn-hapus-warna').click(function() {
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
                    $.post('/delete-warna', {color_id: id})
                        .done(function(data) {
                            setTimeout(location.reload.bind(location), 1000);
                        });
                } else {
                    swal("Data tidak jadi dihapus!");
                }
            });
    }); 

    $('.btn-hapus-vendorsupplier').click(function() {
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
                    $.post('/delete-vendor-supplier', {vendor_id: id})
                        .done(function(data) {
                            setTimeout(location.reload.bind(location), 1000);
                        });
                } else {
                    swal("Data tidak jadi dihapus!");
                }
            });
    }); 

    $('.btn-hapus-vendorpenjualan').click(function() {
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
                    $.post('/delete-vendor-penjualan', {vendor_id: id})
                        .done(function(data) {
                            setTimeout(location.reload.bind(location), 1000);
                        });
                } else {
                    swal("Data tidak jadi dihapus!");
                }
            });
    }); 

    $('.btn-hapus-vendorpola').click(function() {
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
                    $.post('/delete-vendor-pola', {vendor_id: id})
                        .done(function(data) {
                            setTimeout(location.reload.bind(location), 1000);
                        });
                } else {
                    swal("Data tidak jadi dihapus!");
                }
            });
    }); 

    $('.btn-hapus-gelar').click(function() {
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
                    $.post('/delete-gelar', {id: id})
                        .done(function(data) {
                            setTimeout(location.reload.bind(location), 1000);
                        });
                } else {
                    swal("Data tidak jadi dihapus!");
                }
            });
    }); 

    $('.btn-hapus-cutting').click(function() {
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
                    $.post('/delete-cutting', {id: id})
                        .done(function(data) {
                            setTimeout(location.reload.bind(location), 1000);
                        });
                } else {
                    swal("Data tidak jadi dihapus!");
                }
            });
    }); 

    var input = document.getElementById('file-upload');
    var infoArea = document.getElementById('file-upload-filename');
    var input2 = document.getElementById('file-upload2');
    var infoArea2 = document.getElementById('file-upload-filename2');
    var input3 = document.getElementById('file-upload3');
    var infoArea3 = document.getElementById('file-upload-filename3');
    var input4 = document.getElementById('file-upload4');
    var infoArea4 = document.getElementById('file-upload-filename4');
    var input5 = document.getElementById('file-upload5');
    var infoArea5 = document.getElementById('file-upload-filename5');
    var input6 = document.getElementById('file-upload6');
    var infoArea6 = document.getElementById('file-upload-filename6');
    var input7= document.getElementById('file-upload7');
    var infoArea7 = document.getElementById('file-upload-filename7');
    var input8 = document.getElementById('file-upload8');
    var infoArea8 = document.getElementById('file-upload-filename8');

    input.addEventListener('change', showFileName);
    input2.addEventListener('change', showFileName2);
    input3.addEventListener('change', showFileName3);
    input4.addEventListener('change', showFileName4);
    input5.addEventListener('change', showFileName5);
    input6.addEventListener('change', showFileName6);
    input7.addEventListener('change', showFileName7);
    input8.addEventListener('change', showFileName8);

    function showFileName(event) {
        // the change event gives us the input it occurred in 
        var input = event.srcElement;
        // the input has an array of files in the `files` property, each one has a name that you can use. We're just using the name here.
        var fileName = input.files[0].name;
        // use fileName however fits your app best, i.e. add it into a div
        infoArea.textContent = '' + fileName;
    }

    function showFileName2(event) {
        // the change event gives us the input it occurred in 
        var input = event.srcElement;
        // the input has an array of files in the `files` property, each one has a name that you can use. We're just using the name here.
        var fileName = input2.files[0].name;
        // use fileName however fits your app best, i.e. add it into a div
        infoArea2.textContent = '' + fileName;
    }

    function showFileName3(event) {
        // the change event gives us the input it occurred in 
        var input = event.srcElement;
        // the input has an array of files in the `files` property, each one has a name that you can use. We're just using the name here.
        var fileName = input3.files[0].name;
        // use fileName however fits your app best, i.e. add it into a div
        infoArea3.textContent = '' + fileName;
    }
    function showFileName4(event) {
        // the change event gives us the input it occurred in 
        var input = event.srcElement;
        // the input has an array of files in the `files` property, each one has a name that you can use. We're just using the name here.
        var fileName = input4.files[0].name;
        // use fileName however fits your app best, i.e. add it into a div
        infoArea4.textContent = '' + fileName;
    }
    function showFileName5(event) {
        // the change event gives us the input it occurred in 
        var input = event.srcElement;
        // the input has an array of files in the `files` property, each one has a name that you can use. We're just using the name here.
        var fileName = input5.files[0].name;
        // use fileName however fits your app best, i.e. add it into a div
        infoArea5.textContent = '' + fileName;
    }
    function showFileName6(event) {
        // the change event gives us the input it occurred in 
        var input = event.srcElement;
        // the input has an array of files in the `files` property, each one has a name that you can use. We're just using the name here.
        var fileName = input6.files[0].name;
        // use fileName however fits your app best, i.e. add it into a div
        infoArea6.textContent = '' + fileName;
    }
    function showFileName7(event) {
        // the change event gives us the input it occurred in 
        var input = event.srcElement;
        // the input has an array of files in the `files` property, each one has a name that you can use. We're just using the name here.
        var fileName = input7.files[0].name;
        // use fileName however fits your app best, i.e. add it into a div
        infoArea7.textContent = '' + fileName;
    }
    function showFileName8(event) {
        // the change event gives us the input it occurred in 
        var input = event.srcElement;
        // the input has an array of files in the `files` property, each one has a name that you can use. We're just using the name here.
        var fileName = input8.files[0].name;
        // use fileName however fits your app best, i.e. add it into a div
        infoArea8.textContent = '' + fileName;
    }

</script>
<?= $this->endSection() ?>