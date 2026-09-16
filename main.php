<?php
    // start session
    session_start();

    //set timezone indonesia
	date_default_timezone_set("Asia/Jakarta");


    // load modules
    include "admin/modules/connect.php";
    include "admin/modules/general_func.php";
    include "admin/modules/logout.php";
    include "_modules/main.php";

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
<body class="pb-5">
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
                            $nomor_peserta = $_SESSION['siswa'];
                            $siswa_q = mysqli_query($conn, "SELECT * FROM tb_siswa JOIN tb_kelas ON tb_siswa.id_kelas = tb_kelas.id_kelas WHERE nomor_peserta = '$nomor_peserta' ");
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
<div class="container py-3">
    <!-- bio siswa -->
    <div class="d-flex flex-column align-items-center mt-2">
        <img src="admin/assets/img/icon_siswa.svg" alt="" width="70">
        <h4 class="pt-3"><?= $siswa['nama_siswa']; ?></h4>
        <span><?= $siswa['nomor_peserta']; ?> - <?= $siswa['nama_kelas']; ?></span>
    </div>
    <hr>
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="text-info py-2" style="font-weight:bold;">Daftar Ujian</h3>
    </div>

    <div class="pl-2 pt-2 pr-2 pb-0 border rounded mb-2 bg-white">
        <?php
            // cari tingkat dan jurusan dari kelas siswa
            $kls_q = mysqli_query($conn, "SELECT * FROM tb_siswa WHERE nomor_peserta = '$nomor_peserta'");
            $kls = $kls_q->fetch_assoc();
            $kls = $kls['id_kelas'];
            $tgkt_jur_q = mysqli_query($conn, "SELECT * FROM tb_kelas WHERE id_kelas = '$kls'");
            $tgkt_jur = $tgkt_jur_q->fetch_assoc();
            $tgkt = $tgkt_jur['tingkat'];
            $jur = $tgkt_jur['kode_jurusan'];
            // cari id pengampu
            $peng_q = mysqli_query($conn, "SELECT * FROM tb_guru_pengampu JOIN tb_pengampu_jur ON tb_guru_pengampu.id_pengampu = tb_pengampu_jur.id_pengampu WHERE tingkat = '$tgkt' AND kode_jurusan = '$jur'");

            if(mysqli_num_rows($peng_q) > 0):
                while($peng = $peng_q->fetch_assoc()):
                    $id_peng = $peng['id_pengampu'];
                    $ujian_q = mysqli_query($conn, "SELECT * FROM tb_stt_ujian WHERE stt_ujian = 'Ujian Berlangsung' AND id_pengampu = '$id_peng'");

                if(mysqli_num_rows($ujian_q) > 0):
                    $adaUjian = TRUE;

                    $ujian = $ujian_q->fetch_assoc();
                    $kode_soal = $ujian['kode_soal'];

                    $mp_q = mysqli_query($conn, "SELECT * FROM tb_guru_pengampu JOIN tb_mapel ON tb_guru_pengampu.id_mapel = tb_mapel.id_mapel WHERE id_pengampu = '$id_peng'");
                    $mp = $mp_q->fetch_assoc();

                    $soal_q = mysqli_query($conn, "SELECT * FROM tb_soal JOIN tb_jenis_ujian ON tb_soal.id_jenis_ujian = tb_jenis_ujian.id_jenis_ujian WHERE kode_soal = '$kode_soal'");
                    $soal = $soal_q->fetch_assoc();

        ?>
                    <!-- card mapel -->
                    <div class="rounded p-2 mb-2" style="background-color:whitesmoke;">
                        <!-- title -->
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="row align-items-center w-75  ml-1">
                                <div class="px-1 mr-2 mb-1 border rounded bg-warning">
                                <b><?= $kode_soal; ?></b>
                                </div>
                                <small><?= $soal['jenis_ujian']; ?></small>
                            </div>
                        </div>
                        
                        <!-- body -->
                        <div class="row p-2 ml-2 justify-content-between align-items-center">
                            <!-- mapel -->
                            <div class="d-flex flex-column mb-2 col-sm-5">
                                <div style="font-weight: bold; font-size: 16pt;"><?= $mp['nama_mapel']; ?></div>
                                <div>
                                    <span class="mr-2">Kelas <?= $mp['tingkat']; ?></span>
                                    <?php 
                                        $j_q = mysqli_query($conn, "SELECT * FROM tb_pengampu_jur JOIN tb_jurusan ON tb_pengampu_jur.kode_jurusan = tb_jurusan.kode_jurusan WHERE id_pengampu = '$id_peng'");
                                        while($j = $j_q->fetch_assoc()):
                                    ?>
                                        <b class="icon-circle" style="color: <?= $j['warna_jurusan']; ?>;"></b>
                                    <?php endwhile; ?>
                                </div>
                            </div>

                            <!-- Keterangan -->
                            <div class="row col-sm-5 align-items-center mb-2">
                                <div class="d-flex flex-column align-items-center w-50">
                                    <small>Status Ujian</small>
                                    <b style="font-size: large;">
                                        <?php
                                            $stt_ujian_q = mysqli_query($conn, "SELECT * FROM tb_stt_siswa_login WHERE nomor_peserta = '$nomor_peserta' AND kode_soal = '$kode_soal' ");
                                            if(mysqli_num_rows($stt_ujian_q) > 0){
                                                $stt_ujian = $stt_ujian_q->fetch_assoc();
                                                $stt_ujian = $stt_ujian['status_ujian'];
                                                if($stt_ujian == "Selesai"){
                                                    $stt = "Ujian Selesai";
                                                    echo "Ujian Selesai";
                                                }elseif($stt_ujian == "Mengerjakan"){
                                                    $stt = "Lanjut Ujian";
                                                    echo "Lanjut Ujian";
                                                }
                                            }else{
                                                $stt = "Ujian Baru";
                                                echo "Ujian Baru"; 
                                            }
                                        ?>
                                    </b>
                                </div>
                                <div class="d-flex flex-column align-items-center w-50">
                                    <small>Waktu Tersisa</small>
                                    <b style="font-size: large;">
                                        <?php
                                            $id_jadwal = $ujian['id_jadwal'];
                                            $jadwal_q = $conn->query("SELECT * FROM tb_jadwal WHERE id_jadwal = '$id_jadwal'");
                                            $jadwal = $jadwal_q->fetch_assoc();

                                            $stt_siswa_q = mysqli_query($conn, "SELECT * FROM tb_stt_siswa_login WHERE nomor_peserta = '$nomor_peserta' AND kode_soal = '$kode_soal' ");
                                            if(mysqli_num_rows($stt_siswa_q) > 0){
                                                $stt_siswa = $stt_siswa_q->fetch_assoc();
                                                echo $sisa_wk = sisaDurasi($stt_siswa['wk_terpakai'], $jadwal['durasi']); 
                                            }else{
                                                echo $sisa_wk = $jadwal['durasi'];
                                            }
                                        ?>
                                         menit</b>
                                </div>
                            </div>

                            <!-- keterangan jenis jadwal -->
                            <?php if($stt != "Ujian Selesai"): ?>
                                <?php
                                    $butir_pdf_q = mysqli_query($conn, "SELECT * FROM tb_butir_pdf WHERE kode_soal = '$kode_soal'");
                                    if(mysqli_num_rows($butir_pdf_q) > 0):
                                ?>
                                    <a href="ujian_pdf.php?kode=<?= $kode_soal; ?>&stt=<?= $stt; ?>&sisawk=<?= $sisa_wk; ?>" class="col-sm-2 text-center">
                                        <button type="button" class="btn btn-primary" style="font-size: small;">Mulai Ujian</button>
                                    </a>
                                <?php else: ?>
                                    <a href="ujian.php?kode=<?= $kode_soal; ?>&stt=<?= $stt; ?>&sisawk=<?= $sisa_wk; ?>" class="col-sm-2 text-center">
                                        <button type="button" class="btn btn-primary" style="font-size: small;">Mulai Ujian</button>
                                    </a>
                                <?php endif; ?>
                            <?php else: ?>
                                <a href="#" class="col-sm-2 text-center">
                                    <button type="button" class="btn btn-secondary" style="font-size: small; cursor:not-allowed;" disabled>Mulai Ujian</button>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endwhile; ?>
                
                <?php if(!isset($adaUjian)): ?>
                    <div class="mb-2 text-center">Tidak ada ujian yang tersedia</div>
                <?php endif; ?>
            <?php else: ?>
                    <div class="mb-2 text-center">Tidak ada ujian yang tersedia</div>
            <?php endif; ?>
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
<div class="border-top mt-3 py-2 pb-3 text-center w-100 bg-white" style="position: fixed; bottom:0;">
    <small class="text-secondary">Development by <a href="#">Afen Afrianto</a></small>
</div>

<script type="text/javascript" src="bootstrap/jquery/jquery.min.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="_assets/js/general.js"></script>
</body>
</html>