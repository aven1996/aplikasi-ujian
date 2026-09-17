<?php 
    include "connect.php";
    $id2 = $_GET['id'];
    $tg2 = $_GET['tg'];
    $jur2 = $_GET['jur'];

    $kls_q2 = mysqli_query($conn, "SELECT * FROM tb_kelas WHERE tingkat = '$tg2' AND kode_jurusan = '$jur2'");
    if(mysqli_num_rows($kls_q2) > 0):
    while($kls2 = $kls_q2->fetch_assoc()):

?>
    <option value="<?= $kls2['id_kelas'] ?>"><?= $kls2['nama_kelas'] ?></option>

<?php endwhile; ?>
<?php else: ?>
    <option value="">Tidak ada data kelas</option>
<?php endif; ?>
