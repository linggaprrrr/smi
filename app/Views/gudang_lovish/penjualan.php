<?= $this->extend('gudang_lovish/layout/content') ?>
<style>
    option {
    background:transparent; 
}
</style>
<?= $this->section('content') ?>


<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">Data Penjualan</h6>
        
        <button class="btn btn-success float-right mr-2" data-toggle="modal" data-target=".export-produk"><i class="fa fa-file-excel mr-2"></i>Import Penjualan</button>
        <div class="modal fade export-produk" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="<?= base_url('/import-penjualan') ?>" method="post" enctype="multipart/form-data">                    
                    <?php csrf_field() ?>
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Import Penjuelan</h5>
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
        
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th class="text-center">Tanggal</th>                        
                        <th class="text-center">Jenis Produk</th>
                        <th class="text-center">Model</th>
                        <th class="text-center">Warna</th>  
                        <th class="text-center">Size</th>  
                        <th class="text-center">Qty</th>   
                        <th class="text-center">Brand</th>             
                    </tr>
                </thead>
                
                <tbody>
                    <?php $no = 1; ?>
                    <?php if ($sellings->getNumRows() > 0) : ?>
                        <?php foreach($sellings->getResultObject() as $product) : ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td class="text-center"><?= date('m/d/Y', strtotime($product->created_at)) ?></td>
                                <td class="text-center"><?= $product->product_name ?></td>
                                <td class="text-center"><?= $product->model_name ?></td>
                                <td class="text-center"><?= $product->color ?></td>
                                <td class="text-center"><?= $product->size ?></td>
                                <td class="text-center"><?= $product->qty ?></td>
                                <td class="text-center"><?= $product->brand ?></td>
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
    var input = document.getElementById('file-upload');
    var infoArea = document.getElementById('file-upload-filename');
    input.addEventListener('change', showFileName);

    function showFileName(event) {
        var input = event.srcElement;
        var fileName = input.files[0].name;
        infoArea.textContent = '' + fileName;
    }
</script>
<?= $this->endSection() ?>