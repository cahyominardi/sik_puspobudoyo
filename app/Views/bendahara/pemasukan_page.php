<?= $this->extend('layout/template_bendahara'); ?>
<?= $this->section('content_bendahara'); ?>

<div class="container">
    <div class="row">
        <div class="col">

            <h2>Halaman Pemasukan <?= $nama ?></h2>
            <br>

            <?php
            if (session()->getFlashdata('pesan')) : ?>
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
                    Tambah Pemasukan
                </button>

                <button class="btn btn-secondary mb-3" type="button" data-bs-toggle="modal" data-bs-target="#modalDate" style="margin-left:0.25rem;">
                    <img src="/img/date.png">
                </button>
            </div>

            <table id="pemasukan" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Akun</th>
                        <th>Keterangan</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Set timer -->
                    <?php $number = 1;
                    foreach ($keuangan as $pemasukan) : ?>
                        <tr>
                            <td><?= $number++ ?> </td>
                            <td><?= $pemasukan['created_at'] ?> </td>
                            <!-- Set timer -->
                            <td><?= $pemasukan['nama'] ?> </td>
                            <td><?= $pemasukan['keterangan'] ?> </td>
                            <td>Rp. <?= number_format($pemasukan['total'], 0, ',', '.') ?></td>
                            <!-- End Timer -->
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-outline-dark-inline btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $pemasukan['id'] ?>">
                                        <img src="/img/edit.svg">
                                    </button>
                                    <form action="/bendahara/delete_pemasukan/<?= $pemasukan['id'] ?>" method="post" class="d-inline">
                                        <?= csrf_field(); ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-outline-dark-inline btn-sm" onclick="return confirm('Are you sure?');"><img src="/img/delete.svg"></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <!-- sum(timer) -->
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Akun</th>
                        <th>Keterangan</th>
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
                <h5 class="modal-title" id="modalTambahLabel">Tambah Data Pemasukan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/bendahara/tambah_pemasukan" method="post">
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
                        <label for="nominal" class="col-sm-2 col-form-label">Total</label>
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
<?php foreach ($keuangan as $pemasukan) : ?>
    <div class="modal fade" id="modalEdit<?= $pemasukan['id'] ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit Data Pemasukan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/bendahara/edit_pemasukan/<?= $pemasukan['id'] ?>" method="post">
                        <?= csrf_field(); ?>

                        <div class="row mb-3">
                            <label for="nama" class="col-sm-2 col-form-label">Nama Akun</label>
                            <div class="col-sm-10">
                                <select id="nama" class="form-select" id="nama" name="nama" value="<?= $pemasukan['nama']; ?>">
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
                                <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?= $pemasukan['keterangan']; ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="nominal" class="col-sm-2 col-form-label">Total</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nominal" name="nominal" value="<?= $pemasukan['nominal']; ?>">
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
                <h5 class="modal-title" id="modalDateLabel">Cari Data Transaksi</h5>
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
        $('#pemasukan').DataTable();
    });
</script>

<?= $this->endSection(); ?>