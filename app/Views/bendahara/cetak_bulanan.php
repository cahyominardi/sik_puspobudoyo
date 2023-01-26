<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename = Laporan Keuangan Bulanan $nama $month $year.xls");
?>

<html>

<body>
    <h2>Laporan Keuangan <?= $nama ?> Bulan <?= $month ?> <?= $year ?></h2>
    <h3>Pemasukan Bulan <?= $month ?> <?= $year ?></h3>
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Akun</th>
                <th>Keterangan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $number = 1;
            foreach ($pemasukan as $masuk) : ?>
                <tr>
                    <td align="center"><?= $number++ ?> </td>
                    <td><?= $masuk['created_at'] ?> </td>
                    <td><?= $masuk['nama'] ?> </td>
                    <td><?= $masuk['keterangan'] ?> </td>
                    <td>Rp. <?= number_format($masuk['total'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <h3>Pengeluaran <?= $month ?> <?= $year ?></h3>
    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Akun</th>
                <th>Keterangan</th>
                <th>Kuantitas</th>
                <th>Harga Satuan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $number = 1;
            foreach ($pengeluaran as $keluar) : ?>
                <tr>
                    <td align="center"><?= $number++ ?> </td>
                    <td><?= $keluar['created_at'] ?> </td>
                    <td><?= $keluar['nama'] ?> </td>
                    <td><?= $keluar['keterangan'] ?> </td>
                    <td align="center"><?= $keluar['jumlah'] ?> </td>
                    <td>Rp. <?= number_format($keluar['nominal'], 0, ',', '.') ?> </td>
                    <td>Rp. <?= number_format($keluar['total'], 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <br>
    <h4>Total Pemasukan: Rp. <?= number_format($total_pemasukan, 0, ',', '.') ?></h4>
    <h4>Total Pengeluaran : Rp. <?= number_format($total_pengeluaran, 0, ',', '.') ?></h4>
    <h4>Dana Sisa: Rp. <?= number_format($neraca, 0, ',', '.') ?></h4>
</body>

</html>