<?php
    // start session
    session_start();

    //set timezone indonesia
	date_default_timezone_set("Asia/Jakarta");


    // load modules
    include "admin/modules/connect.php";
    include "admin/modules/general_func.php";
    include "admin/modules/logout.php";
    include "_modules/selesai.php";

    // jika belum login
    if(!isset($_SESSION['siswa'])){
        header("Location: index.php");
    }

    $sekolah_q = mysqli_query($conn, "SELECT * FROM tb_profil");
    $sekolah = $sekolah_q->fetch_assoc();

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Ujian Semester <?= $sekolah['nama_sekolah']; ?></title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="shortcut icon" href="admin/assets/img/icon.ico" type="image/x-icon">

    <!-- font google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@400;700&display=swap" rel="stylesheet">

    <!-- iconmoon -->
    <link rel="stylesheet" href="admin/assets/img/icomoon/style.css">
    <link rel="stylesheet" href="admin/assets/img/icomoon2/style.css">

    <!-- css cdn datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    
    <!-- myCSS -->
    <link rel="stylesheet" href="admin/assets/css/main.css">
</head>
<body>
<!-- NAV HAEDER -->
<nav class="navbar navbar-expand-lg navbar-dark bg-info">
<div class="container">
    <a class="navbar-brand" href="#">
    <?php 
        if(!empty($sekolah['logo_sekolah'])):
    ?>
        <img src="admin/assets/img/profil_smk/<?= $sekolah['logo_sekolah']; ?>" width="40"  alt="">
    <?php else: ?>
        <img src="admin/assets/img/logo_putih.svg" width="150" height="30" alt="">
    <?php endif; ?>
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item dropdown text-white text-center" style="font-weight: bold; font-size: large;">
                Ujian Semester
            </li>
        </ul>


        <div class="my-2 my-lg-0">
            <ul class="navbar-nav mr-auto w-auto">
                <div class="navbar-brand text-center">
                    <img src="admin/assets/img/icon_siswa.svg" width="30" height="30" alt="" title="Kamu seorang guru">
                </div>
                <li class="nav-item dropdown active w-auto text-center" style="min-width: 150px;">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php
                            $kode_soal = $_SESSION['kode_soal'];
                            $nomor_peserta = $_SESSION['siswa'];
                            $siswa_q = mysqli_query($conn, "SELECT * FROM tb_siswa WHERE nomor_peserta = '$nomor_peserta' ");
                            $siswa = $siswa_q->fetch_assoc();
                            echo $siswa['nama_siswa'];
                        ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        
                        <a class="dropdown-item text-secondary" href="#" data-toggle="modal" data-target="#konfirmasi_logout"><b class="icon-sign-out"></b> Log Out</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
</nav>
 


<!-- CONTENT -->
<div class="container p-5 text-center mt-3">
    <img src="admin/assets/img/svg/007-book.svg" alt="" width="200">
    <h4>Selamat, Ujian telah selesai!</h4>
    <small>Jumlah nilai yang kamu peroleh</small>
    <h1 style="font-size: 72pt;"><?= number_format(cekNilai($kode_soal,$nomor_peserta),1,",",""); ?></h1>
    <form action="" method="POST">
        <button class="btn btn-success" name="exc_logout" style="width: 200px;">Selesai</button>
    </form>
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
<div class="border-top mt-3 py-2 pb-3 text-center w-100 bg-white" style="position: absolute; bottom:0;">
    <small class="text-secondary">Development by <a href="#">Afen Afrianto</a></small>
</div>

<script type="text/javascript" src="bootstrap/jquery/jquery.min.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="_assets/js/general.js"></script>
</body>
</html>