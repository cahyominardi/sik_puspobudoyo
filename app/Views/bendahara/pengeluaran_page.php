<?= $this->extend('layout/template_bendahara'); ?>
<?= $this->section('content_bendahara'); ?>

<div class="container">
    <div class="row">
        <div class="col">

            <h2>Halaman Pengeluaran <?= $nama ?></h2>
            <br>

            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('pesan_error')) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= session()->getFlashdata('pesan_error'); ?>
                </div>
            <?php endif; ?>

            <div class="btn-group">
                <button class="btn btn-primary mb-3" type="button" data-bs-toggle="modal" data-bs-target="#modalTambah">
                    Tambah Pengeluaran
                </button>

                <button class="btn btn-secondary mb-3 float-end" type="button" data-bs-toggle="modal" data-bs-target="#modalDate" style="margin-left:0.25rem;">
                    <img src="/img/date.png">
                </button>
            </div>

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
                        <th>Aksi</th>
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
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-outline-dark-inline btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $pengeluaran['id'] ?>">
                                        <img src="/img/edit.svg">
                                    </button>
                                    <form action="/bendahara/delete_pengeluaran/<?= $pengeluaran['id'] ?>" method="post" class="d-inline">
                                        <?= csrf_field(); ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-outline-dark-inline btn-sm" onclick="return confirm('Are you sure?');"><img src="/img/delete.svg"></button>
                                    </form>
                                </div>
                            </td>
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
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
            <br>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPrintLabel">Tambah Data Pengeluaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/bendahara/tambah_pengeluaran" method="post">
                    <?= csrf_field(); ?>
                    <div class="row mb-3">
                        <label for="nama" class="col-sm-2 col-form-label">Nama Akun</label>
                        <div class="col-sm-10">
                            <select id="nama" class="form-select" id="nama" name="nama">
                                <option>
                                    <--------------- Pilih Nama Akun --------------->
                                </option>
                                <?php foreach ($nama_akun as $akun) : ?>
                                    <option value="<?= $akun['nama_akun'] ?>"><?= $akun['nama_akun'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="keterangan" name="keterangan">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="jumlah" class="col-sm-2 col-form-label">Kuantitas</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="jumlah" name="jumlah">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="nominal" class="col-sm-2 col-form-label">Harga Satuan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nominal" name="nominal">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<?php foreach ($keuangan as $pengeluaran) : ?>
    <div class="modal fade" id="modalEdit<?= $pengeluaran['id'] ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit Data Pengeluaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/bendahara/edit_pengeluaran/<?= $pengeluaran['id'] ?>" method="post">
                        <?= csrf_field(); ?>

                        <div class="row mb-3">
                            <label for="nama" class="col-sm-2 col-form-label">Nama Akun</label>
                            <div class="col-sm-10">
                                <select id="nama" class="form-select" id="nama" name="nama" value="<?= $pengeluaran['nama']; ?>">
                                    <option>
                                        <--------------- Pilih Nama Akun --------------->
                                    </option>
                                    <?php foreach ($nama_akun as $akun) : ?>
                                        <option value="<?= $akun['nama_akun'] ?>"><?= $akun['nama_akun'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?= $pengeluaran['keterangan']; ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="jumlah" class="col-sm-2 col-form-label">Kuantitas</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="jumlah" name="jumlah" value="<?= $pengeluaran['jumlah']; ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="nominal" class="col-sm-2 col-form-label">Harga Satuan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nominal" name="nominal" value="<?= $pengeluaran['nominal']; ?>">
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Modal Search Date-->
<div class="modal fade" id="modalDate">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDateLabel">Cari Tanggal Transaksi</h5>
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