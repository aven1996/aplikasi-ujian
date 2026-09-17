<?php
$nomor_peserta = $_SESSION['siswa'];
$kode_soal = $_GET['kode'];
mysqli_query($conn, "UPDATE tb_stt_siswa_login SET status_ujian = 'Selesai' WHERE nomor_peserta = '$nomor_peserta' AND kode_soal = '$kode_soal' ");

?>