<?= $this->extend('layout/template_admin'); ?>
<?= $this->section('content_admin'); ?>

<div class="container">
    <div class="row">
        <div class="col">

            <h2>Ubah Profil <?= $edit['nama']; ?></h2>
            <br>

            <form action="/admin/update_profile/<?= $edit['id']; ?>" method="post">
                <?= csrf_field(); ?>
                <div class="row mb-3">
                    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control  <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" value="<?= $edit['nama']; ?>">
                        <div class=" invalid-feedback">
                            <?= $validation->getError('nama'); ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="email" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-7">
                        <input type="text" class="form-control  <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?= $AES->decrypt($edit['email'], $key, $bit); ?>">
                        <div class=" invalid-feedback">
                            <?= $validation->getError('email'); ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-7">
                        <input type="password" class="form-control  <?= ($validation->hasError('password')) ? 'is-invalid' : ''; ?>" id="password" name="password" value="">
                        <div class=" invalid-feedback">
                            <?= $validation->getError('password'); ?>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

<?= $this->endSection(); ?>