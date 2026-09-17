<?php
// tambah jurusan
    if(isset($_POST['exc_add_jur'])){
        // cek ada kesamaan kode jurusan atau tidak
        $kode_jur = htmlspecialchars($_POST['kode_jur']);
        $query_kode_jur = mysqli_query($conn, "SELECT kode_jurusan FROM tb_jurusan WHERE kode_jurusan = '$kode_jur' ");
        if(mysqli_num_rows($query_kode_jur) > 0){
            echo "<script> alert('Ada kesamaan kode jurusan!'); </script>";
        }else{
            $kode_jur = htmlspecialchars($_POST['kode_jur']);
            $nama_jur = htmlspecialchars($_POST['nama_jur']);
            $warna_jur = $_POST['warna_jur'];
            mysqli_query($conn, "INSERT INTO tb_jurusan VALUES ('$kode_jur','$nama_jur','$warna_jur')");
            if(mysqli_affected_rows($conn) > 0){
                echo "<script> alert('Data Jurusan Berhasil Ditambahkan!'); </script>";
            }
        }
        
    }


// edit jurusan
if(isset($_POST['exc_edit_jur'])){
        $kode_jur = htmlspecialchars($_POST['kode_jur']);
        $nama_jur = htmlspecialchars($_POST['nama_jur']);
        $warna_jur = $_POST['warna_jur'];
        mysqli_query($conn, "UPDATE tb_jurusan SET nama_jurusan = '$nama_jur', warna_jurusan = '$warna_jur' WHERE kode_jurusan = '$kode_jur'");
        echo "<script> alert('Data Jurusan Berhasil Diubah!'); </script>";
}

// hapus jurusan
if(isset($_POST['exc_del_jur'])){   
    $kode_jur = htmlspecialchars($_POST['kode_jur']);
    mysqli_query($conn, "DELETE FROM tb_jurusan WHERE kode_jurusan = '$kode_jur'");
    if(mysqli_affected_rows($conn) > 0){
        echo "<script> alert('Data Jurusan Berhasil Dihapus!'); </script>";
    }
}

    



?>