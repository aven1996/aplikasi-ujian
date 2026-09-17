<?php
    
    if(isset($_POST['login_petugas'])){
        $user = htmlspecialchars($_POST['user']);
        $pass = htmlspecialchars($_POST['pass']);

        // ambil password dr db
        $query = mysqli_query($conn, "SELECT * FROM tb_admin WHERE username_admin = '$user'");
        $guru_query = mysqli_query($conn, "SELECT * FROM tb_guru WHERE username_guru = '$user'");

        // validasi kecocokan username
        if(mysqli_num_rows($query) > 0){
            // ambil nilai password yang di db
            $pass_db = $query->fetch_assoc();
            $pass_hash = $pass_db['password_admin'];
            $id_ptg = $pass_db['id_admin'];

            // cocokan pass yang diinput dengan password dr db
            if(password_verify($pass,$pass_hash)){
                $_SESSION['petugas'] = 'admin';
                $_SESSION['user'] = $user;
                $_SESSION['id_ptg'] = $id_ptg;
                header("Location: main.php");
            }else{
                echo "<script> alert('Password salah!'); </script>";
            }
        }elseif(mysqli_num_rows($guru_query) > 0){
            // ambil nilai password yang di db
            $pass_db = $guru_query->fetch_assoc();
            $pass_hash = $pass_db['password_guru'];
            $id_ptg = $pass_db['id_guru'];

            // cocokan pass yang diinput dengan password dr db
            if(password_verify($pass,$pass_hash)){
                $_SESSION['petugas'] = 'guru';
                $_SESSION['user'] = $user;
                $_SESSION['id_ptg'] = $id_ptg;
                header("Location: main.php");
            }else{
                echo "<script> alert('Password salah!'); </script>";
            }
        }else{
            echo "<script> alert('Username tidak cocok!'); </script>";
        }
    }



?>