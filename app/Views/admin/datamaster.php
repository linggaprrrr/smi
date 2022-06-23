<?php 
    d($materials);
    d($products);
   
?>
<?= $this->extend('admin/layout/content') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary float-left">Daftar Kain</h6>
                <button class="btn btn-primary float-right" data-toggle="modal" data-target=".bd-example-modal-lg-kain"><i class="fa fa-plus mr-2"></i>Tambah Kain</button>
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
                                        <td class="text-center">
                                            <div class="action">
                                                <a href="#" class="btn btn-warning btn-icon-split btn-sm btn-edit-kain" data-id='<?= $kain->id ?>'>
                                                    <span class="icon text-white-25">
                                                        <i class="fas fa-pen"></i>
                                                    </span>
                                                </a>
                                                <a href="#" class="btn btn-danger btn-icon-split btn-sm btn-hapus-kain" data-id='<?= $kain->id ?>'>
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
                                        <td class="text-center">
                                            <a href="#" class="btn btn-warning btn-icon-split btn-sm btn-edit-model" data-id="<?= $model->id ?>">
                                                <span class="icon text-white-25">
                                                    <i class="fas fa-pen"></i>
                                                </span>
                                            </a>
                                            <a href="#" class="btn btn-danger btn-icon-split btn-sm btn-hapus-model" data-id="<?= $model->id ?>">
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
                                            <a href="#" class="btn btn-warning btn-icon-split btn-sm btn-edit-produk" data-id='<?= $product->id ?>'>
                                                <span class="icon text-white-25">
                                                    <i class="fas fa-pen"></i>
                                                </span>
                                            </a>
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
                                            <a href="#" class="btn btn-warning btn-icon-split btn-sm btn-edit-warna" data-id='<?= $col->id ?>'>
                                                <span class="icon text-white-25">
                                                    <i class="fas fa-pen"></i>
                                                </span>
                                            </a>
                                            <a href="#" class="btn btn-danger btn-icon-split btn-sm btn-hapus-warna" data-id='<?= $col->id ?>'>
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
                                        <td class="text-center">
                                            <a href="#" class="btn btn-warning btn-icon-split btn-sm btn-edit-vendorsupplier" data-id='<?= $vendor->id ?>'>
                                                <span class="icon text-white-25">
                                                    <i class="fas fa-pen"></i>
                                                </span>
                                            </a>
                                            <a href="#" class="btn btn-danger btn-icon-split btn-sm btn-hapus-vendorsupplier" data-id='<?= $vendor->id ?>'>
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
                                            <a href="#" class="btn btn-warning btn-icon-split btn-sm btn-edit-vendorpenjualan" data-id='<?= $vendor->id ?>'>
                                                <span class="icon text-white-25">
                                                    <i class="fas fa-pen"></i>
                                                </span>
                                            </a>
                                            <a href="#" class="btn btn-danger btn-icon-split btn-sm btn-hapus-vendorpenjualan" data-id='<?= $vendor->id ?>'>
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
                                        <input type="text" class="form-control" id="vendor-penjualan" name="vendor" placeholder="Masukkan Nama Model" required>                                
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
                $('#id-supplier').val(model['id']);
                $('#vendor-supplier').val(model['vendor']);
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

</script>
<?= $this->endSection() ?>