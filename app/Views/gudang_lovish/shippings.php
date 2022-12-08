<?= $this->extend('gudang_lovish/layout/content') ?>
<style>
    table, th, td {
        vertical-align: middle;
    }
</style>
<?= $this->section('content') ?>

<form id="generate-qr">
<div class="card shadow mb-4"> 
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">Data Pengiriman</h6>
        <button type="submit" id="print" class="btn btn-primary ml-2 float-right"><i class="fa fa-qrcode mr-2"></i>Print</button>
        <button type="button" id="add" class="btn btn-info float-right "><i class="fa fa-plus mr-2"></i>Tambah Pengiriman</button>
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
                        <th class="text-center" style="width: 10%;"><i class="fas fa-info"></i></th>
                        <th class="text-center" style="width: 5%;"><input type="checkbox" id="select-all" /></th>
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
                                    <td class="text-center align-middle"><?= $ship->created_at ?></td>
                                    <td class="text-center align-middle">
                                        <?php if (empty($ship->resi) || is_null($ship->resi)) : ?>
                                            -
                                        <?php else : ?>
                                            <?= $ship->resi ?>
                                        <?php endif ?>
                                    </td>
                                    <td class="text-center align-middle">
                                        <a href="#" class="btn btn-warning btn-icon-split btn-sm btn-resi-produk" data-id='<?= $ship->id ?>'>
                                            <span class="icon text-white-25">
                                                <i class="fas fa-pen"></i>
                                            </span>
                                        </a>
                                        <a href="#" class="btn btn-default btn-icon-split btn-sm btn-detail-produk" data-id='<?= $ship->id ?>'>
                                            <span class="icon text-white-25">
                                                <i class="fas fa-box"></i>
                                            </span>
                                        </a>
                                    </td>
                                    <td class="text-center align-middle">
                                        <input type="checkbox"  class="unprinted" name="print[]" value="<?= $ship->id ?>" />
                                    </td>
                                    
                                </tr>
                            <?php else :?>
                                <tr class="table-info">
                                    <td class="text-center align-middle"><?= $no++ ?></td>
                                    <td class="align-middle"><?= $ship->box_name ?></td>                       
                                    <td class="text-center align-middle"><?= $ship->created_at ?></td>
                                    <td class="text-center align-middle"><?= $ship->resi ?></td>
                                    <td class="text-center align-middle">
                                        <a href="#" class="btn btn-warning btn-icon-split btn-sm btn-resi-produk" data-id='<?= $ship->id ?>'>
                                            <span class="icon text-white-25">
                                                <i class="fas fa-pen"></i>
                                            </span>
                                        </a>
                                        <a href="#" class="btn btn-info btn-icon-split btn-sm btn-detail-produk" data-id='<?= $ship->id ?>'>
                                            <span class="icon text-white-25">
                                                <i class="fas fa-box"></i>
                                            </span>
                                        </a>
                                    </td>
                                    <td class="text-center align-middle">
                                        <input type="checkbox" name="print[]" value="<?= $ship->id ?>" />
                                    </td>
                                    
                                </tr>
                            <?php endif ?>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
            </table>
        </div>
        <div class="modal fade bd-example-modal-lg-qr" id="qr-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">            
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">QR Code</h5>                        
                            
                        </div>
                        <div class="modal-body" id="print-area" style="align-self: center;">              
                            <div style="align-self: center;">
                                <table class="text-center"">  
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="qr-handler">
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="print-qrcode-close" class="btn btn-secondary" id="close" data-dismiss="modal">Close</button>
                            <button type="button" id="print-qrcode" class="btn btn-danger"><i class="fa fa-print mr-2"></i>Print</button>
                        </div>
                </div>
            </div>
        </div>
    </div>
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
</form>
<div class="modal fade bd-example-modal-lg-produk-resi" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="<?= base_url('/update-resi') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Resi Pengiriman</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Pengiriman</label>
                        <input type="hidden" name="id" id="id-pengiriman"> 
                        <input type="text" class="form-control" disabled id="pengiriman">             
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal</label>
                        <input type="text" class="form-control" disabled id="tanggal">             
                    </div>
                    <div class="form-group">
                        <label for="">Resi*</label>
                        <input type="text" class="form-control" name="resi" id="resi">             
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




<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {

        $('form#generate-qr').on('submit', function (e) {
            e.preventDefault();
            $.post('/generate-qr-shipment', $('form#generate-qr').serialize(), function(data) {
                const qr = JSON.parse(data);
                var id = 1;           
                console.log(qr);
                $('#qr-handler').html("");
                for (var i = 0; i < qr.length; i+=3) {
                    
                    $('#qr-handler').append('<tr>');
                    if (qr.length - i >= 3) {                        
                        const desc1 = qr[i]['key'].split("-");
                        const desc2 = qr[i+1]['key'].split("-");
                        const desc3 = qr[i+2]['key'].split("-");
                        $('#qr-handler').append('<td style="padding: 0px 0px 10px 0px"><img src="'+qr[i]['qr']+'" style="width: 1.5cm;float:left" /><small style="float:right">'+desc1[1]+'</small></td>');
                        $('#qr-handler').append('<td style="padding: 0px 20px 10px 20px"><img src="'+qr[i+1]['qr']+'" style="width: 1.5cm; float:left" /><small style="float:right">'+desc2[1]+'</small></td>');
                        $('#qr-handler').append('<td style="padding: 0px 0px 10px 0px"><img src="'+qr[i+2]['qr']+'" style="width: 1.5cm; float:left"" /><small style="float:right">'+desc3[1]+'</small></td>');                        
                    } else if (qr.length - i == 2) {
                        const desc1 = qr[i]['key'].split("-");
                        const desc2 = qr[i+1]['key'].split("-");
                        $('#qr-handler').append('<td style="padding-left: 0px;padding-right: 0px;"><img src="'+qr[i]['qr']+'" style="width: 1.5cm;float:left" /><small style="float:right">'+desc1[1]+'</small></td>');
                        $('#qr-handler').append('<td style="padding-left: 20px;padding-right: 20px;"><img src="'+qr[i+1]['qr']+'" style="width: 1.5cm;float:left" /><small style="float:right">'+desc2[1]+'</small></td>');                        
                    } else {
                        const desc1 = qr[i]['key'].split("-");
                        $('#qr-handler').append('<td style="padding-left: 0px;padding-right: 0px;"><img src="'+qr[i]['qr']+'" style="width: 1.5cm;float:left" /><small style="float:right">'+desc1[1]+'</small></td>');
                    }
                    $('#qr-handler').append('</tr>');
                }

                $('#qr-modal').modal({backdrop: 'static', keyboard: false});
                $('#qr-modal').modal('show');  
            });
        });

        $('#select-all').click(function() {
            $('.unprinted').prop('checked', this.checked);
        });

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
        
        $('.btn-resi-produk').click(function(){
            const id = $(this).data('id');
            $.get('/get-pengiriman-resi', {ship_id: id})
                .done(function(data) {
                    const product = JSON.parse(data);
                    $('#id-pengiriman').val(product['id']);
                    $('#pengiriman').val(product['box_name']);
                    $('#tanggal').val(product['created_at']);
                    $('#resi').val(product['resi']);
            });
            $('.bd-example-modal-lg-produk-resi').modal('show');
        });

        $(document).on('click', '#print-qrcode-close', function() {
            setTimeout(location.reload.bind(location), 100);    
        });
    
        $('#add').click(function() {
            $.post('/tambah-pengiriman', function(data) {
                setTimeout(location.reload.bind(location), 500);
            });
        });
    });
    
</script>
<?= $this->endSection() ?>