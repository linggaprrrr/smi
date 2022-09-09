<?= $this->extend('admin/layout/content') ?>

<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">Data Pengiriman</h6>
        
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th class="text-center">Pengiriman</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">No. Resi</th>
                        <th class="text-center" style="width: 10%;"><i class="fas fa-info-circle"></i></th>                            
                    </tr>
                </thead>
                
                <tbody>
                    <?php $no = 1; ?>
                    <?php if ($shippings->getNumRows() > 0) : ?>
                        <?php foreach ($shippings->getResultObject() as $ship) : ?>
                            <?php if (is_null($ship->qrcode) || empty($ship->qrcode)) : ?>
                                <tr>
                                    <td class="text-center align-middle"><?= $no++ ?></td>
                                    <td class="align-middle"><?= $ship->box_name ?></td>                       
                                    <td class="text-center align-middle"><?= date('j F Y, H:m', strtotime($ship->created_at)) ?></td>
                                    <td class="text-center align-middle">
                                        <?php if (empty($ship->resi) || is_null($ship->resi)) : ?>
                                            -
                                        <?php else : ?>
                                            <?= $ship->resi ?>
                                        <?php endif ?>
                                    </td>
                                    <td class="text-center align-middle">                                           
                                        <a href="#" class="btn btn-default btn-icon-split btn-sm btn-detail-produk" data-id='<?= $ship->id ?>'>
                                            <span class="icon text-white-25">
                                                <i class="fas fa-box"></i>
                                            </span>
                                        </a>
                                    </td>                                                                            
                                </tr>
                            <?php else :?>
                                <tr class="table-info">
                                    <td class="text-center align-middle"><?= $no++ ?></td>
                                    <td class="align-middle"><?= $ship->box_name ?></td>                       
                                    <td class="text-center align-middle"><?= date('j F Y, H:m', strtotime($ship->created_at)) ?></td>
                                    <td class="text-center align-middle"><?= $ship->resi ?></td>
                                    <td class="text-center align-middle">                                            
                                        <a href="#" class="btn btn-info btn-icon-split btn-sm btn-detail-produk" data-id='<?= $ship->id ?>'>
                                            <span class="icon text-white-25">
                                                <i class="fas fa-box"></i>
                                            </span>
                                        </a>
                                    </td>                                                                                
                                </tr>
                            <?php endif ?>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
        <div class="modal fade bd-example-modal-lg-produk-detail" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Detail Pengiriman</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered">
                                <thead>
                                    <th style="width: 5%">No</th>
                                    <th>Produk</th>
                                    <th>Jumlah</th>
                                </thead>
                                <tbody id="detail-in">

                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
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
        $('.btn-detail-produk').click(function(){
            const id = $(this).data('id');
            var no = 1;

            $('#detail-in').html("");
            
            $.get('/get-pengiriman-detail', {ship_id: id})
                .done(function(data) {
                    const product = JSON.parse(data);
                    for (var i = 0; i < product.length; i++) {
                        $('#detail-in').append('<tr>');
                        $('#detail-in').append('<td>'+ no++ +'</td>');
                        $('#detail-in').append('<td>'+ product[i]['product_name'] +' '+ product[i]['model_name'] +' '+ product[i]['color'] +'</td>');
                        $('#detail-in').append('<td class="text-center">'+ product[i]['qty'] +'</td>');
                        $('#detail-in').append('</tr>');
                    }
            });
            $('.bd-example-modal-lg-produk-detail').modal('show');
        });

    });
    
</script>
<?= $this->endSection() ?>