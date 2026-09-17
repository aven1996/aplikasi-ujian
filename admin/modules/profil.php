<?php
    // eksekusi proses edit profil
    if(isset($_POST['exc_edit_sekolah'])){
        $id = $_POST['id_profil'];
        $respon = htmlspecialchars($_POST['nama_sekolah']);
        mysqli_query($conn, "UPDATE tb_profil SET nama_sekolah = '$respon' WHERE id_profil = '$id' ");
        header("Location: ?cnt=profil");
    }

    if(isset($_POST['exc_edit_kepsek'])){
        $id = $_POST['id_profil'];
        $respon = htmlspecialchars($_POST['nama_kepsek']);
        mysqli_query($conn, "UPDATE tb_profil SET nama_kepsek = '$respon' WHERE id_profil = '$id'");
        header("Location: ?cnt=profil");
    }

    if(isset($_POST['exc_edit_logo'])){
        $id = $_POST['id_profil'];
        $respon = upload_file("image","tb_profil","logo_sekolah")[0];
        mysqli_query($conn, "UPDATE tb_profil SET logo_sekolah = '$respon' WHERE id_profil = '$id'");
        header("Location: ?cnt=profil");
    }

    if(isset($_POST['exc_edit_kop'])){
        $id = $_POST['id_profil'];
        $respon = upload_file("image","tb_profil","kop_sekolah")[0];
        mysqli_query($conn, "UPDATE tb_profil SET kop_sekolah = '$respon' WHERE id_profil = '$id'");
        header("Location: ?cnt=profil");
    }

    if(isset($_POST['exc_edit_bg'])){
        $id = $_POST['id_profil'];
        $respon = upload_file("image","tb_profil","bg_sekolah")[0];
        mysqli_query($conn, "UPDATE tb_profil SET bg_sekolah = '$respon' WHERE id_profil = '$id'");
        header("Location: ?cnt=profil");
    }



    // ambil data profil
    $query_sekolah = mysqli_query($conn, "SELECT * FROM tb_profil");
    if(mysqli_num_rows($query_sekolah) > 0){
        $sekolah = $query_sekolah->fetch_assoc();
    }
    

?>