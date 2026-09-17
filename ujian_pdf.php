<?php
include "admin/modules/general_func.php";
include "admin/modules/connect.php";
include "_modules/ujian_pdf.php";
include "admin/modules/logout.php";
?>

<!-- ambil nilai pada var p pada url jika tidak ada maka nilai set 0 -->
<?php
if(isset($_GET['p'])){
    $i = $_GET['p'];
}else{
    $i = 0;
}
?>


<?php
    $sekolah_q = mysqli_query($conn, "SELECT * FROM tb_profil");
    $sekolah = $sekolah_q->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Ujian Semester - <?= $sekolah['nama_sekolah']; ?></title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="_assets/css/main.css">
    <link rel="stylesheet" href="admin/assets/css/main.css">
    <link rel="shortcut icon" href="admin/assets/img/icon.ico" type="image/x-icon"> 

    <!-- font google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@400;700&display=swap" rel="stylesheet">

    <!-- iconmoon -->
    <link rel="stylesheet" href="admin/assets/img/icomoon/style.css">
    <link rel="stylesheet" href="admin/assets/img/icomoon2/style.css">
</head>
<body style="overflow: hidden;">
<!-- navigasi header -->
<nav class="navbar navbar-expand-lg navbar-dark bg-info" style="z-index: 9998;">
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
                    <?= $nama_mapel; ?>
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

<input type="hidden" id="nomor_peserta" value="<?= $nomor_peserta; ?>">
<input type="hidden" id="kode_soal" value="<?= $kode_soal; ?>">

<!-- Modal Konfirmasi Logout-->
<div style="z-index: 9999;" class="modal fade" id="konfirmasi_logout" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

<!-- BUTIR SOAL PDF -->
<!-- DURASI -->
        <div class="position-fixed " style="z-index:999; right:20px; top:90px; ">
            <span class="countDown d-inline-block py-0 px-3 font-weight-bold text-white" style="height: 40px; line-height: 40px; font-size: 18pt;background: rgba(0, 0, 0, 0.5); text-shadow:0 0 3px rgba(0,0,0,0.3);">--:--:--</span>
            <p class="durasi" hidden><?= $jadwal['durasi']; ?></p>
            <p class="terpakai" hidden><?= $_SESSION['wk_terpakai']; ?></p>
        </div>
    
    <!-- NOMOR DAN JAWABAN --> 
        
        <div class="panelJwb bg-danger" style="z-index: 9998;">Jawaban</div>
        <div class="jwb position-fixed p-3 bg-light shadow-lg" style="right: -350px; bottom:0; top:130px; z-index:998; overflow:auto; width:350px; border:1px solid rgba(0,0,0,0.2); border-top-left-radius:5px;">
        <?php
            // ambil data butir soal pdf
            $resSoalPDF = $conn->query("SELECT * FROM tb_butir_pdf WHERE kode_soal = '$kode_soal'");
            $soalPDF = $resSoalPDF->fetch_assoc();

            // ambil kunci jawaban soal pdf
            $kunciPDF = explode(",",$soalPDF['kunci_jwb']);
        ?>
            <?php $nomor = 1; ?>
            <?php for ($i = 0; $i < count($kunciPDF); $i++){ ?>
                <?php
                    $jwbSoalPDF = $conn->query("SELECT * FROM tb_jawaban_pdf WHERE id_btr_pdf = '$i' AND nomor_peserta = '$nomor_peserta' AND kode_soal = '$kode_soal'");
                    $jwb = 0;
                    if(mysqli_num_rows($jwbSoalPDF) > 0){
                        $jwb = $jwbSoalPDF->fetch_assoc();
                        $jwb = $jwb['jawaban_pdf'];
                    }
                ?>
                <span class="noSoalPdf bg-primary text-white" style="border-top-left-radius: 5px; border-bottom-left-radius: 5px;"><?= $nomor++; ?></span>
                <input type="radio" id="opsi<?= $i; ?>1" name="opsi<?= $i; ?>" hidden><label class="opsiSoalPdf <?= cekJwbX(1,$jwb); ?>" for="opsi<?= $i; ?>1" title="<?= $i; ?>">A</label><input type="radio" id="opsi<?= $i; ?>2" name="opsi<?= $i; ?>" hidden><label class="opsiSoalPdf <?= cekJwbX(2,$jwb); ?>" for="opsi<?= $i; ?>2" title="<?= $i; ?>">B</label><input type="radio" id="opsi<?= $i; ?>3" name="opsi<?= $i; ?>" hidden><label class="opsiSoalPdf <?= cekJwbX(3,$jwb); ?>" for="opsi<?= $i; ?>3" title="<?= $i; ?>">C</label><input type="radio" id="opsi<?= $i; ?>4" name="opsi<?= $i; ?>" hidden><label class="opsiSoalPdf <?= cekJwbX(4,$jwb); ?>" for="opsi<?= $i; ?>4" title="<?= $i; ?>">D</label><input type="radio" id="opsi<?= $i; ?>5" name="opsi<?= $i; ?>" hidden><label class="opsiSoalPdf <?= cekJwbX(5,$jwb); ?>" for="opsi<?= $i; ?>5" title="<?= $i; ?>">E</label>
            <?php } ?>
            <a href="selesai.php?kode=<?= $kode_soal; ?>">
                    <button type="button" class="btn btn-danger w-100">Selesai Ujian</button>
            </a>
        </div>
      


    <!-- SOAL PDF -->
    <div id="body">
        <?php
            $q_pdf = mysqli_query($conn, "SELECT * FROM tb_butir_pdf WHERE kode_soal = '$kode_soal'");
            if(mysqli_num_rows($q_pdf) > 0):
                $filepdf = $q_pdf->fetch_assoc();
                $filepdf = $filepdf['nama_pdf'];
        ?>
                <div id="path" hidden>admin/assets/img/media/<?= $filepdf; ?></div>
                <div id="viewpdf" class="mt-2"></div>
                <script src="PDFObject/pdfobject.min.js"></script>
                <script src="jquery/jquery.min.js"></script>
                <script>
                    var body = document.querySelector('#body').style.overflow = "hidden";
                    var path = document.querySelector('#path').innerHTML;
                    var viewer = $('#viewpdf');
                    PDFObject.embed(path, viewer);
                </script>
        <?php 
            else:
                header("Location: soal404.php");
            endif;
        ?>
    </div>


<script type="text/javascript" src="bootstrap/jquery/jquery.min.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="_assets/js/general.js"></script>
<script type="text/javascript" src="_assets/js/ujian_pdf.js"></script>


</body>
</html>