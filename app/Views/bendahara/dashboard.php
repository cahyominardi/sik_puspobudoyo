<?= $this->extend('layout/template_bendahara'); ?>
<?= $this->section('content_bendahara'); ?>

<div class="container">
    <div class="row">
        <div class="col">

            <h1>Selamat Datang, Bendahara <?= $nama ?>!</h1>
            <br>

            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>

            <div class="card-group">
                <div class="card text-white bg-success mb-3" style="max-width: 18rem; margin-left:7rem">
                    <div class="card-header">
                        <h5>Pemasukan Bulanan</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Pemasukan <?= $nama ?> 1 Bulan Terakhir : </p>
                        <p class="card-text">Rp. <?= number_format($pemasukan_bulanan, 0, ',', '.') ?></p>
                    </div>
                </div>

                <div class="card text-white bg-danger mb-3" style="max-width: 18rem; margin-left:1rem">
                    <div class="card-header">
                        <h5>Pengeluaran Bulanan</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Pengeluaran <?= $nama ?> 1 Bulan Terakhir : </p>
                        <p class="card-text">Rp. <?= number_format($pengeluaran_bulanan, 0, ',', '.') ?></p>
                    </div>
                </div>

                <div class="card text-white bg-primary mb-3" style="max-width: 18rem; margin-left:1rem">
                    <div class="card-header">
                        <h5>Neraca <?= $nama ?></h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Neraca : Rp. <?= number_format($neraca, 0, ',', '.') ?></p>
                    </div>
                </div>
            </div>

            <br>

            <a href="/bendahara/pemasukan_page">
                <img src="/img/pemasukan.png" alt="" class="pemasukan">
            </a>
            <a href="/bendahara/pengeluaran_page">
                <img src="/img/pengeluaran.png" alt="" class="pengeluaran">
            </a>
            <br>
            <br>
            <a href="/bendahara/transaksi_masuk_page">
                <img src="/img/lihat_keuangan.png" alt="" class="lihat_keuangan">
            </a>
            <a href="/bendahara/anggaran_page">
                <img src="/img/buat_anggaran.png" alt="" class="buat_anggaran">
            </a>
            <br>
            <br>
            <br>
            <br>
            <div>
                <canvas id="PemasukanBulanan"></canvas>
            </div>
            <br>
            <br>
            <div>
                <canvas id="PengeluaranBulanan"></canvas>
            </div>
            <br>
            <br>
            <div>
                <canvas id="PemasukanTahunan"></canvas>
            </div>
            <br>
            <br>
            <div>
                <canvas id="PengeluaranTahunan"></canvas>
            </div>
            <br>
            <br>
            <br>
        </div>
    </div>
</div>

<script>
    var ctx = document.getElementById('PemasukanBulanan').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'bar',

        // The data for our dataset
        data: {
            labels: ['<?= $nama_bln12 ?>', '<?= $nama_bln11 ?>', '<?= $nama_bln10 ?>', '<?= $nama_bln9 ?>', '<?= $nama_bln8 ?>', '<?= $nama_bln7 ?>', '<?= $nama_bln6 ?>', '<?= $nama_bln5 ?>', '<?= $nama_bln4 ?>', '<?= $nama_bln3 ?>', '<?= $nama_bln2 ?>', '<?= $nama_bln1 ?>'],
            datasets: [{
                label: 'Grafik Pemasukan Bulanan <?= $nama; ?>',
                backgroundColor: 'rgb(60, 148, 113)',
                borderColor: 'rgb(36, 121, 255)',
                data: [<?= $pemasukan_bln12 ?>, <?= $pemasukan_bln11 ?>, <?= $pemasukan_bln10 ?>, <?= $pemasukan_bln9 ?>, <?= $pemasukan_bln8 ?>, <?= $pemasukan_bln7 ?>, <?= $pemasukan_bln6 ?>, <?= $pemasukan_bln5 ?>, <?= $pemasukan_bln4 ?>, <?= $pemasukan_bln3 ?>, <?= $pemasukan_bln2 ?>, <?= $pemasukan_bln1 ?>]
            }]
        },

        // Configuration options go here
        options: {}
    });
</script>

<script>
    var ctx = document.getElementById('PengeluaranBulanan').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'bar',

        // The data for our dataset
        data: {
            labels: ['<?= $nama_bln12 ?>', '<?= $nama_bln11 ?>', '<?= $nama_bln10 ?>', '<?= $nama_bln9 ?>', '<?= $nama_bln8 ?>', '<?= $nama_bln7 ?>', '<?= $nama_bln6 ?>', '<?= $nama_bln5 ?>', '<?= $nama_bln4 ?>', '<?= $nama_bln3 ?>', '<?= $nama_bln2 ?>', '<?= $nama_bln1 ?>'],
            datasets: [{
                label: 'Grafik Pengeluaran Bulanan <?= $nama ?>',
                backgroundColor: 'rgb(255, 84, 81)',
                borderColor: 'rgb(36, 121, 255)',
                data: [<?= $pengeluaran_bln12 ?>, <?= $pengeluaran_bln11 ?>, <?= $pengeluaran_bln10 ?>, <?= $pengeluaran_bln9 ?>, <?= $pengeluaran_bln8 ?>, <?= $pengeluaran_bln7 ?>, <?= $pengeluaran_bln6 ?>, <?= $pengeluaran_bln5 ?>, <?= $pengeluaran_bln4 ?>, <?= $pengeluaran_bln3 ?>, <?= $pengeluaran_bln2 ?>, <?= $pengeluaran_bln1 ?>]
            }]
        },

        // Configuration options go here
        options: {}
    });
</script>

<script>
    var ctx = document.getElementById('PemasukanTahunan').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'bar',

        // The data for our dataset
        data: {
            labels: ['<?= $year5 ?>', '<?= $year4 ?>', '<?= $year3 ?>', '<?= $year2 ?>', '<?= $year1 ?>'],
            datasets: [{
                label: 'Grafik Pemasukan Tahunan <?= $nama ?>',
                backgroundColor: 'rgb(60, 148, 113)',
                borderColor: 'rgb(36, 121, 255)',
                data: [<?= $pemasukan_thn5 ?>, <?= $pemasukan_thn4 ?>, <?= $pemasukan_thn3 ?>, <?= $pemasukan_thn2 ?>, <?= $pemasukan_thn1 ?>]
            }]
        },

        // Configuration options go here
        options: {}
    });
</script>

<script>
    var ctx = document.getElementById('PengeluaranTahunan').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'bar',

        // The data for our dataset
        data: {
            labels: ['<?= $year5 ?>', '<?= $year4 ?>', '<?= $year3 ?>', '<?= $year2 ?>', '<?= $year1 ?>'],
            datasets: [{
                label: 'Grafik Pengeluaran Tahunan <?= $nama; ?>',
                backgroundColor: 'rgb(255, 84, 81)',
                borderColor: 'rgb(36, 121, 255)',
                data: [<?= $pengeluaran_thn5 ?>, <?= $pengeluaran_thn4 ?>, <?= $pengeluaran_thn3 ?>, <?= $pengeluaran_thn2 ?>, <?= $pengeluaran_thn1 ?>]
            }]
        },

        // Configuration options go here
        options: {}
    });
</script>


<?= $this->endSection(); ?>