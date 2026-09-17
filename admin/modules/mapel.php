<?php
// tambah mapel
if(isset($_POST['exc_add_mapel'])){
    $mapel = htmlspecialchars($_POST['mapel']);
    mysqli_query($conn, "INSERT INTO tb_mapel VALUES('','$mapel')");
    if(mysqli_affected_rows($conn) > 0){
        echo "<script> alert('Data mata pelajaran berhasil ditambahkan!'); </script>";
    }
}

// edit mapel
if(isset($_POST['exc_edit_mapel'])){
    $id = $_POST['id_mapel'];
    $mapel = htmlspecialchars($_POST['mapel']);
    mysqli_query($conn, "UPDATE tb_mapel SET nama_mapel = '$mapel' WHERE id_mapel = '$id' ");
    echo "<script> alert('Data mata pelajaran berhasil diubah!'); </script>";
}

//hapus mapel
if(isset($_POST['exc_del_mapel'])){
    $id = $_POST['id_mapel'];
    mysqli_query($conn, "DELETE FROM tb_mapel WHERE id_mapel = '$id' ");
    if(mysqli_affected_rows($conn) > 0){
        echo "<script> alert('Data berhasil dihapus!'); </script>";
    }
}

// cari mapel
$search = "";
if(isset($_POST['cari_mapel'])){
    $cari = $_POST['c_mapel'];
    $search = " WHERE nama_mapel LIKE '%$cari%' ";
}
?>