<?php 
    $date = date("Y-m-d H:i:s");
    header("Content-Disposition: attachment; filename=Data Kain {$date}.xls");
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
                    <th class="text-center">Jenis</th>
                    <th class="text-center">Warna</th>
                    <th class="text-center">Berat (kg)</th>
                    <th class="text-center">Tanggal Masuk</th>
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
                                <td><?= number_format($kain->weight, 2) ?></td>
                                <td class="text-center"><?= $kain->created_at ?></td> 
                            </tr>
                        <?php endforeach ?>
                    <?php endif ?>
                </tbody>
        </table>
    </body>
</html>