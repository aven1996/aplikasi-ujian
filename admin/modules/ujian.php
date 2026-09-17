<?php
// update status ujian jika waktu sudah memenuhi syarat
mysqli_query($conn, "UPDATE tb_stt_ujian JOIN tb_jadwal ON tb_stt_ujian.id_jadwal = tb_jadwal.id_jadwal SET stt_ujian = 'Ujian Berlangsung' WHERE tanggal = CURDATE() AND wk_mulai <= CURTIME() AND tanggal != '0000-00-00' ");

    // insert tb laporan
    // jika terdapat tb stt ujian dengan stt ujian berlangsung dan kode soal belum ada pada tb_laporan
    $stt_q = mysqli_query($conn, "SELECT * FROM tb_stt_ujian WHERE stt_ujian = 'Ujian Berlangsung'");
    if(mysqli_num_rows($stt_q) > 0):
        while($stt = $stt_q->fetch_assoc()):
            $id_jadwal = $stt['id_jadwal'];
            // cari id pengampu dan kode soal dari tb stt_ujian
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
            if(mysqli_num_rows($lap_q) == 0):
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
        endwhile;
    endif;



// update status ujian jika waktu sudah selesai hari ini
mysqli_query($conn, "UPDATE tb_stt_ujian JOIN tb_jadwal ON tb_stt_ujian.id_jadwal = tb_jadwal.id_jadwal SET stt_ujian = 'Ujian Selesai' WHERE tanggal = CURDATE() AND wk_selesai < CURTIME() AND tanggal != '0000-00-00' ");

// update status ujian jika waktu sudah selesai sudah melewati hari yang terjadwal
mysqli_query($conn, "UPDATE tb_stt_ujian JOIN tb_jadwal ON tb_stt_ujian.id_jadwal = tb_jadwal.id_jadwal SET stt_ujian = 'Ujian Selesai' WHERE tanggal < CURDATE() AND tanggal != '0000-00-00' ");


?>