<?= $this->extend('layout/template_puspobudoyo'); ?>
<?= $this->section('content_puspobudoyo'); ?>

<div class="container">
    <div class="row">
        <div class="col">

            <h2>Halaman Detail <?= $anggaran['nama'] ?> <?= $nama ?></h2>
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

                <a href="/puspobudoyo/setujui_anggaran/<?= $div_id ?>/<?= $id ?>" class="btn btn-success mb-3" onclick="return confirm('Apakah data <?= $anggaran['nama'] ?> <?= $nama ?> sudah sesuai untuk disetujui?');">Setujui Anggaran</a>

                <form action="" method="post">
                    <div class="input-group mb-3">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Cari detail anggaran ..." name="keyword" style="margin-left:23.45rem;">
                        </div>
                        <button class="btn btn-secondary" type="submit" name="submit" style="margin-left:17.6rem;"> <img src="/img/search.svg"></button>
                    </div>
                </form>

                <button class="btn btn-secondary mb-3" type="button" data-bs-toggle="modal" data-bs-target="#modalDate" style="margin-left:0.25rem;">
                    <img src="/img/date.png">
                </button>
            </div>

            <table id="detailAnggaran" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
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
                    foreach ($detail as $row) : ?>
                        <tr>
                            <td><?= $number++ ?> </td>
                            <td><?= $row['nama'] ?> </td>
                            <td><?= $row['keterangan'] ?> </td>
                            <td><?= $row['jumlah'] ?> </td>
                            <td>Rp. <?= number_format($row['nominal'], 0, ',', '.') ?> </td>
                            <td>Rp. <?= number_format($row['total'], 0, ',', '.') ?></td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-outline-dark-inline btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['id'] ?>">
                                        <img src="/img/edit.svg">
                                    </button>
                                    <form action="/puspobudoyo/delete_detail_anggaran/<?= $row['id'] ?>/<?= $div_id ?>/<?= $anggaran['id'] ?>" method="post" class="d-inline">
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
                <h5 class="modal-title" id="modalPrintLabel">Tambah Data Detail Anggaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/bendahara/tambah_detail_anggaran/<?= $id; ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="row mb-3">
                        <label for="nama" class="col-sm-2 col-form-label">Nama Akun</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama">
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
<?php foreach ($detail as $row) : ?>
    <div class="modal fade" id="modalEdit<?= $row['id'] ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditLabel">Edit Detail <?= $anggaran['nama'] ?> <?= $nama ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/puspobudoyo/edit_detail_anggaran/<?= $id; ?>/<?= $row['id'] ?>/<?= $div_id ?>" method="post">
                        <?= csrf_field(); ?>

                        <div class="row mb-3">
                            <label for="nama" class="col-sm-2 col-form-label">Nama Akun</label>
                            <div class="col-sm-10">
                                <select id="nama" class="form-select" id="nama" name="nama" value="<?= $row['nama']; ?>">
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
                                <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?= $row['keterangan']; ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="jumlah" class="col-sm-2 col-form-label">Kuantitas</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="jumlah" name="jumlah" value="<?= $row['jumlah']; ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="nominal" class="col-sm-2 col-form-label">Harga Satuan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nominal" name="nominal" value="<?= $row['nominal']; ?>">
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

<!-- Modal Upload -->
<div class="modal fade" id="modalImport">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPrintLabel">Import Anggaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/bendahara/import/<?= $id; ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field(); ?>
                    <div class="row mb-3">
                        <label for="file" class="col-sm-2 col-form-label">File Anggaran</label>
                        <div class="col-sm-10">
                            <div class="mb-3">
                                <input class="form-control" type="file" name="file" id="file" required accept=".xls, .xlsx">
                            </div>
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

<script>
    $(document).ready(function() {
        $('#detailAnggaran').DataTable();
    });
</script>

<?= $this->endSection(); ?>