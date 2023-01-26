<?= $this->extend('layout/template_puspobudoyo'); ?>
<?= $this->section('content_puspobudoyo'); ?>

<div class="container">
    <div class="row">
        <div class="col">

            <h2>Halaman Pengajuan Anggaran Sekolah</h2>
            <br>

            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>

            <div class="btn-group">
                <a href="/puspobudoyo/anggaran_pagelaran_page" class="btn btn-outline-primary" aria-current="page">Pengajuan Anggaran Pagelaran</a>
                <a href="/puspobudoyo/anggaran_sekolah_page" class="btn btn-outline-primary active">Pengajuan Anggaran Sekolah</a>
                <a href="/puspobudoyo/anggaran_aset_page" class="btn btn-outline-primary">Pengajuan Anggaran Aset</a>
            </div>
            <br><br>

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
                    foreach ($anggaran as $sekolah) : ?>
                        <tr>
                            <td><?= $number++ ?> </td>
                            <td><?= $sekolah['created_at'] ?> </td>
                            <td><?= $sekolah['nama'] ?> </td>
                            <td><?= $sekolah['status'] ?> </td>
                            <td>
                                <div class="btn-group">
                                    <a href="/puspobudoyo/detail_anggaran_page/<?= $div_id ?>/<?= $sekolah['id'] ?>" class="btn btn-outline-dark-inline btn-sm">
                                        <img src="/img/detail.svg">
                                    </a>
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

<script>
    $(document).ready(function() {
        $('#anggaran').DataTable();
    });
</script>

<?= $this->endSection(); ?>