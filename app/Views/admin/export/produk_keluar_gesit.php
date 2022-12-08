<?php 
    $date = date("Y-m-d H:i:s");
    header("Content-Disposition: attachment; filename=Data Produk Gesit {$date}.xls");
    header("Content-Type: application/vnd.ms-excel;");
    header("Cache-Control: max-age=0");
    
?>

<html>
    <head>
        <style>
            table, td, th {
                border: 1px solid;
            }
        </style>
    </head>
    <body>
        <table>
            <thead>
                    <tr>
                        <th class="text-center" style="width: 5%">No</th>
                        <th class="text-center">Nama Produk</th>
                        <th class="text-center">Model</th>
                        <th class="text-center">Warna</th>
                        <th class="text-center">Berat (gr)</th>
                        <th class="text-center">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    <?php if ($productsIn->getNumRows() > 0) : ?>
                        <?php foreach ($productsIn->getResultObject() as $product) : ?>
                            <tr>
                                <td class="text-center"><?= $no++ ?></td>
                                <td><?= $product->product_name ?></td>
                                <td class="text-center"><?= $product->model_name ?></td>
                                <td><?= $product->color ?></td>
                                <td><?= $product->weight ?></td>
                                <td class="text-center"><?= $product->created_at ?></td>
                            
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
        </table>
    </body>
</html>