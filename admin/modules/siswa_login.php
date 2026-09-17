<?php
if(isset($_GET['logout'])){
    $id = $_GET['logout'];
    mysqli_query($conn, "UPDATE tb_stt_siswa_login SET status_login = 'offline' WHERE id_siswa_login = '$id'");
}

if(isset($_GET['done'])){
    $id = $_GET['done'];
    mysqli_query($conn, "UPDATE tb_stt_siswa_login SET status_ujian = 'Selesai' WHERE id_siswa_login = '$id'");
}
?>