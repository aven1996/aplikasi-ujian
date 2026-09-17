<?php
// tambah jadwal
if(isset($_POST['exc_add_jadwal'])){
    $kode_soal = $_POST['mapel'];
    // cek dulu kode soal sudah ada pada tabel jadwal apa belum
    $q_sl = mysqli_query($conn, "SELECT * FROM tb_jadwal WHERE kode_soal = '$kode_soal'");
    if(mysqli_num_rows($q_sl) > 0):
        echo "<script> alert('Jadwal sudah terjadwal, pilih soal lain!'); </script>";
    else: 
        $jenis_jadwal = $_POST['jenis_jadwal'];
        $durasi = htmlspecialchars($_POST['durasi']);
        if($jenis_jadwal == "Manual"){
            mysqli_query($conn, "INSERT INTO tb_jadwal VALUES ('','$kode_soal','--','--','--','$durasi')");
            if(mysqli_affected_rows($conn) > 0){
                // ambil id jadwal yang baru ditambahkan tadi
                $id_jadwal_q = mysqli_query($conn, "SELECT MAX(id_jadwal) FROM tb_jadwal");
                $id_jadwal = $id_jadwal_q->fetch_assoc();
                $id_jadwal = $id_jadwal['MAX(id_jadwal)'];
                // ambil id pengampu pada tabel soal berdasarkan kode soal
                $id_peng_q = mysqli_query($conn, "SELECT * FROM tb_soal WHERE kode_soal = '$kode_soal'");
                $id_peng = $id_peng_q->fetch_assoc();
                $id_peng = $id_peng['id_pengampu'];
                // tambahkan pada tabel stt ujian
                mysqli_query($conn, "INSERT INTO tb_stt_ujian VALUES ('','$id_jadwal','$id_peng','$kode_soal', 'Belum Dimulai')");
                if(mysqli_affected_rows($conn) > 0){
                    echo "<script> alert('Jadwal berhasil ditambahkan!'); </script>";
                }
            } 
        }else{
            $tgl = $_POST['tanggal'];
            $wk_mulai = $_POST['wk_mulai'];
            $wk_selesai = $_POST['wk_selesai'];
            mysqli_query($conn, "INSERT INTO tb_jadwal VALUES ('','$kode_soal','$tgl','$wk_mulai','$wk_selesai','$durasi')");
            if(mysqli_affected_rows($conn) > 0){
               // ambil id jadwal yang baru ditambahkan tadi
               $id_jadwal_q = mysqli_query($conn, "SELECT MAX(id_jadwal) FROM tb_jadwal");
               $id_jadwal = $id_jadwal_q->fetch_assoc();
               $id_jadwal = $id_jadwal['MAX(id_jadwal)'];
               // ambil id pengampu pada tabel soal berdasarkan kode soal
               $id_peng_q = mysqli_query($conn, "SELECT * FROM tb_soal WHERE kode_soal = '$kode_soal'");
               $id_peng = $id_peng_q->fetch_assoc();
               $id_peng = $id_peng['id_pengampu'];
               // tambahkan pada tabel stt ujian
               mysqli_query($conn, "INSERT INTO tb_stt_ujian VALUES ('','$id_jadwal','$id_peng','$kode_soal', 'Belum Dimulai')");
               if(mysqli_affected_rows($conn) > 0){
                   echo "<script> alert('Jadwal berhasil ditambahkan!'); </script>";
               }
            }
        }
    endif;
}

// edit jadwal
if(isset($_POST['exc_edit_jadwal'])){
    $id_pengampu = $_POST['id_pengampu'];
    $id_jadwal = $_POST['id_jadwal'];
    $jenis_jadwal = $_POST['jenis_jadwal'];
    $durasi = htmlspecialchars($_POST['durasi']);
    if($jenis_jadwal == "Manual"){
        mysqli_query($conn, "UPDATE tb_jadwal SET durasi = '$durasi', tanggal = '-', wk_mulai = '-', wk_selesai = '-' WHERE id_jadwal = '$id_jadwal'");
        if(mysqli_affected_rows($conn) > 0){
            echo "<script> alert('Jadwal berhasil diperbarui!'); </script>";
        }
    }else{
        $tgl = $_POST['tanggal'];
        $wk_mulai = $_POST['wk_mulai'];
        $wk_selesai = $_POST['wk_selesai'];
        mysqli_query($conn, "UPDATE tb_jadwal SET tanggal = '$tgl', wk_mulai = '$wk_mulai', wk_selesai = '$wk_selesai', durasi = '$durasi' WHERE id_jadwal = '$id_jadwal'");
        if(mysqli_affected_rows($conn) > 0){
            echo "<script> alert('Jadwal berhasil diperbarui!'); </script>";
        }
    }
}


// hapus jadwal
if(isset($_POST['exc_del_jadwal'])){
    $id_jadwal = $_POST['id_jadwal'];
    mysqli_query($conn, "DELETE FROM tb_jadwal WHERE id_jadwal = '$id_jadwal'");
    if(mysqli_affected_rows($conn) > 0){
        echo "<script> alert('Jadwal berhasil dihapus!'); </script>";
    }

}

?>