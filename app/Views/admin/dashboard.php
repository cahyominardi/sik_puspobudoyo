<?= $this->extend('layout/template_admin'); ?>
<?= $this->section('content_admin'); ?>

<div class="container">
    <div class="row">
        <div class="col">

            <h1>Selamat Datang, <?= $nama; ?> </h1>
            <br>
            <?php if (session()->getFlashdata('pesan_pengguna')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan_pengguna'); ?>
                </div>
            <?php endif; ?>
            <br>

            <a href="/admin/daftar_pengguna">
                <img src="/img/daftar_pengguna.png" alt="" class="daftar_pengguna">
            </a>
            <a href="">
                <img src="/img/pengaturan.png" alt="" class="pengaturan">
            </a>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>