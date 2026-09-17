<?php
// tambah guru
    if(isset($_POST['exc_add_guru'])){
        $nama = htmlspecialchars($_POST['nama']);
        $user = htmlspecialchars($_POST['username']);
        $pass = htmlspecialchars($_POST['password']);
        // validasi apakah ada kesamaan username
        $query_guru = mysqli_query($conn, "SELECT username_guru FROM tb_guru WHERE id_guru = '$user' ");
        if(mysqli_num_rows($query_guru) > 0){
            // jika sudah ada username
            echo "<script> alert('Username sudah digunakan'); </script>";
        }else{
            $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
            mysqli_query($conn, "INSERT INTO tb_guru VALUES ('','$nama','$user','$pass_hash','$pass')");
            if(mysqli_affected_rows($conn) > 0){
                echo "<script> alert('Data guru berhasil ditambahkan!'); </script>";
            }
        }
    }

// edit guru
if(isset($_POST['exc_edit_guru'])){
    $id = $_POST['id'];
    $nama = htmlspecialchars($_POST['nama']);
    $user = htmlspecialchars($_POST['username']);
    $pass = htmlspecialchars($_POST['password']);
    // validasi apakah ada kesamaan username
    $query_guru = mysqli_query($conn, "SELECT username_guru FROM tb_guru WHERE id_guru = '$user' ");
    if(mysqli_num_rows($query_guru) > 0){
        // jika sudah ada username
        echo "<script> alert('Username sudah digunakan'); </script>";
    }else{
        $pass_hash = password_hash($pass, PASSWORD_DEFAULT);
        mysqli_query($conn, "UPDATE tb_guru SET nama_guru = '$nama', username_guru = '$user', password_guru = '$pass_hash', pass_show_guru = '$pass'");
        echo "<script> alert('Data guru berhasil diubah!'); </script>";
        
    }
}

// hapus guru
if(isset($_POST['exc_del_guru'])){
    $id = $_POST['id'];
    mysqli_query($conn, "DELETE FROM tb_guru WHERE id_guru = '$id'");
    if(mysqli_affected_rows($conn) > 0){
        echo "<script> alert('Data berhasil dihapus!'); </script>";
    }
}



// cari guru
$search = "";
if(isset($_POST['cari'])){
    $cari = $_POST['c_guru'];
    $search = " WHERE nama_guru LIKE '%$cari%' OR username_guru LIKE '%$cari%' ";
}














?>