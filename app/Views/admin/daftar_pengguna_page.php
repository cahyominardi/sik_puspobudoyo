<?= $this->extend('layout/template_admin'); ?>
<?= $this->section('content_admin'); ?>

<div class="container">
    <div class="row">
        <div class="col">

            <h1>Daftar Pengguna</h1>
            <br>

            <?php if (session()->getFlashdata('pesan_pengguna')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan_pengguna'); ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('pesan_error')) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= session()->getFlashdata('pesan_error'); ?>
                </div>
            <?php endif; ?>

            <button class="btn btn-primary mb-3" type="button" data-bs-toggle="modal" data-bs-target="#modalTambah">
                Tambah Pengguna
            </button>

            <table class="table table-bordered border-dark">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Username</th>
                        <th scope="col">Peran</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($daftarPengguna as $daftarP) : ?>
                        <tr>
                            <td><?= $no++ ?> </td>
                            <td><?= $daftarP['nama'] ?></td>
                            <td><?= $AES->decrypt($daftarP['email'], $key, $bit) ?></td>
                            <?php if ($daftarP['role_id'] == 1 && $daftarP['divisi_id'] == 1) {
                                $peran = 'Administrator';
                            } elseif ($daftarP['role_id'] == 2 && $daftarP['divisi_id'] == 1) {
                                $peran = 'Bendahara Puspo Budoyo';
                            } elseif ($daftarP['role_id'] == 3 && $daftarP['divisi_id'] == 2) {
                                $peran = 'Bendahara Divisi (Pagelaran)';
                            } elseif ($daftarP['role_id'] == 3 && $daftarP['divisi_id'] == 3) {
                                $peran = 'Bendahara Divisi (Sekolah Budaya)';
                            } elseif ($daftarP['role_id'] == 3 && $daftarP['divisi_id'] == 4) {
                                $peran = 'Bendahara Divisi (Aset)';
                            } else {
                                $peran = 'Unidentified';
                            };
                            ?>
                            <td><?= $peran ?></td>
                            <td>
                                <div class="btn-group">

                                    <button class="btn btn-outline-dark-inline btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $daftarP['id']; ?>">
                                        <img src="/img/edit.svg">
                                    </button>
                                    <form action="/admin/delete_pengguna/<?= $daftarP['id']; ?>" method="post" class="d-inline">
                                        <?= csrf_field(); ?>
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-outline-dark-inline btn-sm" onclick="return confirm('Are you sure?');"><img src="/img/delete.svg"></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <br>
            <br>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPrintLabel">Tambah Data Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/admin/tambah_pengguna" method="post">
                    <?= csrf_field(); ?>
                    <div class="row mb-3">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= old('nama'); ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="email" name="email" value="<?= old('email'); ?>">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="password" name="password" value="<?= old('password'); ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="role_id" class="col-sm-2 col-form-label">Peran</label>
                        <div class="col-sm-10">
                            <select id="role_id" class="form-select" id="role_id" name="role_id" value="<?= old('role_id'); ?>">
                                <option>
                                    <----- Pilih Peran Bendahara ----->
                                </option>
                                <?php foreach ($list_peran as $role) : ?>
                                    <option value="<?= $role['role_id'] ?>"><?= $role['role'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="divisi_id" class="col-sm-2 col-form-label">Divisi</label>
                        <div class="col-sm-10">
                            <select id="divisi_id" class="form-select" id="divisi_id" name="divisi_id" value="<?= old('divisi_id'); ?>">
                                <option>
                                    <----- Pilih Divisi Bendahara ----->
                                </option>
                                <?php foreach ($divisi as $div) : ?>
                                    <option value="<?= $div['divisi_id'] ?>"><?= $div['divisi'] ?></option>
                                <?php endforeach; ?>
                            </select>
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
<?php foreach ($daftarPengguna as $daftarP) : ?>
    <div class="modal fade" id="modalEdit<?= $daftarP['id'] ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPrintLabel">Edit Data Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/admin/edit_pengguna/<?= $daftarP['id']; ?>" method="post">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="id" id="id_pengguna">
                        <div class="row mb-3">
                            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nama" name="nama" value="<?= $daftarP['nama']; ?>">
                            </div>
                        </div>
                        <div class=" row mb-3">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="email" name="email" value="<?= $AES->decrypt($daftarP['email'], $key, $bit); ?>">
                            </div>
                        </div>
                        <div class=" row mb-3">
                            <label for="password" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="role_id" class="col-sm-2 col-form-label">Peran</label>
                            <div class="col-sm-10">
                                <select id="role_id" class="form-select" id="role_id" name="role_id" value="<?= $daftarP['role_id']; ?>">
                                    <option>
                                        <----- Pilih Peran Bendahara ----->
                                    </option>
                                    <?php foreach ($list_peran as $role) : ?>
                                        <option value="<?= $role['role_id'] ?>"><?= $role['role'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="divisi_id" class="col-sm-2 col-form-label">Divisi</label>
                            <div class="col-sm-10">
                                <select id="divisi_id" class="form-select" id="divisi_id" name="divisi_id" value="<?= $daftarP['divisi_id']; ?>">
                                    <option>
                                        <----- Pilih Divisi Bendahara ----->
                                    </option>
                                    <?php foreach ($divisi as $div) : ?>
                                        <option value="<?= $div['divisi_id'] ?>"><?= $div['divisi'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                </div>
                <div class=" modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?= $this->endSection(); ?>