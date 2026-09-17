<?php
// hapus jadwal
if(isset($_POST['exc_del_jadwal'])){
    $id_jadwal = $_POST['id_jadwal'];
    mysqli_query($conn, "DELETE FROM tb_jadwal WHERE id_jadwal = '$id_jadwal'");
    if(mysqli_affected_rows($conn) > 0){
        echo "<script> alert('Jadwal berhasil dihapus!'); </script>";
    }
}

 
// jika klik tombol mulai sekarang
if(isset($_POST['mulai_now'])){
    $id_jadwal = $_POST['id_jadwal'];
    mysqli_query($conn, "UPDATE tb_stt_ujian SET stt_ujian = 'Ujian Berlangsung' WHERE id_jadwal = '$id_jadwal'");

    // insert tb laporan
    // caro id pengampu dan kode soal dari tb stt_ujian
    $jadwal_q = mysqli_query($conn, "SELECT * FROM tb_stt_ujian WHERE id_jadwal = '$id_jadwal'");
    $jadwal = $jadwal_q->fetch_assoc();
    $id_peng = $jadwal['id_pengampu'];
    $kode_soal = $jadwal['kode_soal'];
    // cari id mapel dari tb_guru_pnegampu berdasarkan id pengamp
    $peng_q = mysqli_query($conn, "SELECT * FROM tb_guru_pengampu WHERE id_pengampu = '$id_peng'");
    $peng = $peng_q->fetch_assoc();
    $id_mapel = $peng['id_mapel'];
    // query insert
    // cek apakah data laporan dengan kode soal yang sama sudah ada
    $lap_q = mysqli_query($conn, "SELECT * FROM tb_laporan WHERE kode_soal = '$kode_soal'");
    if(mysqli_num_rows($lap_q) > 0):
        // jika sudah ada maka akan diupdate saja
        mysqli_query($conn, "UPDATE tb_laporan SET tgl_update = NOW() WHERE kode_soal = '$kode_soal'");
    else:
        // jika belu ada makan akan diinsert
        mysqli_query($conn, "INSERT INTO tb_laporan VALUES ('','$id_peng','$id_mapel','$kode_soal', NOW(), 'Tidak')");
    endif;


    // tambah data berita acara saat ujian dimulai
    // cek dlu apakah sudah ada tau belum data dengan kode soal ini
    $ba_q = mysqli_query($conn, "SELECT * FROM tb_berita_acara WHERE kode_soal = '$kode_soal'");
    if(mysqli_num_rows($ba_q) == 0){
        // klo belum ada maka akan ditambahkan , jika sudah ada tidak perlu ditambhakan hanya update tgl
        mysqli_query($conn, "INSERT INTO tb_berita_acara VALUES ('','$kode_soal', CURDATE(),'','','-')");
    }else{
        mysqli_query($conn, "UPDATE tb_berita_acara SET tanggal = CURDATE() WHERE kode_soal = '$kode_soal'");
    }


}


// jika klik tombol akhiri sekarang maka akan mengeluarkan siswa dari ujian dan mengubah stt ujian siswa menjadi selesai
if(isset($_POST['akhiri_now'])){
    $kode_soal = $_POST['kode_soal'];
    $id_jadwal = $_POST['id_jadwal'];
    mysqli_query($conn, "UPDATE tb_stt_ujian SET stt_ujian = 'Ujian Selesai' WHERE id_jadwal = '$id_jadwal'");
}


// jika klik tombol mulai lagi
if(isset($_POST['mulai_lagi'])){
    $kode_soal = $_POST['kode_soal'];
    $id_jadwal = $_POST['id_jadwal'];
    mysqli_query($conn, "UPDATE tb_stt_ujian SET stt_ujian = 'Ujian Berlangsung' WHERE id_jadwal = '$id_jadwal'");

    // insert tb laporan
    // caro id pengampu dan kode soal dari tb jadwal
    $jadwal_q = mysqli_query($conn, "SELECT * FROM tb_stt_ujian WHERE id_jadwal = '$id_jadwal'");
    $jadwal = $jadwal_q->fetch_assoc();
    $id_peng = $jadwal['id_pengampu'];
    $kode_soal = $jadwal['kode_soal'];

    // cari id mapel dari tb_guru_pnegampu berdasarkan id pengamp
    $peng_q = mysqli_query($conn, "SELECT * FROM tb_guru_pengampu WHERE id_pengampu = '$id_peng'");
    $peng = $peng_q->fetch_assoc();
    $id_mapel = $peng['id_mapel'];

    // query insert
    // cek apakah data laporan dengan kode soal yang sama sudah ada
    $lap_q = mysqli_query($conn, "SELECT * FROM tb_laporan WHERE kode_soal = '$kode_soal'");
    if(mysqli_num_rows($lap_q) > 0):
        // jika sudah ada maka akan diupdate saja
        mysqli_query($conn, "UPDATE tb_laporan SET tgl_update = NOW() WHERE kode_soal = '$kode_soal'");
    else:
        // jika belu ada makan akan diinsert
        mysqli_query($conn, "INSERT INTO tb_laporan VALUES ('','$id_peng','$id_mapel','$kode_soal', NOW(), 'Tidak')");
    endif;

    // tambah data berita acara saat ujian dimulai
    // cek dlu apakah sudah ada tau belum data dengan kode soal ini
    $ba_q = mysqli_query($conn, "SELECT * FROM tb_berita_acara WHERE kode_soal = '$kode_soal'");
    if(mysqli_num_rows($ba_q) == 0){
        // klo belum ada maka akan ditambahkan , jika sudah ada tidak perlu ditambhakan hanya update tgl
        mysqli_query($conn, "INSERT INTO tb_berita_acara VALUES ('','$kode_soal', CURDATE(),'','','-')");
    }else{
        mysqli_query($conn, "UPDATE tb_berita_acara SET tanggal = CURDATE() WHERE kode_soal = '$kode_soal'");
    }
}


?>