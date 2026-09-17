<div class="container py-3">
    <div class="d-flex">
        <h3 class="text-info py-2" style="font-weight:bold;">Status Ujian</h3>
    </div>

    <!-- status ujian -->
    <div class="row align-items-center">
        <img src="assets/img/svg/001-online class.svg" alt="" width="200" class="p-2 mx-3">
        <div class="d-flex flex-column mx-3 mb-2 px-2">
            <?php
                $stt_uj = [];
                $jml_ujian_berlangsung = [];
                $stt_ujian_q = mysqli_query($conn, "SELECT * FROM tb_stt_ujian JOIN tb_jadwal ON tb_stt_ujian.id_jadwal = tb_jadwal.id_jadwal WHERE tanggal = '0000-00-00' OR tanggal = CURDATE()");
                while($stt_ujian= $stt_ujian_q->fetch_assoc()){
                    if($stt_ujian['stt_ujian'] == "Ujian Berlangsung"){
                        $jml_ujian_berlangsung[] = $stt_ujian['kode_soal'];
                    }
                    $stt_uj[] = $stt_ujian['stt_ujian'];
                }

                // menentukan status yang ditampilkan
                if(!in_array("Ujian Selesai",$stt_uj) AND !in_array("Ujian Berlangsung",$stt_uj)){
                    $stt = "Ujian Belum Dimulai";
                }elseif(in_array("Ujian Berlangsung",$stt_uj)){
                    $stt = "Ujian Berlangsung";
                }elseif(in_array("Ujian Selesai",$stt_uj) AND !in_array("Ujian Berlangsung",$stt_uj)){
                    $stt = "Ujian Selesai";
                }

            ?>
            <?php if($stt == "Ujian Berlangsung"): ?>
                <h2 class="bg-success text-white p-2 rounded" style="font-weight: bold;"><?= $stt; ?></h2>
            <?php elseif($stt == "Ujian Belum Dimulai"): ?>
                <h2 class="bg-secondary text-white p-2 rounded" style="font-weight: bold;"><?= $stt; ?></h2>
            <?php elseif($stt == "Ujian Selesai"): ?>
                <h2 class="bg-primary text-white p-2 rounded" style="font-weight: bold;"><?= $stt; ?></h2>
            <?php endif; ?>

            <div class="d-flex justify-content-around rounded " style="background-color: lightgray;">
                <div class="d-flex w-25 align-items-center" title="Ujian berlangsung">
                    <b class="icon-servers mr-2" style="font-size: large;"></b>
                    <b style="font-size: x-large;"><?= count($jml_ujian_berlangsung); ?></b>
                </div>
                <div class="d-flex w-25 align-items-center" title="Siswa sedang mengerjakan">
                    <b class="icon-user1 mr-2" style="font-size: large;"></b>
                    <b style="font-size: x-large;">
                        <?php
                            $siswa_login_q = mysqli_query($conn, "SELECT * FROM tb_stt_siswa_login WHERE status_login = 'online' AND status_ujian = 'Mengerjakan'");
                            echo mysqli_num_rows($siswa_login_q);
                        ?>
                    </b>
                </div>
            </div>
        </div>
    </div>

    <div class="pl-2 pt-2 pr-2 pb-0 border rounded mb-2 bg-white">
    <?php
    // daftar ujian tampil pada jadwal manual dan pada hari ini
    $jadwal_q = mysqli_query($conn, "SELECT * FROM tb_jadwal JOIN tb_soal ON tb_jadwal.kode_soal = tb_soal.kode_soal WHERE tanggal = '0000-00-00' OR tanggal = CURDATE()");
    if(mysqli_num_rows($jadwal_q) > 0):
        while ($jadwal = $jadwal_q->fetch_assoc()):
        $id_jadwal = $jadwal['id_jadwal'];

        // ambil data stt ujian berdasarkan id_jadwal
        $ujian_q = mysqli_query($conn, "SELECT * FROM tb_stt_ujian JOIN tb_soal ON tb_stt_ujian.kode_soal = tb_soal.kode_soal JOIN tb_jadwal ON tb_stt_ujian.id_jadwal = tb_jadwal.id_jadwal JOIN tb_guru_pengampu ON tb_stt_ujian.id_pengampu = tb_guru_pengampu.id_pengampu WHERE tb_stt_ujian.id_jadwal = '$id_jadwal'");
        $ujian = $ujian_q->fetch_assoc();
        $kode_soal = $ujian['kode_soal'];

        // jenis ujian
        $id_jenis = $ujian['id_jenis_ujian'];
        $jenis_ujian_q = mysqli_query($conn, "SELECT * FROM tb_jenis_ujian WHERE id_jenis_ujian = '$id_jenis'");
        $jenis_ujian = $jenis_ujian_q->fetch_assoc();
        
        // nama mapel
        $id_pengampu = $ujian['id_pengampu'];
        $mapel_q = mysqli_query($conn, "SELECT * FROM tb_guru_pengampu JOIN tb_mapel ON tb_guru_pengampu.id_mapel = tb_mapel.id_mapel WHERE id_pengampu = '$id_pengampu'");
        $mapel = $mapel_q->fetch_assoc();

        // mapel jurusan
        $jur_q = mysqli_query($conn, "SELECT * FROM tb_pengampu_jur JOIN tb_jurusan ON tb_pengampu_jur.kode_jurusan = tb_jurusan.kode_jurusan WHERE id_pengampu = '$id_pengampu'");
        
        // jumlah siswa selesai
        $siswa_selesai_q = mysqli_query($conn, "SELECT * FROM tb_stt_siswa_login WHERE kode_soal = '$kode_soal' AND status_ujian = 'Selesai'");
        $jml_sw_selesai = mysqli_num_rows($siswa_selesai_q);

        // jumlah siswa mengerjakan
        $siswa_all_q = mysqli_query($conn, "SELECT * FROM tb_stt_siswa_login WHERE kode_soal = '$kode_soal'");
        $jml_sw_all = mysqli_num_rows($siswa_all_q);

        // jika jadwal otomatis
        if($jadwal['tanggal'] == date('Y-m-d')):
            
    ?>

        <?php if($ujian['stt_ujian'] == 'Belum Dimulai'): ?>
        <!-- card mapel jadwal otomatis belum dimulai-->
        <div class="rounded p-2 mb-2" style="background-color:whitesmoke;">
            <!-- title -->
            <div class="d-flex justify-content-between align-items-start">
                <div class="row align-items-center w-75  ml-1">
                    <div class="px-1 mr-2 mb-1 border rounded bg-warning">
                       <b><?= $ujian['kode_soal']; ?></b>
                    </div>
                    <small><?= $jenis_ujian['jenis_ujian']; ?></small>
                </div>
                <?php if($_SESSION['petugas'] == "admin") :?>
                <div class="d-flex p-2">
                    <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#del_soal<?= $id_jadwal; ?>">
                        <b class="icon-remove"></b>
                    </a>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- body -->
            <div class="row p-2 ml-2 justify-content-between align-items-center">
                <!-- mapel -->
                <div class="d-flex flex-column mb-1 col-sm-4">
                    <div style="font-weight: bold; font-size: 16pt;"><?= $mapel['nama_mapel']; ?></div>
                    <div>
                        <span class="mr-2">Kelas <?= $ujian['tingkat']; ?></span>
                        <?php while($jur = $jur_q->fetch_assoc()): ?>
                            <b class="icon-circle" style="color: <?= $jur['warna_jurusan']; ?>;"></b>
                        <?php endwhile; ?>
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="row col-sm-6">
                    <div class="d-flex flex-column align-items-center px-3">
                        <small>Mulai</small>
                        <b style="font-size: x-large;"><?php if($ujian['wk_mulai'] != "00:00:00"){echo $ujian['wk_mulai'];}else{echo "-";}  ?></b>
                    </div>
                    <div class="d-flex flex-column align-items-center px-3">
                        <small>Selesai</small>
                        <b style="font-size: x-large;"><?php if($ujian['wk_selesai'] != "00:00:00"){echo $ujian['wk_selesai'];}else{echo "-";}  ?></b>
                    </div>
                    <div class="d-flex flex-column align-items-center px-3">
                        <small>Durasi</small>
                        <b style="font-size: x-large;"><?= $ujian['durasi'];  ?></b>
                    </div>
                    <div class="d-flex flex-column align-items-center px-3">
                        <small>Siswa Selesai</small>
                        <b style="font-size: x-large;"><?= $jml_sw_selesai; ?>/<?= $jml_sw_all; ?></b>
                    </div>
                </div>

                <!-- tombol tindakan -->
                <div class="d-flex flex-column align-items-center col-sm-2 text-center">
                    <b class="text-secondary mb-1">Belum Dimulai</b>
                </div>
            </div>
        </div>

        <?php elseif($ujian['stt_ujian'] == 'Ujian Berlangsung'): ?>

        <!-- card mapel jadwal otomatis ujian berlangsung-->
        <div class="rounded p-2 mb-2 bg-success">
            <!-- title -->
            <div class="d-flex justify-content-between align-items-start">
                <div class="row align-items-center w-75  ml-1">
                    <div class="px-1 mr-2 mb-1 rounded bg-warning">
                       <b><?= $ujian['kode_soal']; ?></b>
                    </div>
                    <small class="text-white"><?= $jenis_ujian['jenis_ujian']; ?></small>
                </div>
                <?php if($_SESSION['petugas'] == "admin") :?>
                <div class="d-flex p-2">
                    <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#del_soal<?= $id_jadwal; ?>">
                        <b class="icon-remove"></b>
                    </a>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- body -->
            <div class="row p-2 ml-2 justify-content-between align-items-center">
                <!-- mapel -->
                <div class="d-flex flex-column mb-1 col-sm-4">
                    <div class="text-white" style="font-weight: bold; font-size: 16pt;"><?= $mapel['nama_mapel']; ?></div>
                    <div>
                        <span class="mr-2 text-white">Kelas <?= $ujian['tingkat']; ?></span>
                        <?php while($jur = $jur_q->fetch_assoc()): ?>
                            <b class="icon-circle" style="color: <?= $jur['warna_jurusan']; ?>;"></b>
                        <?php endwhile; ?>
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="row col-sm-6">
                    <div class="d-flex flex-column align-items-center px-3">
                        <small class="text-white">Mulai</small>
                        <b class="text-white" style="font-size: x-large;"><?php if($ujian['wk_mulai'] != "00:00:00"){echo $ujian['wk_mulai'];}else{echo "-";}  ?></b>
                    </div>
                    <div class="d-flex flex-column align-items-center px-3">
                        <small class="text-white">Selesai</small>
                        <b class="text-white" style="font-size: x-large;"><?php if($ujian['wk_selesai'] != "00:00:00"){echo $ujian['wk_selesai'];}else{echo "-";}  ?></b>
                    </div>
                    <div class="d-flex flex-column align-items-center px-3">
                        <small class="text-white">Durasi</small>
                        <b class="text-white" style="font-size: x-large;"><?= $ujian['durasi'];  ?></b>
                    </div>
                    <div class="d-flex flex-column align-items-center px-3">
                        <small class="text-white">Siswa Selesai</small>
                        <b class="text-white" style="font-size: x-large;"><?= $jml_sw_selesai; ?>/<?= $jml_sw_all; ?></b>
                    </div>
                </div>

                <!-- tombol tindakan -->
                <div class="d-flex flex-column align-items-center col-sm-2 text-center">
                    <b class="text-white mb-1">Ujian Berlangsung</b>
                </div>
                
            </div>
        </div>
        

        <?php elseif($ujian['stt_ujian'] == 'Ujian Selesai'): ?>

        <!-- card mapel jadwal otomatis ujian selesai-->
        <div class="rounded p-2 mb-2" style="background-color: AliceBlue;">
            <!-- title -->
            <div class="d-flex justify-content-between align-items-start">
                <div class="row align-items-center w-75 ml-1">
                    <div class="px-1 mr-2 mb-1 border rounded bg-warning">
                       <b><?= $ujian['kode_soal']; ?></b>
                    </div>
                    <small><?= $jenis_ujian['jenis_ujian']; ?></small>
                </div>
                <?php if($_SESSION['petugas'] == "admin") :?>
                <div class="d-flex p-2">
                    <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#del_soal<?= $id_jadwal; ?>">
                        <b class="icon-remove"></b>
                    </a>
                </div>
                <?php endif ;?>
            </div>
            
            <!-- body -->
            <div class="row p-2 ml-2 justify-content-between align-items-center">
                <!-- mapel -->
                <div class="d-flex flex-column mb-1 col-sm-4">
                    <div style="font-weight: bold; font-size: 16pt;"><?= $mapel['nama_mapel']; ?></div>
                    <div>
                        <span class="mr-2">Kelas <?= $ujian['tingkat']; ?></span>
                        <?php while($jur = $jur_q->fetch_assoc()): ?>
                            <b class="icon-circle" style="color: <?= $jur['warna_jurusan']; ?>;"></b>
                        <?php endwhile; ?>
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="row col-sm-6">
                    <div class="d-flex flex-column align-items-center px-3">
                        <small>Mulai</small>
                        <b style="font-size: x-large;"><?php if($ujian['wk_mulai'] != "00:00:00"){echo $ujian['wk_mulai'];}else{echo "-";}  ?></b>
                    </div>
                    <div class="d-flex flex-column align-items-center px-3">
                        <small>Selesai</small>
                        <b style="font-size: x-large;"><?php if($ujian['wk_selesai'] != "00:00:00"){echo $ujian['wk_selesai'];}else{echo "-";}  ?></b>
                    </div>
                    <div class="d-flex flex-column align-items-center px-3">
                        <small>Durasi</small>
                        <b style="font-size: x-large;"><?= $ujian['durasi'];  ?></b>
                    </div>
                    <div class="d-flex flex-column align-items-center px-3">
                        <small>Siswa Selesai</small>
                        <b style="font-size: x-large;"><?= $jml_sw_selesai; ?>/<?= $jml_sw_all; ?></b>
                    </div>
                </div>

                <!-- tombol tindakan -->
                <div class="d-flex flex-column align-items-center col-sm-2 text-center">
                    <b class="text-secondary mb-1">Ujian Selesai</b>
                </div>
            </div>
        </div>
        <?php endif; ?>

    <?php else: ?>
        <!-- JADWAL MANUAL -->
        <?php if($ujian['stt_ujian'] == 'Belum Dimulai'): ?>

        <!-- card mapel jadwal manual belum dimulai-->
        <div class="rounded p-2 mb-2" style="background-color:whitesmoke;">
            <!-- title -->
            <div class="d-flex justify-content-between align-items-start">
                <div class="row align-items-center w-75  ml-1">
                    <div class="px-1 mr-2 mb-1 border rounded bg-warning">
                       <b><?= $ujian['kode_soal']; ?></b>
                    </div>
                    <small><?= $jenis_ujian['jenis_ujian']; ?></small>
                </div>
                <?php if($_SESSION['petugas'] == "admin") :?>
                <div class="d-flex p-2">
                    <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#del_soal<?= $id_jadwal; ?>">
                        <b class="icon-remove"></b>
                    </a>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- body -->
            <div class="row p-2 ml-2 justify-content-between align-items-center">
                <!-- mapel -->
                <div class="d-flex flex-column mb-1 col-sm-4">
                    <div style="font-weight: bold; font-size: 16pt;"><?= $mapel['nama_mapel']; ?></div>
                    <div>
                        <span class="mr-2">Kelas <?= $ujian['tingkat']; ?></span>
                        <?php while($jur = $jur_q->fetch_assoc()): ?>
                            <b class="icon-circle" style="color: <?= $jur['warna_jurusan']; ?>;"></b>
                        <?php endwhile; ?>
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="row col-sm-6">
                    <div class="d-flex flex-column align-items-center px-3">
                        <small>Mulai</small>
                        <b style="font-size: x-large;"><?php if($ujian['wk_mulai'] != "00:00:00"){echo $ujian['wk_mulai'];}else{echo "-";}  ?></b>
                    </div>
                    <div class="d-flex flex-column align-items-center px-3">
                        <small>Selesai</small>
                        <b style="font-size: x-large;"><?php if($ujian['wk_selesai'] != "00:00:00"){echo $ujian['wk_selesai'];}else{echo "-";}  ?></b>
                    </div>
                    <div class="d-flex flex-column align-items-center px-3">
                        <small>Durasi</small>
                        <b style="font-size: x-large;"><?= $ujian['durasi'];  ?></b>
                    </div>
                    <div class="d-flex flex-column align-items-center px-3">
                        <small>Siswa Selesai</small>
                        <b style="font-size: x-large;"><?= $jml_sw_selesai; ?>/<?= $jml_sw_all; ?></b>
                    </div>
                </div>

                <!-- tombol tindakan -->
                <div class="d-flex flex-column align-items-center col-sm-2 text-center">
                    
                <form action="" method="POST">
                    <input type="hidden" name="id_jadwal" value="<?= $id_jadwal; ?>">
                    <b class="text-secondary mb-1">Belum Dimulai</b>
                    <?php if($_SESSION['petugas'] == "admin") :?>
                    <a href="#">
                        <button type="submit" name="mulai_now" class="btn btn-success" style="font-size: small;">Mulai Sekarang</button>
                    </a>
                    <?php endif; ?>
                </form>
                </div>
            </div>
        </div>
        
        <?php elseif($ujian['stt_ujian'] == 'Ujian Berlangsung'): ?>

        <!-- card mapel jadwal manual ujian berlangsung-->
        <div class="rounded p-2 mb-2 bg-success">
            <!-- title -->
            <div class="d-flex justify-content-between align-items-start">
                <div class="row align-items-center w-75  ml-1">
                    <div class="px-1 mr-2 mb-1 rounded bg-warning">
                       <b><?= $ujian['kode_soal']; ?></b>
                    </div>
                    <small class="text-white"><?= $jenis_ujian['jenis_ujian']; ?></small>
                </div>
                <?php if($_SESSION['petugas'] == "admin") :?>
                <div class="d-flex p-2">
                    <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#del_soal<?= $id_jadwal; ?>">
                        <b class="icon-remove"></b>
                    </a>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- body -->
            <div class="row p-2 ml-2 justify-content-between align-items-center">
                <!-- mapel -->
                <div class="d-flex flex-column mb-1 col-sm-4">
                    <div class="text-white" style="font-weight: bold; font-size: 16pt;"><?= $mapel['nama_mapel']; ?></div>
                    <div>
                        <span class="mr-2 text-white">Kelas <?= $ujian['tingkat']; ?></span>
                        <?php while($jur = $jur_q->fetch_assoc()): ?>
                            <b class="icon-circle" style="color: <?= $jur['warna_jurusan']; ?>;"></b>
                        <?php endwhile; ?>
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="row col-sm-6">
                    <div class="d-flex flex-column align-items-center px-3">
                        <small class="text-white">Mulai</small>
                        <b class="text-white" style="font-size: x-large;"><?php if($ujian['wk_mulai'] != "00:00:00"){echo $ujian['wk_mulai'];}else{echo "-";}  ?></b>
                    </div>
                    <div class="d-flex flex-column align-items-center px-3">
                        <small class="text-white">Selesai</small>
                        <b class="text-white" style="font-size: x-large;"><?php if($ujian['wk_selesai'] != "00:00:00"){echo $ujian['wk_selesai'];}else{echo "-";}  ?></b>
                    </div>
                    <div class="d-flex flex-column align-items-center px-3">
                        <small class="text-white">Durasi</small>
                        <b class="text-white" style="font-size: x-large;"><?= $ujian['durasi'];  ?></b>
                    </div>
                    <div class="d-flex flex-column align-items-center px-3">
                        <small class="text-white">Siswa Selesai</small>
                        <b class="text-white" style="font-size: x-large;"><?= $jml_sw_selesai; ?>/<?= $jml_sw_all; ?></b>
                    </div>
                </div>

                <!-- tombol tindakan -->
                <div class="d-flex flex-column align-items-center col-sm-2 text-center">
                <form action="" method="POST">
                    <input type="hidden" name="id_jadwal" value="<?= $id_jadwal; ?>">
                    <input type="hidden" name="kode_soal" value="<?= $kode_soal; ?>">
                    <b class="text-white mb-1">Ujian Berlangsung</b>
                    <?php if($_SESSION['petugas'] == "admin") :?>
                    <a href="#">
                        <button type="submit" name="akhiri_now" class="btn btn-danger" style="font-size: small;">Akhiri Sekarang</button>
                    </a>
                    <?php endif ;?>
                </form>
                </div>
                
            </div>
        </div>

        
        <?php elseif($ujian['stt_ujian'] == 'Ujian Selesai'): ?>

        <!-- card mapel jadwal manual ujian selesai-->
        <div class="rounded p-2 mb-2" style="background-color: AliceBlue;">
            <!-- title -->
            <div class="d-flex justify-content-between align-items-start">
                <div class="row align-items-center w-75 ml-1">
                    <div class="px-1 mr-2 mb-1 border rounded bg-warning">
                       <b><?= $ujian['kode_soal']; ?></b>
                    </div>
                    <small><?= $jenis_ujian['jenis_ujian']; ?></small>
                </div>
                <?php if($_SESSION['petugas'] == "admin") :?>
                <div class="d-flex p-2">
                    <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#del_soal<?= $id_jadwal; ?>">
                        <b class="icon-remove"></b>
                    </a>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- body -->
            <div class="row p-2 ml-2 justify-content-between align-items-center">
                <!-- mapel -->
                <div class="d-flex flex-column mb-1 col-sm-4">
                    <div style="font-weight: bold; font-size: 16pt;"><?= $mapel['nama_mapel']; ?></div>
                    <div>
                        <span class="mr-2">Kelas <?= $ujian['tingkat']; ?></span>
                        <?php while($jur = $jur_q->fetch_assoc()): ?>
                            <b class="icon-circle" style="color: <?= $jur['warna_jurusan']; ?>;"></b>
                        <?php endwhile; ?>
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="row col-sm-6">
                    <div class="d-flex flex-column align-items-center px-3">
                        <small>Mulai</small>
                        <b style="font-size: x-large;"><?php if($ujian['wk_mulai'] != "00:00:00"){echo $ujian['wk_mulai'];}else{echo "-";}  ?></b>
                    </div>
                    <div class="d-flex flex-column align-items-center px-3">
                        <small>Selesai</small>
                        <b style="font-size: x-large;"><?php if($ujian['wk_selesai'] != "00:00:00"){echo $ujian['wk_selesai'];}else{echo "-";}  ?></b>
                    </div>
                    <div class="d-flex flex-column align-items-center px-3">
                        <small>Durasi</small>
                        <b style="font-size: x-large;"><?= $ujian['durasi'];  ?></b>
                    </div>
                    <div class="d-flex flex-column align-items-center px-3">
                        <small>Siswa Selesai</small>
                        <b style="font-size: x-large;"><?= $jml_sw_selesai; ?>/<?= $jml_sw_all; ?></b>
                    </div>
                </div>

                <!-- tombol tindakan -->
                <div class="d-flex flex-column align-items-center col-sm-2 text-center">
                <form action="" method="POST">
                    <input type="hidden" name="id_jadwal" value="<?= $id_jadwal; ?>">
                    <input type="hidden" name="kode_soal" value="<?= $kode_soal; ?>">
                    <b class="text-secondary mb-1">Ujian Selesai</b>
                    <?php if($_SESSION['petugas'] == "admin") :?>
                    <a href="#">
                        <button type="submit" name="mulai_lagi" class="btn btn-info" style="font-size: small;">Mulai Lagi</button>
                    </a>
                    <?php endif; ?>
                </form>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <?php endif; ?>

        
            <!-- Modal hapus -->
            <div class="modal" tabindex="-1" role="dialog" id="del_soal<?= $id_jadwal; ?>">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Seriusan, hapus jadwal ini?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                <form action="" method="POST">
                    <input type="hidden" name="id_jadwal" value="<?= $id_jadwal; ?>">
                    <button type="submit" name="exc_del_jadwal" class="btn btn-danger">Hapus</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </form>
                </div>
                </div>
            </div>
            </div>

        <?php endwhile; ?>
    <?php else: ?>
        <div class="text-center">Tidak ada ujian hari ini</div>
    <?php endif; ?>
    </div>
</div>



