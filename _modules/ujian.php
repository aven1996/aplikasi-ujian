<?php
session_start();
// jika belum login
if(!isset($_SESSION['siswa'])){
    header("Location: index.php");
}else{
    $_SESSION['kode_soal'] = $_GET['kode'];
    $kode_soal = $_SESSION['kode_soal'];
    $nomor_peserta = $_SESSION['siswa'];
}

// ambil data soal 
$soal_q = mysqli_query($conn, "SELECT * FROM tb_soal JOIN tb_guru_pengampu ON tb_soal.id_pengampu = tb_guru_pengampu.id_pengampu WHERE kode_soal = '$kode_soal'");
$soal = $soal_q->fetch_assoc();
$id_pengampu = $soal['id_pengampu'];


// ambil data mapel dari tabel pengampu
$peng_q = mysqli_query($conn, "SELECT * FROM tb_guru_pengampu JOIN tb_mapel ON tb_guru_pengampu.id_mapel = tb_mapel.id_mapel WHERE id_pengampu = '$id_pengampu'");
$pengampu = $peng_q->fetch_assoc();
$nama_mapel = $pengampu['nama_mapel'];


// ambil data jadwal
$jadwal_q = mysqli_query($conn, "SELECT * FROM tb_jadwal WHERE kode_soal = '$kode_soal'");
$jadwal = $jadwal_q->fetch_assoc();


// ambil data pertanyaan
$pertanyaan_q = $conn->query("SELECT * FROM tb_pertanyaan WHERE kode_soal = '$kode_soal'");
$pertanyaan = $pertanyaan_q->fetch_assoc();

if (mysqli_num_rows($pertanyaan_q) > 0) {
    // jika baru pertama kali dimuat, stlh sudah dimuat maka tidak akan diproses lg
    if(!isset($_SESSION['wk_terpakai'])){
        $stt_siswa_ujian = $_GET['stt'];
        // cek stt siswa ujian
        if($stt_siswa_ujian == "Ujian Baru"){
            // input jika ini adalah ujian baru
            mysqli_query($conn, "INSERT INTO tb_stt_siswa_login VALUES ('','$nomor_peserta','$kode_soal','online','Mengerjakan',0)");
            $_SESSION['wk_terpakai'] = 0;
            $wk_terpakai = $_SESSION['wk_terpakai'];

            // buat time siswa di cookie browser
            echo "
            <script>
                var TimeNow = new Date().getTime();
                document.cookie = 'getTimeUser='+TimeNow;
                document.cookie = 'durasi_terpakai=0';
            </script>
            ";
            

        }elseif($stt_siswa_ujian == "Lanjut Ujian"){
            $stt_siswa = mysqli_query($conn, "SELECT * FROM tb_stt_siswa_login WHERE nomor_peserta = '$nomor_peserta' AND kode_soal = '$kode_soal'");
            $stt_siswa = $stt_siswa->fetch_assoc();
            $_SESSION['wk_terpakai'] = $stt_siswa['wk_terpakai'];
            $wk_terpakai = $_SESSION['wk_terpakai'];

            // buat time siswa di cookie browser
            echo "
            <script>
                var TimeNow = new Date().getTime();
                document.cookie = 'getTimeUser='+TimeNow;
                document.cookie = 'durasi_terpakai=0';
            </script>
            ";

            // update stt ujian
            mysqli_query($conn, "UPDATE tb_stt_siswa_login SET status_login = 'online', status_ujian = 'Mengerjakan' WHERE nomor_peserta = '$nomor_peserta' AND kode_soal = '$kode_soal' ");
        }
    }
    
    // muat soal ke nosoal jika soal acak
    $nosoal_q = $conn->query("SELECT * FROM tb_nosoal WHERE nomor_peserta = '$nomor_peserta' AND kode_soal = '$kode_soal'");
    $question_q = $conn->query("SELECT * FROM tb_pertanyaan WHERE kode_soal = '$kode_soal'");
    if(mysqli_num_rows($nosoal_q) > 0){
        
        $nosoal = [];
        while ($ns = $nosoal_q->fetch_assoc()) {
            $nosoal[] = $ns['id_pertanyaan'];
        }

        // cek dulu jml antara pertanyaan dengan nosoal sama atau tidak
        if(mysqli_num_rows($question_q) != mysqli_num_rows($nosoal_q)){
            // cek ada dalam array nosoal atau tidak
            $nosoal_not = [];
            while($q = $question_q->fetch_assoc()){
                if(!in_array($q['id_pertanyaan'], $nosoal)){
                    // jika tidak ada, maka akan ditambakan
                    $nosoal_not[] = $q['id_pertanyaan'];
                }
            }
            // acak soal yang akan digabungkan ke nosoal
            shuffle($nosoal_not);
            // gabungkan array
            $nosoal = array_merge($nosoal, $nosoal_not);
        }
        
    }else{
        // jika tidak ada dalam nosoal, cek dlu pada tb soal apakah acak soal atau tidak
        $jdw_q = mysqli_query($conn, "SELECT * FROM tb_soal WHERE kode_soal = '$kode_soal'");
        $jdw = $jdw_q->fetch_assoc();
        if($jdw['acak_pertanyaan'] == "Ya"){
            $que_q = mysqli_query($conn, "SELECT * FROM tb_pertanyaan WHERE kode_soal = '$kode_soal'");
            $nosoal = [];
            while($que = $que_q->fetch_assoc()){
                $nosoal[] = $que['id_pertanyaan'];
            }
            // acak nosoal
            shuffle($nosoal);
            // inputkan ke tb nosoal
            foreach ($nosoal as $ns) {
                mysqli_query($conn, "INSERT INTO tb_nosoal VALUES ('', '$nomor_peserta', '$kode_soal','$ns')");
            }
        }
    }
}else{
    // jika belum ada butir soal
    header("Location: soal404.php");
}



?>