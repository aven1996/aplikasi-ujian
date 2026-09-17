<?php 
    include "connect.php";
    $tg1 = $_GET['tg'];
    $jur1 = $_GET['jur'];
    $kls_q = mysqli_query($conn, "SELECT * FROM tb_kelas WHERE tingkat = '$tg1' AND kode_jurusan = '$jur1'");
    if(mysqli_num_rows($kls_q) > 0):
    while($kls = $kls_q->fetch_assoc()):

?>
    <option value="<?= $kls['id_kelas'] ?>"><?= $kls['nama_kelas'] ?></option>

<?php endwhile; ?>
<?php else: ?>
    <option value="">Tidak ada data kelas</option>
<?php endif; ?>
