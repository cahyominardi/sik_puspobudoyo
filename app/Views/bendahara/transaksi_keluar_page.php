<?= $this->extend('layout/template_bendahara'); ?>
<?= $this->section('content_bendahara'); ?>

<div class="container">
    <div class="row">
        <div class="col">

            <h2>Halaman Informasi Keuangan <?= $nama ?></h2>
            <br>

            <div class="btn-group">
                <a href="/bendahara/transaksi_masuk_page" class="btn btn-outline-primary" aria-current="page">Transaksi Masuk</a>
                <a href="/bendahara/transaksi_keluar_page" class="btn btn-outline-primary active">Transaksi Keluar</a>

                <div class="dropdown d-inline">
                    <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" style="margin-left:0.25rem;">
                        Cetak Laporan
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="/bendahara/cetak_laporan_bulanan">Cetak Laporan Bulan Terakhir</a></li>
                        <li><a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#modalPrint">Cetak Laporan Periode</a></li>
                        <li><a class="dropdown-item" href="/bendahara/cetak_laporan_tahunan">Cetak Laporan Tahun Terakhir</a></li>
                    </ul>
                </div>

                <button class="btn btn-secondary" type="button" data-bs-toggle="modal" data-bs-target="#modalDate" style="margin-left:0.25rem;">
                    <img src="/img/date.png">
                </button>
            </div>

            <br> <br>

            <table id="pengeluaran" class="table table-striped" style="width:100%">
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
                    foreach ($keuangan as $pengeluaran) : ?>
                        <tr>
                            <td><?= $number++ ?> </td>
                            <td><?= $pengeluaran['created_at'] ?></td>
                            <td><?= $pengeluaran['nama'] ?> </td>
                            <td><?= $pengeluaran['keterangan'] ?> </td>
                            <td><?= $pengeluaran['jumlah'] ?></td>
                            <td>Rp. <?= number_format($pengeluaran['nominal'], 0, ',', '.') ?> </td>
                            <td>Rp. <?= number_format($pengeluaran['total'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Akun</th>
                        <th>Keterangan</th>
                        <th>Kuantitas</th>
                        <th>Harga Satuan</th>
                        <th>Total</th>
                    </tr>
                </tfoot>
            </table>
            <br>

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalPrint">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPrintLabel">Masukkan Tanggal Periode</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/bendahara/cetak_laporan_periode" method="post">
                    <div class="form-group mb-3">
                        <label for="">Start Date</label>
                        <input type="date" name="startdate" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">End Date</label>
                        <input type="date" name="enddate" class="form-control">
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Cetak Laporan</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Search Date-->
<div class="modal fade" id="modalDate">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDateLabel">Pencarian Data Berdasarkan Tanggal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="form-group mb-3">
                        <label for="">Start Date</label>
                        <input type="date" name="startdate" class="form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">End Date</label>
                        <input type="date" name="enddate" class="form-control">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Search</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#pengeluaran').DataTable();
    });
</script>

<?= $this->endSection(); ?>