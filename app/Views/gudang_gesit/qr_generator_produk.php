<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #print-area, #print-area * {
            visibility: visible;
        }
        #print-area {
            position: absolute;
            left: 0;
            top: 0;
        }
    }
    td {
        padding: 10px 10px 10px 10px;
    }
</style>
<?= $this->extend('gudang_gesit/layout/content') ?>
<?= $this->section('content') ?>
<form id="generate-qr">
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">Produk Keluar (Gudang Gesit)</h6>
        <button type="submit" id="print" class="btn btn-primary float-right"><i class="fa fa-qrcode mr-2"></i>Print</button>
    </div>
    <div class="card-body">        
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTableProdukPrint" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%">No</th>
                            <th class="text-center">Produk</th>
                            <th class="text-center">Model</th>
                            <th class="text-center">Warna</th>
                            <th class="text-center">Berat (gr)</th>
                            <th class="text-center">Qty</th>
                            <th class="text-center">Tanggal Masuk</th>
                            <th class="text-center" style="width: 5%;"><input type="checkbox" id="select-all" /></th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php $no = 1; ?>
                        <?php if ($products->getNumRows() > 0) : ?>
                            <?php foreach ($products->getResultObject() as $product) : ?>
                                <?php if (is_null($product->qrcode) || empty($product->qrcode)) :?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td class=""><?= $product->product_name ?></td>
                                        <td class=""><?= $product->model_name ?></td>
                                        <td><?= $product->color ?></td>
                                        <td><?= $product->weight ?></td>                                    
                                        <td class="text-center"><?= $product->qty ?></td>
                                        <td class="text-center"><?= $product->created_at ?></td>
                                        <td class="text-center">
                                            <input type="checkbox" class="unprinted" name="print[]" value="<?= $product->id ?>" />
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <tr class="table-info">
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td class=""><?= $product->product_name ?></td>
                                        <td class=""><?= $product->model_name ?></td>
                                        <td><?= $product->color ?></td>
                                        <td><?= $product->weight ?></td>    
                                        <td class="text-center"><?= $product->qty ?></td>                                
                                        <td class="text-center"><?= $product->created_at ?></td>
                                        <td class="text-center">
                                            <input type="checkbox" class="printed" name="print[]" value="<?= $product->id ?>" />
                                        </td>
                                    </tr>
                                <?php endif ?>
                                    
                                
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>
    </div>
</div>
</form>
<div class="modal fade bd-example-modal-lg-qr" id="qr-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">            
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">QR Code</h5>
                    
                </div>
                <div class="modal-body" id="print-area" style="align-self: center; margin-top: -5px">
                    <div style="align-self: center; margin-top: -5px">
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

<div class="modal fade bd-example-modal-lg-qr-show" id="qr-modal-show" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">            
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">QR Code</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center" id="print-area-show" >
                    <img id="qrcode-img-show" src="">
                    <h3 id="desc-show"></h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger"><i class="fa fa-print mr-2"></i>Print</button>
                </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script>
	$(document).ready(function() {
        $('form#generate-qr').on('submit', function (e) {
            e.preventDefault();
            $.post('/generate-qr-produk', $('form#generate-qr').serialize(), function(data) {
                const qr = JSON.parse(data);
                var id = 1;                                                
                $('#qr-handler').html("");
                for (var i = 0; i < qr.length; i++) {
                    const qrCount = parseInt(qr[i]['qty']);
                    const desc = qr[i]['key'].split("-");
                    for (var j = 0; j < qrCount; j+=3) {                                            
                        $('#qr-handler').append('<tr>');
                        if (qrCount - j >= 3) {         
                            $('#qr-handler').append('<td style="padding: 0px 0px 5px 0px"><img src="'+qr[i]['qr']+'" style="width: 1.3cm;float:left" /><small style="float:center;font-size:11px">'+desc[1]+'<br>'+desc[2]+'<br>'+desc[3]+'</small></td>');
                            $('#qr-handler').append('<td style="padding: 0px 20px 5px 20px"><img src="'+qr[i]['qr']+'" style="width: 1.3cm; float:left" /><small style="float:center; font-size:11px">'+desc[1]+'<br>'+desc[2]+'<br>'+desc[3]+'</small></td>');
                            $('#qr-handler').append('<td style="padding: 0px 0px 5px 0px"><img src="'+qr[i]['qr']+'" style="width: 1.3cm; float:left" /><small style="float:center; font-size:11px">'+desc[1]+'<br>'+desc[2]+'<br>'+desc[3]+'</small></td>');
                        } else if (qrCount - j == 2) {                            
                            $('#qr-handler').append('<td style="padding-left: 0px;padding-right: 0px;"><img src="'+qr[i]['qr']+'" style="width: 1.3cm;float:left" /><small style="float:center; font-size:11px">'+desc[1]+'<br>'+desc[2]+'<br>'+desc[3]+'</small></td>');
                            $('#qr-handler').append('<td style="padding-left: 20px;padding-right: 20px;"><img src="'+qr[i]['qr']+'" style="width: 1.3cm;float:left" /><small style="float:center; font-size:11px">'+desc[1]+'<br>'+desc[2]+'<br>'+desc[3]+'</small></td>');
                        } else {
                            $('#qr-handler').append('<td style="padding-left: 0px;padding-right: 0px;"><img src="'+qr[i]['qr']+'" style="width: 1.3cm;float:left" /><small style="float:center; font-size:11px">'+desc[1]+'<br>'+desc[2]+'<br>'+desc[3]+'</small></td>');
                        }
                        $('#qr-handler').append('</tr>');
                    }
                }

                $('#qr-modal').modal({backdrop: 'static', keyboard: false});
                $('#qr-modal').modal('show');
            });
        });

        $('#select-all').click(function() {
            $('.printed').prop('checked', this.checked);
        });

    });

    $('.show-qr').click(function() {
        const id = $(this).data('id');
        const img = $(this).val();
        $('#qrcode-img-show').attr('src', img);
        $('#desc-show').html(id);
        $('#qr-modal-show').modal('show');
    });


    $(document).on('click', '#print-qrcode-close', function() {
        setTimeout(location.reload.bind(location), 100);    
    });
    
    $(document).on('click', '#print-qrcode', function() {
        var printContents = document.getElementById('print-area').innerHTML;
        var winPrint = window.open('', '', 'left=0,top=0,width=800,height=600,toolbar=0,scrollbars=0,status=0');
        winPrint.document.body.innerHTML = printContents;
        winPrint.document.close();
        winPrint.focus();
        winPrint.print();
        winPrint.close(); 
        
       
    });
    
    $(document).on('click', '#print-qrcode-show', function() {
        var printContents = document.getElementById('print-area-show').innerHTML;
        var winPrint = window.open('', '', 'left=0,top=0,width=800,height=600,toolbar=0,scrollbars=0,status=0');
        winPrint.document.body.innerHTML = printContents;
        winPrint.document.close();
        winPrint.focus();
        winPrint.print();
        winPrint.close(); 
    });
</script>
<?= $this->endSection() ?>
