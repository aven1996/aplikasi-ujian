<?php
// tambah soal
if(isset($_POST['exc_add_soal'])){
    $id_pengampu = $_POST['id_pengampu'];
    $jenis_ujian = $_POST['jenis_ujian'];
    $kode_soal = $_POST['kode_soal'];
    $acak_q = $_POST['acak_pertanyaan'];
    $acak_o = $_POST['acak_opsi'];

    // validasi kesamaan kode soal
    $q_soal = mysqli_query($conn, "SELECT * FROM tb_soal WHERE kode_soal = '$kode_soal'");
    if(mysqli_num_rows($q_soal) > 0){
        echo "<script> alert('Kode soal sudah digunakan!'); </script>";
    }else{
        $q_add_soal = mysqli_query($conn, "INSERT INTO tb_soal VALUES ('$kode_soal','$id_pengampu','$jenis_ujian','$acak_q','$acak_o')");
        if(mysqli_affected_rows($conn) > 0){
            echo "<script> alert('Data soal berhasil ditambahkan!'); </script>";
        }
    }

}


// edit soal
if(isset($_POST['exc_edit_soal'])){
    $kode_soal_lama = $_POST['kode_soal_lama'];
    $jenis_ujian = $_POST['jenis_ujian'];
    $kode_soal_baru = $_POST['kode_soal_baru'];
    $acak_q = $_POST['acak_pertanyaan'];
    $acak_o = $_POST['acak_opsi'];

    // validasi kesamaan kode soal
    $q_soal = mysqli_query($conn, "SELECT * FROM tb_soal WHERE kode_soal = '$kode_soal_baru' AND kode_soal != '$kode_soal_lama'");
    if(mysqli_num_rows($q_soal) > 0){
        echo "<script> alert('Kode soal sudah digunakan!'); </script>";
    }else{
        $q_edit_soal = mysqli_query($conn, "UPDATE tb_soal SET kode_soal = '$kode_soal_baru', id_jenis_ujian = '$jenis_ujian', acak_pertanyaan = '$acak_q', acak_opsi = '$acak_o' WHERE kode_soal = '$kode_soal_lama'");
        if(mysqli_affected_rows($conn) > 0){
            echo "<script> alert('Data soal berhasil diperbarui!'); </script>";
        }
    }

}



// delete soal
if(isset($_POST['exc_del_soal'])){
    $kode_soal = $_POST['kode_soal'];
    mysqli_query($conn, "DELETE FROM tb_soal WHERE kode_soal = '$kode_soal'");
    if(mysqli_affected_rows($conn) > 0){
        echo "<script> alert('Data berhasil dihapus!'); </script>";
    }
}


?>