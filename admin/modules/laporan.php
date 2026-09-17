<?php
// hapus laporan
if(isset($_POST['exc_del_ba'])){
    $kode_soal = $_POST['kode_soal'];
    $conn->query("DELETE FROM tb_laporan WHERE kode_soal = '$kode_soal'");
    if(mysqli_affected_rows($conn) > 0){
        echo "<script> alert('Laporan berhasil dihapus!'); </script>";
    }
}

// cari laporan
$cari = "";
if(isset($_POST['exc_cari_ba'])){
    $mapel = htmlspecialchars($_POST['mapel']);
    $cari = "WHERE nama_mapel LIKE '%$mapel%'";
}

?>