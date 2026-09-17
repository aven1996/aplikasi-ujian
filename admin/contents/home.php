<!-- IMAGE JUMBOTROM -->
<div class="img-home jumbotron jumbotron-fluid py-3" style="background: url(assets/img/profil_smk/<?= $sekolah['bg_sekolah'] ?>); background-repeat: none; background-size: cover; background-position: center center;">
  <div class="container">
    <div class="d-flex flex-column align-items-center">
        <img src="assets/img/profil_smk/<?= $sekolah['logo_sekolah'] ?>" alt="logo-smk" width="80" class="mb-3">
        <h2 class="d-inline-block text-center text-white bg-dark p-1 rounded" style="font-weight: bold; text-shadow:2px 2px 5px rgba(0,0,0,0.5); "><?= $sekolah['nama_sekolah']; ?></h2>
        <p class="lead d-inline-block text-center text-white bg-dark m-0 p-1 rounded" style="text-shadow:2px 2px 5px rgba(0,0,0,0.5); font-size:medium;">Kepala Sekolah - <?= $sekolah['nama_kepsek']; ?></p>
    </div>
  </div>
</div> 


<!-- SELAMAT DATANG -->
<div class="container pb-3">
    <h3 class="text-center">Selamat Datang, <b><?= $petugas; ?></b></h3>
</div>



<!-- PETUNJUK -->
<div class="container mb-3 rounded" style="background-color: lightgoldenrodyellow; border:1px solid rgba(0,0,0,0.1);">
    <div class="row align-items-center">
        <div class="col-sm-3 text-center">
            <img class="img-fan1" src="assets/img/svg/004-book.svg" alt="" style="width: 80%;">
        </div>
        <div class="col-sm-9 pt-3">
            <ul>
                <li class="p-0 mb-2" style="list-style: none; font-weight:bold; font-size:large;">Petunjuk  <b class="icon-lightbulb-o"></b></li>
                <li style="list-style: circle;">Admin menginput semua data sekolah secara berurutan mulai dari Profil, Kelas, Guru, Mata Pelajaran, Siswa dan Jenis Ujian.</li>
                <li style="list-style: circle;">Guru membuat atau mengupload Soal sesuai Mata Pelajaran yang diampu.</li>
                <li style="list-style: circle;">Admin mengatur Jadwal dan mengontrol Ujian.</li>
                <li style="list-style: circle;">Guru dan Admin dapat mengunduh atau mencetak Laporan dengan bentuk format Excel dan PDF.</li>
            </ul>
        </div>
    </div>
</div>


<!-- STATISTIK DATA -->
<div class="container">
    <div class="row">

        <div class="col-sm-3 mb-3">
            <div class="card bg-white">
                <div class="card-body text-center">
                    <h5 class="card-title text-secondary"><b class="icon-servers"></b> Soal</h5>
                    <h1 class="display-3 text-primary">21</h1>
                    <a href="?cnt=kelola_soal" class="btn btn-primary w-100">Selengkapnya</a>
                </div>
            </div>
        </div>

        <div class="col-sm-3 mb-3">
            <div class="card bg-white">
                <div class="card-body text-center">
                    <h5 class="card-title text-secondary"><b class="icon-user-tie"></b> Guru</h5>
                    <h1 class="display-3 text-danger">56</h1>
                    <a href="?cnt=guru" class="btn btn-danger w-100">Selengkapnya</a>
                </div>
            </div>
        </div>

        <div class="col-sm-3 mb-3">
            <div class="card bg-white">
                <div class="card-body text-center">
                    <h5 class="card-title text-secondary"><b class="icon-user"></b> Siswa</h5>
                    <h1 class="display-3 text-success">789</h1>
                    <a href="?cnt=siswa" class="btn btn-success w-100">Selengkapnya</a>
                </div>
            </div>
        </div>

        <div class="col-sm-3 mb-3">
            <div class="card bg-white">
                <div class="card-body text-center">
                    <h5 class="card-title text-secondary"><b class="icon-circle"></b> Jurusan</h5>
                    <h1 class="display-3 text-info">5</h1>
                    <a href="?cnt=kelas" class="btn btn-info w-100">Selengkapnya</a>
                </div>
            </div>
        </div>

    </div>
</div>