<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #section-to-print, #section-to-print * {
            visibility: visible;
        }
        #section-to-print {
            position: absolute;
            left: 0;
            top: 0;
        }
    }

    td {
        padding: 10px 10px 10px 10px;
    }
</style>
<?= $this->extend('admin/layout/content') ?>
<?= $this->section('content') ?>
<div id="qr-generator">
    <form id="generate-qr">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary float-left">Kain (Gudang Gesit)</h6>
            <button type="submit" id="print" class="btn btn-primary float-right"><i class="fa fa-qrcode mr-2"></i>Print</button>
        </div>
        <div class="card-body">        
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th class="text-center">Jenis</th>
                                <th class="text-center">Warna</th>
                                <th class="text-center">Berat (kg)</th>
                                <th class="text-center">Tanggal Masuk</th>
                                <th class="text-center" style="width: 7%">QR Code</th>
                                <th class="text-center" style="width: 7%;">Pilih <i class="fa fa-fas fa-angle-down"></i></th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <?php $no = 1; ?>
                            <?php if ($materials->getNumRows() > 0) : ?>
                                <?php foreach ($materials->getResultObject() as $kain) : ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td class=""><?= $kain->type ?></td>
                                        <td><?= $kain->color ?></td>
                                        <td><?= number_format($kain->weight/1000, 2) ?></td>                                    
                                        <td class="text-center"><?= $kain->created_at ?></td>
                                        <td class="text-center">
                                            <?php if (is_null($kain->qrcode)) :?>
                                                -
                                            <?php else: ?>
                                                <button class="show-qr" type="button" data-id='<?= $kain->id.'-'.substr($kain->type, 0, 3).'-'.substr($kain->color, 0, 3) ?>' value="<?= $kain->qrcode ?>"><i class="fa fa-qrcode"> </i></button>
                                            <?php endif ?>
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" name="print[]" value="<?= $kain->id ?>" />
                                        </td>
                                    </tr>
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
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
</div>
<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script>
	$(document).ready(function() {
        $('form#generate-qr').on('submit', function (e) {
            e.preventDefault();
            $.post('/generate-qr', $('form#generate-qr').serialize(), function(data) {
                const qr = JSON.parse(data);
                var id = 1;                
                for (var i = 0; i < qr.length; i+=3) {
                    $('#qr-handler').append('<tr>');
                    if (qr.length - i >= 3) {                        
                        $('#qr-handler').append('<td style="padding: 0px 0px 10px 0px"><img src="'+qr[i]['qr']+'" style="width: 1.5cm" /></td>');
                        $('#qr-handler').append('<td style="padding: 0px 100px 10px 100px"><img src="'+qr[i+1]['qr']+'" style="width: 1.5cm" /></td>');
                        $('#qr-handler').append('<td style="padding: 0px 0px 10px 0px"><img src="'+qr[i+2]['qr']+'" style="width: 1.5cm" /></td>');                        
                    } else if (qr.length - i == 2) {
                        $('#qr-handler').append('<td style="padding-left: 10px;padding-right: 10px;"><img src="'+qr[i]['qr']+'" style="width: 1.5cm" /></td>');
                        $('#qr-handler').append('<td style="padding-left: 10px;padding-right: 10px;"><img src="'+qr[i+1]['qr']+'" style="width: 1.5cm" /></td>');                        
                    } else {
                        $('#qr-handler').append('<td style="padding-left: 10px;padding-right: 10px;"><img src="'+qr[i]['qr']+'" style="width: 1.5cm" /></td>');
                    }
                    $('#qr-handler').append('</tr>');
                }
                $('#qr-modal').modal('show');
            });
        });
    });

    $('.show-qr').click(function() {
        const id = $(this).data('id');
        const img = $(this).val();
        $('#qrcode-img-show').attr('src', img);
        $('#desc-show').html(id);
        $('#qr-modal-show').modal('show');
    });

    $(document).on('click', '#print-qrcode', function() {
        var printContents = document.getElementById('print-area').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        // $("#qr-generator").load(window.location.href + "#qr-generator" );  
    });

</script>
<?= $this->endSection() ?>