<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename = $detail[nama] $nama.xls");
?>

<html>

<body>
    <div class="text-center">
        <h2><?= $detail['nama'] ?> <?= $nama ?></h2>
    </div>
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Akun</th>
                <th>Keterangan</th>
                <th>Kuantitas</th>
                <th>Harga Satuan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $number = 1;
            foreach ($anggaran as $print) : ?>
                <tr>
                    <td align="center"><?= $number++ ?> </td>
                    <td><?= $print['nama'] ?> </td>
                    <td><?= $print['keterangan'] ?> </td>
                    <td align="center"><?= $print['jumlah'] ?> </td>
                    <td>Rp. <?= number_format($print['nominal'], 0, ',', '.') ?> </td>
                    <td>Rp. <?= number_format($print['total'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <h4>Total <?= $detail['nama'] ?> : Rp. <?= number_format($total, 0, ',', '.') ?></h4>
</body>

</html>