<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename = Laporan Keuangan Tahunan $nama $year.xls");
?>

<html>

<body>
    <h1>Laporan Keuangan <?= $nama ?> Tahun <?= $year ?></h1>
    <br>
    <h2>Pemasukan Keuangan <?= $nama ?> Tahun <?= $year ?> </h2>
    <h3>Pemasukan Januari <?= $year ?></h3>
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
            foreach ($pemasukan1 as $masuk) : ?>
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
    <br>
    <h3>Pemasukan Februari <?= $year ?></h3>
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
            foreach ($pemasukan2 as $masuk) : ?>
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
    <br>
    <h3>Pemasukan Maret <?= $year ?></h3>
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
            foreach ($pemasukan3 as $masuk) : ?>
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
    <br>
    <h3>Pemasukan April <?= $year ?></h3>
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
            foreach ($pemasukan4 as $masuk) : ?>
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
    <br>
    <h3>Pemasukan Mei <?= $year ?></h3>
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
            foreach ($pemasukan5 as $masuk) : ?>
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
    <br>
    <h3>Pemasukan Juni <?= $year ?></h3>
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
            foreach ($pemasukan6 as $masuk) : ?>
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
    <br>
    <h3>Pemasukan Juli <?= $year ?></h3>
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
            foreach ($pemasukan7 as $masuk) : ?>
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
    <br>
    <h3>Pemasukan Agustus <?= $year ?></h3>
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
            foreach ($pemasukan8 as $masuk) : ?>
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
    <br>
    <h3>Pemasukan September <?= $year ?></h3>
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
            foreach ($pemasukan9 as $masuk) : ?>
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
    <br>
    <h3>Pemasukan Oktober <?= $year ?></h3>
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
            foreach ($pemasukan10 as $masuk) : ?>
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
    <br>
    <h3>Pemasukan November <?= $year ?></h3>
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
            foreach ($pemasukan11 as $masuk) : ?>
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
    <br>
    <h3>Pemasukan December <?= $year ?></h3>
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
            foreach ($pemasukan12 as $masuk) : ?>
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
    <h4>Total Pemasukan Tahun <?= $year ?>: Rp. <?= number_format($total_pemasukan, 0, ',', '.') ?></h4>
    <br>
    <br>
    <h2>Pengeluaran Keuangan <?= $nama ?> Tahun <?= $year ?> </h2>
    <h3>Pengeluaran Januari <?= $year ?></h3>
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
            foreach ($pengeluaran1 as $keluar) : ?>
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
    <h3>Pengeluaran Februari <?= $year ?></h3>
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
            foreach ($pengeluaran2 as $keluar) : ?>
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
    <h3>Pengeluaran Maret <?= $year ?></h3>
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
            foreach ($pengeluaran3 as $keluar) : ?>
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
    <h3>Pengeluaran April <?= $year ?></h3>
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
            foreach ($pengeluaran4 as $keluar) : ?>
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
    <h3>Pengeluaran Mei <?= $year ?></h3>
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
            foreach ($pengeluaran5 as $keluar) : ?>
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
    <h3>Pengeluaran Juni <?= $year ?></h3>
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
            foreach ($pengeluaran6 as $keluar) : ?>
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
    <h3>Pengeluaran Juli <?= $year ?></h3>
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
            foreach ($pengeluaran7 as $keluar) : ?>
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
    <h3>Pengeluaran Agustus <?= $year ?></h3>
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
            foreach ($pengeluaran8 as $keluar) : ?>
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
    <h3>Pengeluaran September <?= $year ?></h3>
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
            foreach ($pengeluaran9 as $keluar) : ?>
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
    <h3>Pengeluaran Oktober <?= $year ?></h3>
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
            foreach ($pengeluaran10 as $keluar) : ?>
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
    <h3>Pengeluaran November <?= $year ?></h3>
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
            foreach ($pengeluaran11 as $keluar) : ?>
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
    <h3>Pengeluaran December <?= $year ?></h3>
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
            foreach ($pengeluaran12 as $keluar) : ?>
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
    <h4>Total Pengeluaran Tahun <?= $year ?> : Rp. <?= number_format($total_pengeluaran, 0, ',', '.') ?></h4>
    <h4>Dana Sisa Tahun <?= $year ?>: Rp. <?= number_format($neraca, 0, ',', '.') ?></h4>
</body>

</html>