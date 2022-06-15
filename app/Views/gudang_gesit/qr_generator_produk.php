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
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 5%">No</th>
                            <th class="text-center">Produk</th>
                            <th class="text-center">Model</th>
                            <th class="text-center">Warna</th>
                            <th class="text-center">Berat (gr)</th>
                            <th class="text-center">Tanggal Masuk</th>
                            <th class="text-center" style="width: 7%">QR Code</th>
                            <th class="text-center" style="width: 7%;">Pilih <i class="fa fa-fas fa-angle-down"></i></th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php $no = 1; ?>
                        <?php if ($products->getNumRows() > 0) : ?>
                            <?php foreach ($products->getResultObject() as $product) : ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td class=""><?= $product->product_name ?></td>
                                    <td class=""><?= $product->model_name ?></td>
                                    <td><?= $product->color ?></td>
                                    <td><?= $product->weight ?></td>                                    
                                    <td class="text-center"><?= $product->created_at ?></td>
                                    <td class="text-center">
                                        <?php if (is_null($product->qrcode)) :?>
                                            -
                                        <?php else: ?>
                                            <button class="show-qr" type="button" data-id='<?= $product->id.'-'.substr($product->product_name, 0, 1).''.$product->model_name.'-'.substr($product->color, 0, 3) ?>' value="<?= $product->qrcode ?>"><i class="fa fa-qrcode"> </i></button>
                                        <?php endif ?>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" name="print[]" value="<?= $product->id ?>" />
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
                    <table class="text-center"">  
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="section-to-print">
                            <tr>
                                <td style="padding-left: 10px;padding-right: 10px;"><img id="qr1" src="" width="56" height="56" /></td>
                                <td style="padding-left: 10px;padding-right: 10px;"><img id="qr2" src="" width="56" height="56" /></td>
                                <td style="padding-left: 10px;padding-right: 10px;"><img id="qr3" src="" width="56" height="56" /></td>
                            </tr>
                            <tr>
                                <td><small id="title1" style="font-size: 6px;"></small></td>
                                <td><small id="title2" style="font-size: 6px;"></small></td>
                                <td><small id="title3" style="font-size: 6px;"></small></td>
                            </tr>
                        </tbody>
                    </table>
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
<?= $this->endSection() ?>
<?= $this->section('js') ?>
<script>
	$(document).ready(function() {
        $('form#generate-qr').on('submit', function (e) {
            e.preventDefault();
            $.post('/generate-qr-produk', $('form#generate-qr').serialize(), function(data) {
                const qr = JSON.parse(data);
                var id = 1;                
                for (var i = 0; i < qr.length; i++) {
                    $('#qr'+id).attr('src', qr[i]['qr']);
                    $('#title'+id).html(qr[i]['key']);                    
                    id++;
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

    $('#print-qrcode').click(function() {
        window.print();
        location.reload();
    });
</script>
<?= $this->endSection() ?>