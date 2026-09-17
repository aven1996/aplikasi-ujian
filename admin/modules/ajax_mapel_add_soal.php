<?php
session_start();
include "connect.php";

$cari = "";
$cari_x = "";
$key = $_GET['key'];
if(!empty($key)){
    $cari = "WHERE tb_mapel.nama_mapel LIKE '%$key%'";
    $cari_x = "AND tb_mapel.nama_mapel LIKE '%$key%'";
}
if($_SESSION['petugas'] == "admin"):
    $q_mapel = mysqli_query($conn, "SELECT * FROM tb_guru_pengampu JOIN tb_mapel ON tb_guru_pengampu.id_mapel = tb_mapel.id_mapel JOIN tb_guru ON tb_guru_pengampu.id_guru = tb_guru.id_guru $cari");
else:
    $user_ptg = $_SESSION['user'];
    $q_mapel = mysqli_query($conn, "SELECT * FROM tb_guru_pengampu JOIN tb_mapel ON tb_guru_pengampu.id_mapel = tb_mapel.id_mapel JOIN tb_guru ON tb_guru_pengampu.id_guru = tb_guru.id_guru WHERE username_guru = '$user_ptg' $cari_x");
endif;
if(mysqli_num_rows($q_mapel) > 0):
    while($mp = $q_mapel->fetch_assoc()):
?>
<!-- card mapel -->
<div class="col-sm-6 p-1">
    <div class="card-mapel border p-2 rounded"  data-toggle="modal" data-target="#isi_form_tambah_soal<?= $mp['id_pengampu']; ?>">
    <h5><?= $mp['nama_mapel'];?></h5>
    <span>Kelas <?= $mp['tingkat']; ?></span>
    <!-- looping jurusan -->
    <?php 
        $id_pengampu = $mp['id_pengampu'];
        $jur_mp_q = mysqli_query($conn, "SELECT * FROM tb_pengampu_jur JOIN tb_jurusan ON tb_pengampu_jur.kode_jurusan = tb_jurusan.kode_jurusan WHERE id_pengampu = '$id_pengampu'");
        while($icon_jur = $jur_mp_q->fetch_assoc()):

    ?>
        <b class="icon-circle" style="color: <?= $icon_jur['warna_jurusan']; ?>" title="<?= $icon_jur['nama_jurusan']; ?>"></b>
    <?php endwhile; ?>
    <span class="d-block"><?= $mp['nama_guru']; ?></span>
    </div>
</div>
<?php endwhile; ?>
<?php else: ?>
    <div>Data mapel tidak ada</div>
<?php endif; ?>