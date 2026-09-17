<?php
    if(isset($_POST['exc_logout'])){ 
        if(isset($_SESSION['siswa'])){
            $nomor_peserta = $_SESSION['siswa'];
            mysqli_query($conn, "UPDATE tb_stt_siswa_login SET status_login = 'offline' WHERE nomor_peserta = '$nomor_peserta'");
            
            // update waktu yang telah terpakai 
            if(isset($_COOKIE['durasi_terpakai'])):
                $terpakai = $_COOKIE['durasi_terpakai'];
                $terpakai = round($terpakai / 60);
                $conn->query("UPDATE tb_stt_siswa_login SET wk_terpakai = '$terpakai' WHERE nomor_peserta = '$nomor_peserta' AND kode_soal = '$kode_soal' ");
            endif;
                        
        }
        // penghapusan semua session
        session_unset();
        session_destroy();
        header("Location: index.php");
        
        // penghapusan cookie
        setcookie("durasi_terpakai", "");
        setcookie("getTimeUser", "");
    }
    
?>