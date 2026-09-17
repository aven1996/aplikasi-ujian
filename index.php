<?php 
    // start session
    session_start();
    
    // load modules
    include "admin/modules/connect.php";
    include "admin/modules/general_func.php";
    include "_modules/login_siswa.php";
    
    // jika sudah login
    if(isset($_SESSION['petugas'])){
        header("Location: main.php");
    }


    $sekolah_q = mysqli_query($conn, "SELECT * FROM tb_profil");
    $sekolah = $sekolah_q->fetch_assoc();
    
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Ujian Semester <?= $sekolah['nama_sekolah']; ?></title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="shortcut icon" href="admin/assets/img/icon.ico" type="image/x-icon">

    <!-- font google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@400;700&display=swap" rel="stylesheet">

    <!-- iconmoon -->
    <link rel="stylesheet" href="admin/assets/img/icomoon/style.css">

    <!-- myCSS -->
    <link rel="stylesheet" href="admin/assets/css/main.css">
</head>
<body>
<!-- FORM LOGIN -->
<div class="container text-center">
    <!-- logo -->
    <?php 
        
        if(!empty($sekolah['logo_sekolah'])):
    ?>
        <img src="admin/assets/img/profil_smk/<?= $sekolah['logo_sekolah']; ?>" style="width: 100px; margin: 50px 0 20px 0;" alt="">
    <?php else: ?>
        <img src="admin/assets/img/logo_full.svg" style="width: 150px; margin: 50px 0 50px 0;" alt="">
    <?php endif; ?>
    <h3 class="text-info" style="font-weight: bolder; ">UJIAN SEMESTER</h3>
    <h6 style="margin-bottom: 50px;"><?= $sekolah['nama_sekolah']; ?></h6>
    <h3 class="text-center my-3 text-secondary" style="font-weight: bold;">Log In</h3>
    <form action="" method="POST" style="width: 300px; margin:auto;" class="text-left">
        <div class="position-relative">
            <b class="icon-user1 position-absolute text-info border-right pr-2" style="top:10px; left:10px;"></b>
            <input name="nomor_peserta" type="text" class="form-control mb-2" style="padding-left: 40px;"  placeholder="Nomor peserta" required>
        </div>
        <div class="position-relative">
            <b class="icon-lock position-absolute text-info border-right pr-1" style="top:10px; left:10px;"></b>
            <input name="pass" id="pass-form" type="password" class="form-control mb-2" style="padding-left: 40px;"  placeholder="Password" required>
            <b class="icon-eye position-absolute" style="top:10px; right:10px;" onclick="look_pass('#pass-form')"></b>
        </div>
        <button type="submit" class="btn btn-info w-100 mb-3" name="login_siswa">Log In</button>
        
    </form>
</div>



<!-- FOOTER -->
<div class="border-top py-2 pb-3 text-center position-fixed w-100" style="bottom:0; background-color:whitesmoke;">
    <small class="text-secondary">Development by <a href="#">Afen Afrianto</a></small>
</div>



<!-- modeal akun default -->
<div class="modal fade" id="akun_default" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Akun Default</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="GET">
        <div class="modal-body">
            <table>
                <tr>
                    <th class="col-sm-6 text-info">Username</th>
                    <th class="col-sm-6 text-info">Password</th>
                </tr>
                <tr>
                    <td class="col-sm-6">admin</td>
                    <td class="col-sm-6">admin</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script type="text/javascript" src="bootstrap/jquery/jquery.min.js"></script>
<script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>


<script>
    var hand_click = 1;
    function look_pass(id_form){
        if(hand_click == 1){
            $(id_form).attr("type","text");
            hand_click = 0;
        }else{
            $(id_form).attr("type","password");
            hand_click = 1;
        }
    }
</script>
</body>
</html>


