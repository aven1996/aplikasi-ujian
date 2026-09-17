<?php

// proses login siswa
if(isset($_POST['login_siswa'])){
    $nomor = htmlspecialchars($_POST['nomor_peserta']);
    $pass = htmlspecialchars($_POST['pass']);
    // cek apakah nomor sudah digunakan
    $stt_nomor_q = mysqli_query($conn, "SELECT * FROM tb_siswa WHERE nomor_peserta = '$nomor'");
    $siswa = $stt_nomor_q->fetch_assoc();
    if(mysqli_num_rows($stt_nomor_q) > 0){
        $stt_sw_q = mysqli_query($conn, "SELECT * FROM tb_stt_siswa_login WHERE nomor_peserta = '$nomor'");
        if(mysqli_num_rows($stt_sw_q) > 0){
            $stt_sw = $stt_sw_q->fetch_assoc();
            if($stt_sw['status_login'] == "online"){
                echo "<script> alert('Nomor peserta sudah digunakan peserta lain, harap hubungi petugas!'); </script>";
            }else{
                // cek kebenaran password
                if(password_verify($pass,$siswa['password_siswa'])){
                    $_SESSION['siswa'] = $nomor;
                    $_SESSION['kelas'] = $siswa['id_kelas'];
                    header("Location: main.php");
                }else{
                    echo "<script> alert('Password salah!'); </script>";        
                }
            }
        }else{
            // cek kebenaran password
            if(password_verify($pass,$siswa['password_siswa'])){
                $_SESSION['siswa'] = $nomor;
                $_SESSION['kelas'] = $siswa['id_kelas'];
                header("Location: main.php");
            }else{
                echo "<script> alert('Password salah!'); </script>";        
            }
        }
        
    }else{
        echo "<script> alert('Nomor peserta salah!'); </script>";
    }

}

?>