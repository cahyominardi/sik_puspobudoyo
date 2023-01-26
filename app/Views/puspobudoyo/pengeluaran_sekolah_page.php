<?= $this->extend('layout/template_puspobudoyo'); ?>
<?= $this->section('content_puspobudoyo'); ?>

<div class="container">
    <div class="row">
        <div class="col">

            <h2>Halaman Informasi Keuangan Pengeluaran Sekolah</h2>
            <br>

            <div class="btn-group">
                <a href="/puspobudoyo/pemasukan_sekolah_page" class="btn btn-outline-primary" aria-current="page">Pemasukan Sekolah</a>
                <a href="/puspobudoyo/pengeluaran_sekolah_page" class="btn btn-outline-primary active">Pengeluaran Sekolah</a>

                <form action="" method="post">
                    <div class="input-group">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Cari data pengeluaran ..." name="keyword" style="margin-left:17.45rem;">
                        </div>
                        <button class="btn btn-secondary" type="submit" name="submit" style="margin-left:11.66rem;"> <img src="/img/search.svg"></button>
                    </div>
                </form>

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
                            <td><?= $AES->decrypt($pengeluaran['nama'], $key, $bit) ?> </td>
                            <td><?= $AES->decrypt($pengeluaran['keterangan'], $key, $bit) ?> </td>
                            <td><?= $pengeluaran['jumlah'] ?></td>
                            <td>Rp. <?= number_format($AES->decrypt($pengeluaran['nominal'], $key, $bit), 0, ',', '.') ?> </td>
                            <td>Rp. <?= number_format($AES->decrypt($pengeluaran['total'], $key, $bit), 0, ',', '.') ?></td>
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

<!-- Modal Search Date-->
<div class="modal fade" id="modalDate">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDateLabel">Masukkan Tanggal Periode</h5>
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