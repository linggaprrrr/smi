
<?= $this->extend('gudang_gesit/layout/content') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-lg-6">
        <div class="wrapper">
            <div>                
                <div>
                    <!-- <h6>Scanned: </h6> -->        
                            
                <div id="scanned"></div>
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
    <div class="col-lg-6">
        
    </div>
    <div class="col-lg-12">
        <form id="jual-reject">
            <input type="hidden" name="product" id="product-id">                                        
            <div class="form-group">
                <div id="video-wrapper" style="text-align: -webkit-center">                    
                    <div id="qr-reader" style="width: 300px"></div>
                </div>
            </div>
        </form>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-danger float-left">Daftar Penjualan Produk di-reject</h6>
                <!-- <button class="btn btn-secondary float-right scan-reject"><i class="fas fa-fw fa-qrcode mr-2"></i>Scan Reject</button> -->
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable3" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th class="text-center">Jenis Produk</th>
                                <th class="text-center">Model</th>
                                <th class="text-center">Warna</th>
                                <th class="text-center">Reject</th>
                                <th class="text-center">Tanggal Jual</th>                                
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php $no = 1; ?>
                            <?php if ($rejectedProducts->getNumRows() > 0) : ?>
                                <?php foreach ($rejectedProducts->getResultObject() as $product) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><div><?= $product->product_name ?></div></td>
                                        <td class="text-center"><?= $product->model_name ?></td>                                
                                        <td class="text-center"><?= $product->color ?></td>                         
                                        <td class="text-center"><?= strtoupper($product->category) ?></td>       
                                        <td class="text-center"><?= date('m/d/Y', strtotime($product->tanggal_jual)) ?></td>                                        
                                    </tr>
                                <?php endforeach ?>
                            <?php endif ?>
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('js') ?>
<!-- <script src="/assets/js/main.js" async></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js" integrity="sha512-efUTj3HdSPwWJ9gjfGR71X9cvsrthIA78/Fvd/IN+fttQVy7XWkOAXb295j8B3cmm/kFKVxjiNYzKw9IQJHIuQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
            $.post('/reject-in-sold-scanning', {qr: qr}, function(data) {            
                const stat = JSON.parse(data);          
                audio.play();   
                if (stat == '1') {
                    $.notify(kode[1] +' '+ kode[2] +' berhasil di-scan!', "success");  
                    $.post('/jual-reject', {id: kode[0], reject: reject}, function(data) {
                        const res = JSON.parse(data);                    
                    });                                                                
                } else {
                    $.notify("Warning: Produk tidak ada", "warn");
                }                
            }); 
            
        }
        
    }

    
    var html5QrcodeScanner = new Html5QrcodeScanner(
    "qr-reader", { fps: 10, qrbox: 250 });
    var scann = html5QrcodeScanner.render(onScanSuccess);
    
    $('.scan-reject').click(function() {
        $('#rejectModal').modal('show');   
    });

    $('.button-reject').click(function() {
        $.post( '<?= base_url('/jual-reject') ?>', $('form#jual-reject').serialize(), function(data) {
            const res = JSON.parse(data);
            if (res == '1') {
                $.notify('Produk reject berhasil disimpan!', "success");                     
            } else {
                $.notify("Warning: Data kain tidak ada!", "warn");
            }
            $('#product-id').val("");
            $('#rejectModal').modal('hide');   
        });
    });

    $('.button-close').click(function() {
        lastResult = 0;
        location.reload();
    });

</script>
<?= $this->endSection() ?>