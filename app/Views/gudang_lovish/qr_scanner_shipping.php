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
                                    <h6 class="modal-title ml-2" id="exampleModalLabel">Scanning the box...</h6>
                                    <div class="wrapper">
                                        <div>
                                            <div id="video-wrapper">
                                                <video id="video" width="360" autoplay></video>
                                                <canvas id="canvas" width="0" height="0"></canvas>
                                            </div>
                                            <div>
                                            <div id="scanned"></div>
                                                <input type="hidden" class="box">
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
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>          
                        </div>
                        
                    </div>
                </div>
            </div>
            <table class="table table-bordered" id="dataTable1" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th class="text-center">Pengiriman</th>
                        <th class="text-center">Tanggal Buat</th>
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
                                    <th class="text-center">Jumlah</th>
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
<!-- <script src="/assets/js/main.js" async></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js" integrity="sha512-efUTj3HdSPwWJ9gjfGR71X9cvsrthIA78/Fvd/IN+fttQVy7XWkOAXb295j8B3cmm/kFKVxjiNYzKw9IQJHIuQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
    $(document).ready(function() {
        
        
    })

    $('#print').click(function(){
        const id = $(this).data('id');
        $('.bd-example-modal-lg-produk').modal('show');
        let codes = [];
        var audio = new Audio('/assets/sounds/beep.wav');
        
        const seen = new Set();
        // Create new barcode detector
        const barcodeDetector = new BarcodeDetector({ formats: ['qr_code'] });

        // Define custom element
        customElements.define('scaned-item', class extends HTMLElement {
        constructor() {
            super();
            const template = document.querySelector('#scaned-item').content;
            const shadowRoot = this.attachShadow({mode: 'open'}).appendChild(template.cloneNode(true));
        };
        });

        // Codes proxy/state
        const codesProxy = new Proxy(codes, {
        set (target, prop, value, receiver) {
            // Throw err if value is a number
            // Stops from saving undefined codes
            if (typeof value === 'number') throw value;
            
            target.push(value);

            // Check if code has already been scanned
            target = target.filter((c) => {
            if (c.rawValue !== window.barcodeVal) return c;
            const d = seen.has(c.rawValue);
            seen.add(c.rawValue);
            return !d;
            })
            
            // Select the container scanned
            const scanned = document.querySelector('#scanned')
            const temp = document.createElement('scaned-item')
            const format = document.createElement('span')
            const rawValue = document.createElement('span')

            // Goes into the custom elements formate slot
            format.setAttribute('slot', 'format');
            format.innerHTML = value.format;
            
            // Goes into the custom elements raw slot 
            rawValue.setAttribute('slot', 'raw');
            rawValue.innerHTML = value.rawValue;

            // Append elements to custom element
            temp.appendChild(rawValue);
            temp.appendChild(format);

            // Append Custom element to scanned container
            scanned.appendChild(temp);
            return true;
        }
        });

        // Get video element 
        const video = document.getElementById('video');

        // Check for a camera
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        const constraints = {
            audio: false,
            video: {
                facingMode: 'environment'
            }
        };
        
        // Start video stream
        navigator.mediaDevices.getUserMedia(constraints).then(stream => video.srcObject = stream);
        }

        // Draw outline to canvas 
        /* --NOTE-- 
        Some codes will not out line the whole barcode 
        instead may have a thin line this is because for a lot of 
        barcodes that is all that is needed.

        if you would like to out line the whole code you can have 
        a look at using the boundingBox object instead of 
        the cornerPoints array in this example it is not used 
        but my edit this to make a square around other codes
        that do not get outlined :) 
        */
        const drawCodePath = ({cornerPoints}) => {
        const canvas = document.querySelector('#canvas');
        const ctx = canvas.getContext('2d');
        const strokeGradient = ctx.createLinearGradient(0, 0, canvas.scrollWidth, canvas.scrollHeight);
        
        // Exit function and clear canvas if no corner points
        if (!cornerPoints) return ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Clear canvas for new redraw
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Create new gradient
        strokeGradient.addColorStop('0', '#c471ed');
        strokeGradient.addColorStop('1', '#f7797d');

        // Define stoke styles
        ctx.strokeStyle = strokeGradient;
        ctx.lineWidth = 4;

        // Begin draw
        ctx.beginPath();

        // Draw code outline path
        for (const [i, {x, y}] of cornerPoints.entries()) {
            if (i === 0) {
            // Move x half of the stroke width back 
            // makes the start and end corner line up
            ctx.moveTo(x - ctx.lineWidth/2, y);
            continue;
            }

            // Draw line from current pos to x, y
            ctx.lineTo(x, y);

            // Complete square draw to starting position
            if (i === cornerPoints.length-1) ctx.lineTo(cornerPoints[0].x, cornerPoints[0].y);
        }

        // Make path to stroke
        ctx.stroke();
        }

        // Detect code function 
        const detectCode = () => {
        barcodeDetector.detect(video).then(codes => {
            // If no codes exit function and clear canvas
            if (codes.length === 0) return drawCodePath({});
            
            for (const barcode of codes)  {
                const kode = barcode['rawValue'];
                $.post('/box-check-scanning', {qr: barcode['rawValue'], 'box_name': $('.box').val() }, function(data) {
                    const stat = JSON.parse(data);
                    if (stat == '1') {
                        $.notify(kode +' berhasil di-scan!', "success");      
                        $('.box').val(barcode['rawValue']);
                        $('#exampleModalLabel').html("Scanning the products ...");                                      
                    } else if (stat == '2') {
                        $.notify(kode +' berhasil di-scan!', "success");  
                        $('#exampleModalLabel').html("Scanning the products ...");    
                    } else {
                        $.notify("Warning: Data pengiriman tidak ada!", "warn");
                        $('#exampleModalLabel').html("Scanning the box ...");
                        // $('.bd-example-modal-lg-produk').modal('hide');
                    }
                }); 
                // Draw outline
                drawCodePath(barcode);
                audio.play();        
                // Code in seen set then exit loop 
                if (seen.has(barcode.rawValue)) return;
                        
                // Save barcode to window to use later on
                // then push to the codes proxy
                window.barcodeVal = barcode.rawValue;
                codesProxy.push(barcode);

            }
        }).catch(err => {
            console.error(err);
        })
        }

        setInterval(detectCode, 1000);
        // Run detect code function every 100 milliseconds
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
</script>
<?= $this->endSection() ?>