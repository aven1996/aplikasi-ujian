<?php
include "admin/modules/general_func.php";
include "admin/modules/connect.php";
include "_modules/ujian.php";
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
<body>
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
    
    <div class="d-flex align-items-stretch position-absolute" style="bottom: 0; top:0; right:0; left:0">
        <div class="container bg-white pb-3 shadow-lg" style="padding-top: 70px;">
            <!-- header soal -->
            <div class="position-relative">
                <h4 class="d-inline-block mt-1"><b class="px-3 py-1 bg-primary rounded text-white" style="font-size: xx-large;"><?= $i + 1; ?></b></h4>

                <span class="countDown d-inline-block px-3 border position-absolute font-weight-bold bg-light" style="height: 40px; line-height: 40px; right:0; font-size: 18pt;">--:--:--</span>
                <p class="durasi" hidden><?= $jadwal['durasi']; ?></p>
                <p class="terpakai" hidden><?= $_SESSION['wk_terpakai']; ?></p>
            </div>

            <hr>
            <!-- isi soal -->
            <div class="overflow-auto soalX" style="height: 70%;">

                <?php
                    $jml_quest_q = mysqli_query($conn, "SELECT * FROM tb_pertanyaan WHERE kode_soal = '$kode_soal'");
                    if(isset($nosoal)){
                        $quest_q = mysqli_query($conn, "SELECT * FROM tb_pertanyaan WHERE id_pertanyaan = '$nosoal[$i]'");
                    }else{
                        $quest_q = mysqli_query($conn, "SELECT * FROM tb_pertanyaan WHERE kode_soal = '$kode_soal' LIMIT $i,1");
                    }
                    while($quest = $quest_q->fetch_assoc()):
                        $id_quest = $quest['id_pertanyaan'];
                        // mengambil data jawaban siswa
                        $jwb_siswa_q = $conn->query("SELECT * FROM tb_jawaban WHERE nomor_peserta = '$nomor_peserta' AND id_pertanyaan = '$id_quest'");
                        if (mysqli_num_rows($jwb_siswa_q) > 0) {
                            $jwb_siswa = $jwb_siswa_q->fetch_assoc();
                            $jwb_siswa = $jwb_siswa['jawaban'];
                        }
                ?>
                        <!-- pertanyaan -->
                        <p>
                            <!-- tampil file media jika ada -->
                            <?php
                                if(!empty($quest['media_pendukung'])):
                                    if(cekFile($quest['media_pendukung']) == "image"):
                                ?>
                                    <img class="d-block mb-2" src="admin/assets/img/media/<?= $quest['media_pendukung']; ?>" alt="<?= $quest['media_pendukung']; ?>" style="max-height: 300px;" title="<?= $quest['media_pendukung']; ?>">
                                <?php
                                    elseif(cekFile($quest['media_pendukung']) == "audio"):
                                ?>
                                    <audio class="d-block mb-2" src="admin/assets/img/media/<?= $quest['media_pendukung']; ?>" controls></audio>
                                <?php 
                                    endif;
                                endif;
                            ?>
                            <!-- isi soal -->
                            <?= $quest['pertanyaan']; ?>
                        </p>

                        <!-- value hidden -->
                        <input type="hidden" id="nopes" value="<?= $nomor_peserta; ?>">
                        <input type="hidden" id="kode" value="<?= $kode_soal; ?>">
                        <input type="hidden" id="idQ" value="<?= $id_quest; ?>">

                        <?php
                            // update waktu yang telah terpakai 
                            if(isset($_COOKIE['durasi_terpakai'])):
                                $terpakai = $_COOKIE['durasi_terpakai'];
                                $terpakai = round($terpakai / 60);
                                $conn->query("UPDATE tb_stt_siswa_login SET wk_terpakai = '$terpakai' WHERE nomor_peserta = '$nomor_peserta' AND kode_soal = '$kode_soal' ");
                            endif;
                        ?>

                        <!-- OPSI JAWABAN -->
                        <div id="opsi-jwb" class="d-flex flex-column py-2">
                            <?php
                                // cek acak opsi atau tidak dari tb soal
                                $soalQ = mysqli_query($conn, "SELECT * FROM tb_soal WHERE kode_soal = '$kode_soal'");
                                $acak_opsi = $soalQ->fetch_assoc();
                                $acak_opsi = $acak_opsi['acak_opsi'];

                                $i_abc = 0;
                                $abc = ["A","B","C","D","E"];
                                if($acak_opsi == "Tidak"){
                                    $opsi_q = mysqli_query($conn, "SELECT * FROM tb_opsi_jwb WHERE id_pertanyaan = '$id_quest'");
                                }else{
                                    $opsi_q = mysqli_query($conn, "SELECT * FROM tb_opsi_jwb WHERE id_pertanyaan = '$id_quest' ORDER BY rand()");
                                }
                                
                                $x = 1;
                                while($opsi = $opsi_q->fetch_assoc()):
                            ?>
                                <input type="radio" id="opsi<?= $x; ?>" name="opsi" class="opsi-x" value="<?= $opsi['id_opsi']; ?>" hidden 
                                    <?php
                                        if(isset($jwb_siswa)){
                                            if ($opsi['id_opsi'] == $jwb_siswa) {
                                                echo "checked";
                                            }
                                        }
                                    ?>
                                >
                            <div class="d-flex align-items-center ophov mb-2" onclick="ajax_jwb(<?= $opsi['id_opsi']; ?>);">
                                <div>
                                    <label for="opsi<?= $x; ?>" class="opsi opsiX<?= $x; ?> m-0 rounded" style="width: 45px;">
                                        <?= $abc[$i_abc]; $i_abc++; ?>
                                    </label>
                                </div>

                                <label for="opsi<?= $x; ?>" class="pl-3">
                                    <!-- media pendukung opsi jwb -->
                                    <?php
                                        if(!empty($opsi['media_pendukung'])):
                                            if(cekFile($opsi['media_pendukung']) == "image"):
                                        ?>
                                            <img class="d-block mb-2" src="admin/assets/img/media/<?= $opsi['media_pendukung']; ?>" alt="<?= $opsi['media_pendukung']; ?>" style="max-height: 200px;" title="<?= $opsi['media_pendukung']; ?>">
                                        <?php
                                            elseif(cekFile($opsi['media_pendukung']) == "audio"):
                                        ?>
                                            <audio class="d-block mb-2" src="admin/assets/img/media/<?= $opsi['media_pendukung']; ?>" controls></audio>
                                        <?php 
                                            endif;
                                        endif;
                                    ?>
                                    <!-- isi opsi jwb -->
                                    <?= $opsi['opsi_jwb']; ?>
                                </label>
                            </div>
                            
                        <?php
                            $x++;
                            endwhile;
                        ?>
                        </div>
                <?php
                    endwhile;
                ?>
            </div>



            <!-- navigasi soal -->
            <div class="d-flex justify-content-between p-3">
                <?php 
                    if(!isset($_GET['p']) OR $_GET['p'] == 0){
                ?>
                    <button type="button" class="btn btn-secondary py-2 disabled">Sebelum</button>
                <?php
                    }else{
                ?>
                    <a href="?kode=<?= $kode_soal; ?>&p=<?= $i - 1; ?>"><button type="button" class="btn btn-primary py-2">Sebelum</button></a>
                <?php
                    }
                ?>
                <div class="form-group form-check bg-warning px-3 py-2 m-0 rounded" >
                    <input type="checkbox" id="exampleCheck1"
                        <?php
                            $ragu_q = $conn->query("SELECT * FROM tb_siswa_ragu WHERE nomor_peserta = '$nomor_peserta' AND id_pertanyaan = '$id_quest' ");
                            if (mysqli_num_rows($ragu_q) > 0) {
                                echo "checked";
                            }
                        ?>
                    >
                    <label class="form-check-label" for="exampleCheck1" onclick="add_ragu();">Ragu-ragu</label>
                </div>
                <?php
                    $lastSoal = $i + 1;
                    if ($lastSoal == mysqli_num_rows($jml_quest_q)) {
                ?>
                    <a href="selesai.php?kode=<?= $kode_soal; ?>"><button type="button" class="btn btn-success py-2">Selesai</button></a>
                <?php
                    }else{
                ?>
                    <a href="?kode=<?= $kode_soal; ?>&p=<?= $i+1; ?>"><button type="button" class="btn btn-primary py-2">Berikut</button></a>
                <?php
                    }
                ?>
            </div>

            
            <!-- list soal -->
            <input type="checkbox" id="cekBtnList" hidden>
            <div class="listSoal shadow-lg m-auto position-fixed" >
            <!-- tombol -->
                <label for="cekBtnList" class="btn btn-danger text-white p-2 m-0" style="width: 450px; border-bottom-left-radius:0; border-bottom-right-radius:0;">
                    <b class="icon-list-numbered mr-3"></b>DAFTAR SOAL
                </label>

            <!-- list -->
                <div class="cov_list bg-light text-dark p-2 font-weight-bold overflow-auto" style="width: 450px; height:500px;">
                
                <?php
                // jika acak soal maka akan tercipta variabel nosoal 
                if(isset($nosoal)):

                    for ($i = 0; $i < count($nosoal); $i++) :
                       // jika ragu
                       $id_pert = $nosoal[$i];
                       $ragu_query = $conn->query("SELECT * FROM tb_siswa_ragu WHERE id_pertanyaan = '$id_pert' AND nomor_peserta = '$nomor_peserta'");
                       // jika sudah dijawab
                       $terjawab = $conn->query("SELECT * FROM tb_jawaban WHERE id_pertanyaan = '$id_pert' AND nomor_peserta = '$nomor_peserta' ");
                       if(mysqli_num_rows($ragu_query) > 0):
                ?>
                           <a href="?kode=<?= $kode_soal; ?>&p=<?= $i; ?>" style="color:black; text-decoration:none;">
                               <span class="position-relative d-inline-block m-1 bg-warning border text-center rounded" style="box-sizing:border-box; height:70px; width: 70px; line-height: 70px; font-size: 14pt;"><?= $i + 1; ?>
                               </span>
                           </a>
                       <?php elseif(mysqli_num_rows($terjawab) > 0): ?>
                           <a href="?kode=<?= $kode_soal; ?>&p=<?= $i; ?>" style="color:white; text-decoration:none;">
                               <span class="position-relative d-inline-block m-1 bg-primary border text-center rounded" style="box-sizing:border-box; height:70px; width: 70px; line-height: 70px; font-size: 14pt;"><?= $i + 1; ?>
                               </span>
                           </a>

                       <?php else: ?>
                           <a href="?kode=<?= $kode_soal; ?>&p=<?= $i; ?>" style="color:black; text-decoration:none;">
                               <span class="position-relative d-inline-block m-1 bg-white border text-center rounded" style="box-sizing:border-box; height:70px; width: 70px; line-height: 70px; font-size: 14pt;"><?= $i + 1; ?>
                               </span>
                           </a>

                       <?php endif; ?>
                    <?php endfor; ?>
                <?php else: 
                    $question_query = $conn->query("SELECT * FROM tb_pertanyaan WHERE kode_soal = '$kode_soal'");
                    if(mysqli_num_rows($question_query) > 0):
                        $i = 0;
                        while($pert = $question_query->fetch_assoc()):
                            // jika ragu
                            $id_pert = $pert['id_pertanyaan'];
                            $ragu_query = $conn->query("SELECT * FROM tb_siswa_ragu WHERE id_pertanyaan = '$id_pert' AND nomor_peserta = '$nomor_peserta'");
                            // jika sudah dijawab
                            $terjawab = $conn->query("SELECT * FROM tb_jawaban WHERE id_pertanyaan = '$id_pert' AND nomor_peserta = '$nomor_peserta' ");
                            if(mysqli_num_rows($ragu_query) > 0):
                ?>
                                <a href="?kode=<?= $kode_soal; ?>&p=<?= $i; ?>" style="color:black; text-decoration:none;">
                                    <span class="position-relative d-inline-block m-1 bg-warning border text-center rounded" style="box-sizing:border-box; height:70px; width: 70px; line-height: 70px; font-size: 14pt;"><?= $i + 1; ?>
                                    </span>
                                </a>
                            <?php elseif(mysqli_num_rows($terjawab) > 0): ?>
                                <a href="?kode=<?= $kode_soal; ?>&p=<?= $i; ?>" style="color:white; text-decoration:none;">
                                    <span class="position-relative d-inline-block m-1 bg-primary border text-center rounded" style="box-sizing:border-box; height:70px; width: 70px; line-height: 70px; font-size: 14pt;"><?= $i + 1; ?>
                                    </span>
                                </a>

                            <?php else: ?>
                                <a href="?kode=<?= $kode_soal; ?>&p=<?= $i; ?>" style="color:black; text-decoration:none;">
                                    <span class="position-relative d-inline-block m-1 bg-white border text-center rounded" style="box-sizing:border-box; height:70px; width: 70px; line-height: 70px; font-size: 14pt;"><?= $i + 1; ?>
                                    </span>
                                </a>

                            <?php endif; ?>
                        <?php $i++; endwhile; ?>
                    <?php endif; ?>
                <?php endif; ?>
                </div>
            </div>

            
        </div>

    </div>


<script type="text/javascript" src="bootstrap/jquery/jquery.min.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="_assets/js/general.js"></script>
<script type="text/javascript" src="_assets/js/ujian.js"></script>


</body>
</html>