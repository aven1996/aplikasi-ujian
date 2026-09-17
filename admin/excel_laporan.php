<?php
    // start session
    session_start();

    //set timezone indonesia
	date_default_timezone_set("Asia/Jakarta");
    
     // load modules
     include "modules/connect.php";
     include "modules/general_func.php";
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APPUS Lite | Aplikasi Ujian Semester SMK</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="shortcut icon" href="assets/img/icon.ico" type="image/x-icon">

    <!-- font google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@400;700&display=swap" rel="stylesheet">

    <!-- iconmoon -->
    <link rel="stylesheet" href="assets/img/icomoon/style.css">
    <link rel="stylesheet" href="assets/img/icomoon2/style.css">

    <!-- css cdn datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
    
    <!-- myCSS -->
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>
<div class="container bg-white" style="width: 21cm; min-height:29.7cm;" class="p-3">
    <!-- kop sekolah
    <?php
        $sekolah = $conn->query("SELECT * FROM tb_profil");
        $sekolah = $sekolah->fetch_assoc();
    ?>
    <div class="text-center py-2">
        <img src="assets/img/profil_smk/<?= $sekolah['kop_sekolah']; ?>" alt="" class="w-75">
    </div> -->

    <!-- judul -->
    <div class="text-center my-3" style="font-weight: bold;">
        <!-- <h6><b>LAPORAN PENILAIAN</b></h6> -->
    
    <!-- jenis ujian -->
    <?php
        $kode_soal = $_GET['kode'];
        $soal = $conn->query("SELECT * FROM tb_soal JOIN tb_jenis_ujian ON tb_soal.id_jenis_ujian = tb_jenis_ujian.id_jenis_ujian JOIN tb_guru_pengampu ON tb_soal.id_pengampu = tb_guru_pengampu.id_pengampu WHERE tb_soal.kode_soal = '$kode_soal'");
        $soal = $soal->fetch_assoc();
        $jenis_ujian = $soal['jenis_ujian'];
        $tahun_ajaran = $soal['tahun_ajaran'];

    ?>
        <!-- <h6><b><?= $jenis_ujian; ?></b></h6>
        <h6><b>Tahun Pelajaran <?= $tahun_ajaran; ?></b></h6> -->
    </div>
    <!-- isi -->
    <?php
        // berita acara
        $ba = $conn->query("SELECT * FROM tb_berita_acara WHERE kode_soal = '$kode_soal'");
        $ba = $ba->fetch_assoc();

        // tingkat
        $tingkat = $soal['tingkat'];

        // mapel
        $id_mapel = $soal['id_mapel'];
        $mapel = $conn->query("SELECT * FROM tb_mapel WHERE id_mapel = '$id_mapel'");
        $mapel = $mapel->fetch_assoc();
        $nama_mapel = $mapel['nama_mapel'];

        // guru pengampu
        $id_guru = $soal['id_guru'];
        $guru = $conn->query("SELECT * FROM tb_guru WHERE id_guru = '$id_guru'");
        $guru = $guru->fetch_assoc();
        $nama_pengampu = $guru['nama_guru'];
    ?>

    <!-- cari jumlah siswa absen -->
    <?php
        // cari id pengampu
        $soal_q = $conn->query("SELECT * FROM tb_soal JOIN tb_guru_pengampu ON tb_soal.id_pengampu = tb_guru_pengampu.id_pengampu JOIN tb_jenis_ujian ON tb_soal.id_jenis_ujian = tb_jenis_ujian.id_jenis_ujian WHERE kode_soal = '$kode_soal'");
        $soal = $soal_q->fetch_assoc();
        $id_peng = $soal['id_pengampu'];

        // ambil data mapel yang ada di tb guru pengampu berdasarkan id pengampu
        $peng_q = $conn->query("SELECT * FROM tb_guru_pengampu JOIN tb_mapel ON tb_guru_pengampu.id_mapel = tb_mapel.id_mapel JOIN tb_guru ON tb_guru_pengampu.id_guru = tb_guru.id_guru WHERE tb_guru_pengampu.id_pengampu = '$id_peng'");
        $peng = $peng_q->fetch_assoc();
        $nama_mapel = $peng['nama_mapel'];

        // amil semua data siswa sesuai kode soal
        $semua_siswa = [];
        $siswa_q = $conn->query("SELECT * FROM tb_siswa JOIN tb_kelas ON tb_siswa.id_kelas = tb_kelas.id_kelas");
        while($siswa = $siswa_q->fetch_assoc()):
            if($siswa['tingkat'] == $peng['tingkat']){
                $jur_sw_q = $conn->query("SELECT * FROM tb_pengampu_jur JOIN tb_jurusan ON tb_pengampu_jur.kode_jurusan = tb_jurusan.kode_jurusan WHERE id_pengampu = '$id_peng'");
                while($jur_sw = $jur_sw_q->fetch_assoc()):
                    if($siswa['kode_jurusan'] == $jur_sw['kode_jurusan']){
                        $semua_siswa[] = $siswa['nomor_peserta'];
                    }
                endwhile;
            }
        endwhile;

        $siswa_mengerjakan = [];
        // ambil data siswa yang mengerjakan
        $siswa_ujian_q = $conn->query("SELECT * FROM tb_stt_siswa_login JOIN tb_siswa ON tb_stt_siswa_login.nomor_peserta = tb_siswa.nomor_peserta WHERE kode_soal = '$kode_soal'");
        while($siswa_ujian = $siswa_ujian_q->fetch_assoc()){
            $siswa_mengerjakan[] = $siswa_ujian['nomor_peserta'];
        }

        $siswa_absen = [];
        // cocokan semua siswa dengan siswa yang mengerjakan
        foreach($semua_siswa as $sw){
            if(!in_array($sw, $siswa_mengerjakan)){
                $siswa_absen[] = $sw;
            }
        }
    ?>
    <!-- ketarangan -->
    <div class="px-5 py-2 d-flex flex-column justify-content-between " hidden>
        <div id="mapel" hidden><?= $nama_mapel; ?></div>
        <div id="guru" hidden><?= $peng['nama_guru']; ?></div>
    </div>

    <!-- siswa absen -->
    <div class="px-5 mb-3">
        <table class="table table-striped bg-white" id="tblNilai">
            <thead>
                <tr>
                    <th scope="col" class="text-info w-50" style="min-width: 250px;">Nama</th>
                    <th scope="col" class="text-info">Nomor Peserta</th>
                    <th scope="col" class="text-info">Kelas</th>
                    <th scope="col" class="text-info">Nilai</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(count($siswa_mengerjakan) > 0):
                    foreach($siswa_mengerjakan as $sw):
                        // cek siswa apakah sudah masuk pada tabel jawaban karena sudah menjawab
                        // cek dulu apkah soal pdf atau bukan
                        $soal_pdf = $conn->query("SELECT * FROM tb_butir_pdf WHERE kode_soal = '$kode_soal'");
                        if(mysqli_num_rows($soal_pdf) > 0){
                            $jwb_sw = $conn->query("SELECT * FROM tb_jawaban_pdf WHERE nomor_peserta = '$sw' AND kode_soal = '$kode_soal'");
                        }else{
                            $jwb_sw = $conn->query("SELECT * FROM tb_jawaban WHERE nomor_peserta = '$sw' AND kode_soal = '$kode_soal'");
                        }
                            if(mysqli_num_rows($jwb_sw) > 0):
                                $siswa_q = $conn->query("SELECT * FROM tb_siswa JOIN tb_kelas ON tb_siswa.id_kelas = tb_kelas.id_kelas WHERE nomor_peserta = '$sw'");
                                $siswa = $siswa_q->fetch_assoc();
                ?>
                                <tr>
                                    <td><?= $siswa['nama_siswa']; ?></td>
                                    <td><?= $siswa['nomor_peserta']; ?></td>
                                    <td><?= $siswa['nama_kelas']; ?></td>
                                    <td><?= number_format(cekNilai($kode_soal, $siswa['nomor_peserta']),2,",",""); ?></td>
                                </tr>
                            <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada siswa absen</td>
                    </tr>
                <?php endif; ?>
            </tbody>

        </table>

    </div>

</div>


<script type="text/javascript" src="../bootstrap/jquery/jquery.min.js"></script>
<script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>
<script>
var mapel = $("#mapel").html();
var guru = $("#guru").html();

// eksekusi fungsi
tableHtmlToExcel("tblNilai",mapel+" - "+guru);

// fungsi download excel
function tableHtmlToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
   
    filename = filename?filename+'.xls':'excel_data.xls';
   
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
   
        downloadLink.download = filename;
       
        downloadLink.click();
    }
}
</script>
</body>
</html>