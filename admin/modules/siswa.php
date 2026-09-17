<?php
    // tambah siswa
    if(isset($_POST['exc_add_siswa'])){
        $nama = htmlspecialchars($_POST['nama']);
        $nomor = htmlspecialchars($_POST['nomor']);
        $kelas = $_POST['kelas'];
        $password = htmlspecialchars($_POST['password']);

        // validasi ada kesamaan nomor atau enggak
        $nomor_db = mysqli_query($conn, "SELECT * FROM tb_siswa WHERE nomor_peserta = '$nomor'");
        if(mysqli_num_rows($nomor_db) > 0){
            echo "<script> alert('Nomor peserta sudah digunakan!'); </script>";
        }else{
            $pass_hash = password_hash($password, PASSWORD_DEFAULT);
            mysqli_query($conn, "INSERT INTO tb_siswa VALUES('$nomor','$nama','$kelas','$pass_hash','$password')");
            if(mysqli_affected_rows($conn) > 0){
                echo "<script> alert('Data siswa berhasil ditambahkan!'); </script>";
            }
        }
    }

    // EDIT siswa
    if(isset($_POST['exc_edit_siswa'])){
        $nama = htmlspecialchars($_POST['nama']);
        $nomor = htmlspecialchars($_POST['nomor_lama']);
        $nomor_baru = htmlspecialchars($_POST['nomor_baru']);
        $kelas = $_POST['kelas'];
        $password = htmlspecialchars($_POST['password']);

        // validasi ada kesamaan nomor atau enggak
        $nomor_db = mysqli_query($conn, "SELECT * FROM tb_siswa WHERE nomor_peserta = '$nomor_baru' AND nomor_peserta != '$nomor'");
        if(mysqli_num_rows($nomor_db) > 0){
            echo "<script> alert('Nomor peserta sudah digunakan siswa lain!'); </script>";
        }else{
            $pass_hash = password_hash($password, PASSWORD_DEFAULT);
            mysqli_query($conn, "UPDATE tb_siswa SET nomor_peserta = '$nomor_baru', nama_siswa = '$nama', id_kelas = '$kelas', password_siswa = '$pass_hash', pass_show_siswa = '$password' WHERE nomor_peserta = '$nomor'");
            if(mysqli_affected_rows($conn) > 0){
                echo "<script> alert('Data siswa berhasil diubah!'); </script>";
            }
        }
    }

    // hapus siswa
    if(isset($_POST['exc_del_siswa'])){
        $nomor = $_POST['nomor_siswa'];
        mysqli_query($conn, "DELETE FROM tb_siswa WHERE nomor_peserta = '$nomor'");
        if(mysqli_affected_rows($conn) > 0){
            echo "<script> alert('Data berhasil dihapus!'); </script>";
        }
    }

?>