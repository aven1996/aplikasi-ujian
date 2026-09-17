<?php
    include "connect.php";
    
    $kode_soal = $_GET['kode'];
    $lap_qx = $conn->query("SELECT * FROM tb_laporan WHERE kode_soal = '$kode_soal'");
    $lapx = $lap_qx->fetch_assoc();
    $set_balance = $lapx['set_balance'];
    if($set_balance == 'Tidak'):
        $conn->query("UPDATE tb_laporan SET set_balance = 'Ya' WHERE kode_soal = '$kode_soal'");
    else:
        $conn->query("UPDATE tb_laporan SET set_balance = 'Tidak' WHERE kode_soal = '$kode_soal'");
    endif;
?>

<!-- output -->
<?php
    $lap_qz = $conn->query("SELECT * FROM tb_laporan JOIN tb_soal ON tb_laporan.kode_soal = tb_soal.kode_soal JOIN tb_guru_pengampu ON tb_laporan.id_pengampu = tb_guru_pengampu.id_pengampu JOIN tb_mapel ON tb_laporan.id_mapel = tb_mapel.id_mapel");
    $lapz = $lap_qz->fetch_assoc();
?>
<?php if($lapz['set_balance'] == "Ya"): ?>
    <h2 class="icon-balance-scale text-danger"></h2>
<?php else: ?>
    <h2 class="icon-balance-scale text-secondary"></h2>
<?php endif; ?>

<script>location.reload();</script>