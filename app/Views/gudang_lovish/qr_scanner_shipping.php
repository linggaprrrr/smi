<style>
    #canvas {
        position: absolute;
      }
      #scanned {
        display: flex;
        flex-direction: column;
        gap:1rem;
      }
      #video-wrapper {
        height: 890px;
        position: relative;
        border-radius: 10px;
        overflow: hidden;
      }
</style>
<?= $this->extend('gudang_lovish/layout/content') ?>

<?= $this->section('content') ?>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">Data Pengiriman</h6>
        <button type="button" id="print" class="btn btn-primary ml-2 float-right"><i class="fa fa-qrcode mr-2"></i>Scan</button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="modal fade bd-example-modal-lg-produk" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Pengiriman: <span id="pengiriman"></span></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12" style="text-align: center">
                                    <h6 class="modal-title ml-2" id="exampleModalLabel">Scanning resi...</h6>
                                    <div class="wrapper">
                                        <div>
                                            <div id="video-wrapper">                    
                                                <div id="qr-reader" style="width: 300px; margin-left: auto; margin-right: auto;"></div>
                                            </div>
                                            <div>
                                                <!-- <h6>Scanned: </h6> -->
                                            <div id="scanned"></div>
                                            <input type="hidden" class="box" >
                                            </div>
                                        </div>
                                    </div>   
                                    <template id="scaned-item">
                                    <style>
                                        .wrapper {
                                        
                                        border: none;
                                        border-radius: 1rem;
                                        padding: 1rem;
                                        background: linear-gradient(var(--gradient-start), var(--gradient-end));
                                        box-shadow: 0 3px -3px 10px #000;
                                        }
                                        .wrapper span {
                                        font-family: Arial, Helvetica, sans-serif;
                                        
                                        display: block;
                                        }
                                    </style>
                                    <div class="wrapper">
                                        <span><slot name="raw" class="data"></slot></span>
                                    </div>
                                    </template>
                                </div>
                                
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="close">Close</button>          
                        </div>
                        
                    </div>
                </div>
            </div>
            <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th class="text-center">Pengiriman</th>
                        <th class="text-center">Resi</th>
                        <th class="text-center" style="width: 15%;">Tanggal Buat</th>
                        <th class="text-center" style="width: 10%;"><i class="fas fa-box"></i></th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php $no = 1; ?>
                    <?php if ($shippings->getNumRows() > 0) : ?>
                        <?php foreach ($shippings->getResultObject() as $ship) : ?>
                            <?php if (is_null($ship->product_id) || empty($ship->product_id)) : ?>
                                <tr>
                                    <td class="text-center align-middle"><?= $no++ ?></td>
                                    <td class="align-middle"><?= $ship->box_name ?></td>                       
                                    <td class="text-center align-middle"><b><?= $ship->resi ?></b></td>                       
                                    <td class="text-center align-middle"><?= $ship->created_at ?></td>
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
                                    <td class="text-center align-middle"><b><?= $ship->resi ?></b></td>                       
                                    <td class="text-center align-middle"><?= $ship->created_at ?></td>
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
                            <h5 class="modal-title" >Detail Pengiriman</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table table-bordered">
                                <thead>
                                    <th style="width: 5%">No</th>
                                    <th>Produk</th>
                                    <th class="text-center">Jumlah</th>
                                </thead>
                                <tbody id="detail-in">

                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"  data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>
<?= $this->section('js') ?>
<!-- <script src="/assets/js/main.js" async></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js" integrity="sha512-efUTj3HdSPwWJ9gjfGR71X9cvsrthIA78/Fvd/IN+fttQVy7XWkOAXb295j8B3cmm/kFKVxjiNYzKw9IQJHIuQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    var audio = new Audio('/assets/sounds/beep.wav');        
    var lastResult, countResults = 0;
    function onScanSuccess(decodedText, decodedResult) {
        
        const qr = decodedText;
        const kode = decodedText.split("-");         
        if (decodedText !== lastResult) {
            ++countResults;
            lastResult = decodedText;
            $.post('/box-check-scanning', {qr: qr, 'box_name': $('.box').val() }, function(data) {
                const stat = JSON.parse(data);
                if (stat == '1') {
                    $.notify(kode +' berhasil di-scan!', "success");      
                    $('.box').val(qr);
                    $('#exampleModalLabel').html("Scanning the products ...");      
                    $.post('/tambah-pengiriman', function(data) {});                                
                } else if (stat == '2') {
                    $.notify(kode +' berhasil di-scan!', "success");  
                    $('#exampleModalLabel').html("Scanning the products ...");    
                } else {
                    $.notify("Warning: Data pengiriman tidak ada!", "warn");
                    $('#exampleModalLabel').html("Scanning the resi ...");
                    // $('.bd-example-modal-lg-produk').modal('hide');
                    $('.box').val(qr);
                }
                audio.play();
            }); 
            console.log(`Code scanned = ${decodedText}`, decodedResult);
        } else {
            $.notify("Resi atau Produk sudah discan!", "info");
        }
        
    }

    
    $('#print').click(function(){
        const id = $(this).data('id');
        $('.bd-example-modal-lg-produk').modal('show');
        var html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader", { fps: 10, qrbox: 250 });
        html5QrcodeScanner.render(onScanSuccess);
    });

    $('.btn-detail-produk').click(function(){
        const id = $(this).data('id');
        var no = 1;

        $('#detail-in').html("");
        $.get('/get-pengiriman-detail', {ship_id: id})
            .done(function(data) {
                const product = JSON.parse(data);
                console.log(product);
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

    $('#close').click(function() {
        console.log("kwkw");
        $('.bd-example-modal-lg-produk').modal('hide');
        setTimeout(location.reload.bind(location), 100);
    })
</script>
<?= $this->endSection() ?>