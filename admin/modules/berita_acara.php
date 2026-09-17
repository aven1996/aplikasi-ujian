<?php
// update berita acara
if(isset($_POST['exc_edit_ba'])){
    $kode_soal = $_POST['kode_soal'];
    $tanggal = $_POST['tanggal'];
    $wk_mulai = $_POST['wk_mulai'];
    $wk_selesai = $_POST['wk_selesai'];
    $catatan = htmlspecialchars($_POST['catatan']);
    mysqli_query($conn, "UPDATE tb_berita_acara SET tanggal = '$tanggal', wk_mulai = '$wk_mulai', wk_selesai = '$wk_selesai', catatan = '$catatan' WHERE kode_soal = '$kode_soal'");
    if(mysqli_affected_rows($conn) > 0){
        echo "<script> alert('Perubahan berhasil disimpan!'); </script>";
    }
}

// hapus berita acara
if(isset($_POST['exc_del_ba'])){
    $kode_soal = $_POST['kode_soal'];
    $conn->query("DELETE FROM tb_berita_acara WHERE kode_soal = '$kode_soal'");
    if(mysqli_affected_rows($conn) > 0){
        echo "<script> alert('Data berhasil dihapus!'); </script>";
    }
}
?>