<?php
// tambah kelas
if(isset($_POST['exc_add_kelas'])){
    $jur = $_POST['jurusan'];
    $tingkat = $_POST['tingkat'];
    $kelas = htmlspecialchars($_POST['kelas']);

    mysqli_query($conn, "INSERT INTO tb_kelas VALUES ('','$tingkat','$jur','$kelas')");
    if(mysqli_affected_rows($conn) > 0){
        echo "<script> alert('Data Kelas Berhasil Ditambahkan!'); </script>";
    }
}

// edit kelas
if(isset($_POST['exc_edit_kls'])){
    $id = $_POST['id_kls'];
    $jur = $_POST['jurusan'];
    $tingkat = $_POST['tingkat'];
    $kelas = htmlspecialchars($_POST['kelas']);

    mysqli_query($conn, "UPDATE tb_kelas SET tingkat = '$tingkat', kode_jurusan = '$jur', nama_kelas = '$kelas' WHERE id_kelas = '$id' ");
    echo "<script> alert('Data Kelas Berhasil Diubah!'); </script>";
}


// hapus kelas
if(isset($_POST['exc_del_kls'])){
    $id = $_POST['id_kelas'];

    mysqli_query($conn, "DELETE FROM tb_kelas WHERE id_kelas = '$id'");
    echo "<script> alert('Data Kelas Berhasil Dihapus!'); </script>";
}
?>