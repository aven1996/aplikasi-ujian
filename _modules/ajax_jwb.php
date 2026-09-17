<?php
include "connect.php";

$nomor_peserta = $_GET['nopes'];
$kode_soal = $_GET['kode'];
$idQ = $_GET['idQ'];
$idO = $_GET['idO'];

// jika data terkait belum ada
$jwb_sw = mysqli_query($conn, "SELECT * FROM tb_jawaban WHERE nomor_peserta = '$nomor_peserta' AND id_pertanyaan = '$idQ'");
if(mysqli_num_rows($jwb_sw) == 0){
    mysqli_query($conn, "INSERT INTO tb_jawaban VALUES ('','$nomor_peserta','$kode_soal','$idQ','$idO')");
    // update waktu yang telah terpakai 
    $terpakai = $_COOKIE['durasi_terpakai'];
    $terpakai = round($terpakai / 60);
    $conn->query("UPDATE tb_stt_siswa_login SET wk_terpakai = '$terpakai' WHERE nomor_peserta = '$nomor_peserta' AND kode_soal = '$kode_soal' ");
}else{
    mysqli_query($conn, "UPDATE tb_jawaban SET jawaban = '$idO' WHERE nomor_peserta = '$nomor_peserta' AND id_pertanyaan = '$idQ'");
    // update waktu yang telah terpakai 
    $terpakai = $_COOKIE['durasi_terpakai'];
    $terpakai = round($terpakai / 60);
    $conn->query("UPDATE tb_stt_siswa_login SET wk_terpakai = '$terpakai' WHERE nomor_peserta = '$nomor_peserta' AND kode_soal = '$kode_soal' ");
}



?>