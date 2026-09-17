<?php
include "connect.php";

$nomor_peserta = $_GET['nopes'];
$kode_soal = $_GET['kode'];
$id_q = $_GET['idQ'];

$cek_ragu = mysqli_query($conn, "SELECT * FROM tb_siswa_ragu WHERE nomor_peserta = '$nomor_peserta' AND id_pertanyaan = '$id_q'");
if(mysqli_num_rows($cek_ragu) == 0 ){
    mysqli_query($conn, "INSERT INTO tb_siswa_ragu VALUES ('','$nomor_peserta','$kode_soal','$id_q')");
}else{
    mysqli_query($conn, "DELETE FROM tb_siswa_ragu WHERE nomor_peserta = '$nomor_peserta' AND id_pertanyaan = '$id_q'");
}

?>

<script>window.location.reload();</script>