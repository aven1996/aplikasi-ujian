<?php
// tambah jenis ujian
if(isset($_POST['exc_add_jenis_uj'])){
    $jenis_ujian = htmlspecialchars($_POST['jenis_ujian']);
    $tahun_ajaran = htmlspecialchars($_POST['tahun_ajaran']);
    $q_jenis_ujian = mysqli_query($conn, "INSERT INTO tb_jenis_ujian VALUES ('','$jenis_ujian','$tahun_ajaran')");
    if(mysqli_affected_rows($conn) > 0){
        echo "<script> alert('Data jenis ujian berhasil ditambahkan!'); </script>";
    }
}



// edit jenis ujian
if(isset($_POST['exc_edit_jenis_uj'])){
    $id = $_POST['id_jenis_ujian'];
    $jenis_ujian = htmlspecialchars($_POST['jenis_ujian']);
    $tahun_ajaran = htmlspecialchars($_POST['tahun_ajaran']);
    $q_jenis_ujian = mysqli_query($conn, "UPDATE tb_jenis_ujian SET jenis_ujian = '$jenis_ujian', tahun_ajaran = '$tahun_ajaran' WHERE id_jenis_ujian = '$id' ");
    if(mysqli_affected_rows($conn) > 0){
        echo "<script> alert('Data berhasil ditubah!'); </script>";
    }
}

// hapus jenis ujian
if(isset($_POST['exc_del_jenis_uj'])){
    $id = $_POST['id_jenis_ujian'];
    mysqli_query($conn, "DELETE FROM tb_jenis_ujian WHERE id_jenis_ujian = '$id'");
    if(mysqli_affected_rows($conn) > 0){
        echo "<script> alert('Data berhasil dihapus!'); </script>";
    }
}

?>