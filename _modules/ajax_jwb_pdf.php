<?php
include "connect.php";


function cekJwbX($opsi, $jwb){
    if($jwb == $opsi){
        return "checked";
    }else{
        return "";
    }
}



$nomor_peserta = $_GET['nopes'];
$kode_soal = $_GET['kode'];
$btr_pdf = $_GET['btr_pdf'];
$jwb = $_GET['jwb'];

// jika data terkait belum ada
$jwb_sw = mysqli_query($conn, "SELECT * FROM tb_jawaban_pdf WHERE nomor_peserta = '$nomor_peserta' AND id_btr_pdf = '$btr_pdf' AND kode_soal = '$kode_soal'");
if(mysqli_num_rows($jwb_sw) == 0){
    mysqli_query($conn, "INSERT INTO tb_jawaban_pdf VALUES ('','$nomor_peserta','$kode_soal','$btr_pdf','$jwb')");
    // update waktu yang telah terpakai 
    $terpakai = $_COOKIE['durasi_terpakai'];
    $terpakai = round($terpakai / 60);
    $conn->query("UPDATE tb_stt_siswa_login SET wk_terpakai = '$terpakai' WHERE nomor_peserta = '$nomor_peserta' AND kode_soal = '$kode_soal' ");
}else{
    mysqli_query($conn, "UPDATE tb_jawaban_pdf SET jawaban_pdf = '$jwb' WHERE nomor_peserta = '$nomor_peserta' AND id_btr_pdf = '$btr_pdf' AND kode_soal = '$kode_soal'");
    // update waktu yang telah terpakai 
    $terpakai = $_COOKIE['durasi_terpakai'];
    $terpakai = round($terpakai / 60);
    $conn->query("UPDATE tb_stt_siswa_login SET wk_terpakai = '$terpakai' WHERE nomor_peserta = '$nomor_peserta' AND kode_soal = '$kode_soal' ");
}



?>


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