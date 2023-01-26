<?= $this->extend('layout/template_bendahara'); ?>
<?= $this->section('content_bendahara'); ?>

<div class="container">
    <div class="row">
        <div class="col">

            <h2>Halaman Rancangan Anggaran <?= $nama ?></h2>
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

            <button class="btn btn-primary mb-3" type="button" data-bs-toggle="modal" data-bs-target="#modalTambah">
                Tambah Rancangan Anggaran
            </button>

            <table id="anggaran" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $number = 1;
                    foreach ($anggaran as $row) : ?>
                        <tr>
                            <td><?= $number++ ?> </td>
                            <td><?= $row['created_at'] ?> </td>
                            <td><?= $row['nama'] ?> </td>
                            <td><?= $row['status'] ?> </td>
                            <td>
                                <div class="btn-group">
                                    <a href="/bendahara/detail_anggaran_page/<?= $row['id'] ?>" class="btn btn-outline-dark-inline btn-sm">
                                        <img src="/img/detail.svg">
                                    </a>
                                    <form action="/bendahara/delete_anggaran/<?= $row['id'] ?>" method="post" class="d-inline">
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
                        <th>Nama</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPrintLabel">Tambah Anggaran <?= $nama ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/bendahara/tambah_anggaran" method="post">
                    <?= csrf_field(); ?>
                    <div class="row mb-3">
                        <label for="nama" class="col-sm-2 col-form-label">Nama Anggaran</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama">
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
        $('#anggaran').DataTable();
    });
</script>

<?= $this->endSection(); ?>