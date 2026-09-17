<?php
    // start session
    session_start();

    //set timezone indonesia
	date_default_timezone_set("Asia/Jakarta");

    // load plugin
    include "../PHPExcel/IOFactory.php";

    // load modules
    include "modules/connect.php";
    include "modules/general_func.php";
    include "modules/profil.php";
    include "modules/logout.php";
    include "modules/jurusan.php";
    include "modules/kelas.php";
    include "modules/guru.php";
    include "modules/mapel.php";
    include "modules/pengampu.php";
    include "modules/siswa.php";
    include "modules/jenis_ujian.php";
    include "modules/soal.php";
    include "modules/butir_soal.php";
    include "modules/media_pendukung.php";
    include "modules/jadwal.php";
    include "modules/status.php";
    include "modules/ujian.php";
    include "modules/siswa_login.php"; 
    include "modules/berita_acara.php"; 
    include "modules/laporan.php";

    // jika belum login
    if(!isset($_SESSION['petugas'])){
        header("Location: index.php");
    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APPUS Lite | Aplikasi Ujian Semester SMK</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="shortcut icon" href="assets/img/icon.ico" type="image/x-icon">

    <!-- font google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@400;700&display=swap" rel="stylesheet">

    <!-- iconmoon -->
    <link rel="stylesheet" href="assets/img/icomoon/style.css">
    <link rel="stylesheet" href="assets/img/icomoon2/style.css">

    <!-- css cdn datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    
    <!-- myCSS -->
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body class="pb-5">
<!-- NAV HAEDER -->
<nav class="navbar navbar-expand-lg navbar-dark bg-info">
    <a class="navbar-brand" href="?cnt=home">
        <img src="assets/img/logo_putih.svg" width="150" height="30" alt="">
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <?php if($_SESSION['petugas'] == "admin"): ?>
            <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Sekolah
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="?cnt=profil">Profil</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="?cnt=kelas">Kelas</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="?cnt=guru">Guru</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="?cnt=mapel">Mata Pelajaran</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="?cnt=siswa">Siswa</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="?cnt=jenis_ujian">Jenis Ujian</a>
                </div>
            </li>
            <?php endif; ?>

            <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Soal
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="?cnt=kelola_soal">Kelola Soal</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="?cnt=media_pendk">Media Pendukung</a>
                </div>
            </li>

            <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Ujian
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="?cnt=status">Status</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="?cnt=siswa_login">Siswa Login</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="?cnt=jadwal">Jadwal</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="?cnt=berita_acara">Berita Acara</a>
                </div>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="?cnt=laporan">Laporan</a>
            </li>
        </ul>


        <div class="my-2 my-lg-0">
            <ul class="navbar-nav mr-auto w-auto">
                <div class="navbar-brand text-center">
                    <!-- gambar akan berubah sesuai akun petugas [admin/guru] -->
                    <?php if($_SESSION['petugas'] == 'admin') : ?>
                        <img src="assets/img/icon_admin.svg" width="30" height="30" alt="" title="Kamu seorang admin">
                    <?php else: ?>
                        <img src="assets/img/guru_icon.svg" width="30" height="30" alt="" title="Kamu seorang guru">
                    <?php endif; ?>
                </div>
                <li class="nav-item dropdown active w-auto text-center" style="min-width: 150px;">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= $petugas; ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <?php if($_SESSION['petugas'] == "admin"): ?>
                        <a class="dropdown-item text-secondary" href="#" data-toggle="modal" data-target="#setting"><b class="icon-cog"></b> Setting</a>
                        <div class="dropdown-divider"></div>
                        <?php endif; ?>
                        <a class="dropdown-item text-secondary" href="#" data-toggle="modal" data-target="#konfirmasi_logout"><b class="icon-sign-out"></b> Log Out</a>
                    </div>
                </li>
            </ul>
        </div>

    </div>
</nav>

<!-- CONTENT -->
<?php 
    
    if(isset($_GET['cnt'])):
            $content = $_GET['cnt'].".php";
            include "contents/$content";
    else:
            include "contents/home.php";
    endif; 
?>



<!-- Modal Setting-->
<div class="modal fade" id="setting" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Setting</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST">
        <?php
            $admin = $conn->query("SELECT * FROM tb_admin");
            $admin = $admin->fetch_assoc();
        ?>
        <div class="modal-body">
            <label for="" style="font-size: small;" class="bg-warning p-2 w-100">Password tidak perlu diisi jika tidak diubah</label>
            <input name="username" type="text" class="form-control mb-2" value="<?= $admin['username_admin']; ?>" placeholder="Username" required>
            <input name="password" type="text" class="form-control mb-2" placeholder="Password" required>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" name="exc_setting" class="btn btn-info">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal Konfirmasi Logout-->
<div class="modal fade" id="konfirmasi_logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Apakah kamu ingin Logout?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST">
        <div class="modal-footer">
            <input name="id_petugas" type="hidden" class="form-control mb-2">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" name="exc_logout" class="btn btn-danger">Ya, Logout</button>
        </div>
      </form>
    </div>
  </div>
</div>



<!-- FOOTER -->
<div class="border-top mt-3 py-2 pb-3 text-center w-100 bg-white" style="position: fixed; bottom: 0;">
    <small class="text-secondary">Development by <a href="#">Afen Afrianto</a></small>
</div>

<script type="text/javascript" src="../bootstrap/jquery/jquery.min.js"></script>
<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../admin/assets/js/random_numb_str.js"></script>
<script type="text/javascript" src="../admin/assets/js/ajax_form_add_siswa_kelas.js"></script>
<script type="text/javascript" src="../admin/assets/js/sorting_table.js"></script>
<script type="text/javascript" src="../admin/assets/js/ajax_pilih_mapel_add_soal.js"></script>
<script type="text/javascript" src="../admin/assets/js/random_numb_str_kodeSoal.js"></script>
<script type="text/javascript" src="../admin/assets/js/preview_img_be4_up.js"></script>
<script type="text/javascript" src="../admin/assets/js/jadwal.js"></script>
<script type="text/javascript" src="../admin/assets/js/laporan.js"></script>
</body>
</html>