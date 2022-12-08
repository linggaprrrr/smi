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
<div class="row">
    <div class="col-lg-6">
        <div class="wrapper">
            <div>
                <div id="video-wrapper">                    
                    <div id="qr-reader" style="width: 300px"></div>
                </div>
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
</div>
<?= $this->endSection() ?>
<?= $this->section('js') ?>
<!-- <script src="/assets/js/main.js" async></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js" integrity="sha512-efUTj3HdSPwWJ9gjfGR71X9cvsrthIA78/Fvd/IN+fttQVy7XWkOAXb295j8B3cmm/kFKVxjiNYzKw9IQJHIuQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    var audio = new Audio('/assets/sounds/beep.wav');
    
    function onScanSuccess(decodedText, decodedResult) {
        console.log(`Code scanned = ${decodedText}`, decodedResult);
        const qr = decodedText;
        const kode = qr.split("-"); 
        $.post('/product-out-scanning', {qr: qr}, function(data) {
            const stat = JSON.parse(data);
            if (stat == '1') {
                $.notify(kode[1] +' '+ kode[2] +' '+ kode[2] +' berhasil di-scan!', "success");
            } else {
                $.notify("Warning: Data produk tidak ada!", "warn");
            }
            audio.play();        
        });                   
    }
    var html5QrcodeScanner = new Html5QrcodeScanner(
    "qr-reader", { fps: 10, qrbox: 250 });
    html5QrcodeScanner.render(onScanSuccess);
</script>
<?= $this->endSection() ?>