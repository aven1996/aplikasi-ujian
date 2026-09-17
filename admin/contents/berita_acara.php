<div class="container py-3">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="text-info py-2" style="font-weight:bold;">Berita Acara</h3>
        <!-- <div class="d-flex">
            <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#cari_ba">
                <b class="icon-search"></b>
            </a>
        </div> -->
    </div>  

    <div class="pl-2 pt-2 pr-2 pb-0 border rounded mb-2 bg-white">
        <?php 
        // ambil data berita acara join soal
        $ba_q = $conn->query("SELECT * FROM tb_berita_acara JOIN tb_soal ON tb_berita_acara.kode_soal = tb_soal.kode_soal");
        if(mysqli_num_rows($ba_q)):
            while($ba = $ba_q->fetch_assoc()):
                // ambil data pengampu yang ada di tb soal berdasarkan kode soal
                $kode_soal = $ba['kode_soal'];
                $soal_q = $conn->query("SELECT * FROM tb_soal JOIN tb_guru_pengampu ON tb_soal.id_pengampu = tb_guru_pengampu.id_pengampu JOIN tb_jenis_ujian ON tb_soal.id_jenis_ujian = tb_jenis_ujian.id_jenis_ujian WHERE kode_soal = '$kode_soal'");
                $soal = $soal_q->fetch_assoc();
                $id_peng = $soal['id_pengampu'];

                // ambil data mapel yang ada di tb guru pengampu berdasarkan id pengampu
                $peng_q = $conn->query("SELECT * FROM tb_guru_pengampu JOIN tb_mapel ON tb_guru_pengampu.id_mapel = tb_mapel.id_mapel JOIN tb_guru ON tb_guru_pengampu.id_guru = tb_guru.id_guru WHERE tb_guru_pengampu.id_pengampu = '$id_peng'");
                $peng = $peng_q->fetch_assoc();
                $nama_mapel = $peng['nama_mapel'];
        ?>
        <!-- card mapel -->
        <div class="rounded p-2 mb-2" style="background-color:whitesmoke;">
            <!-- title -->
            <div class="d-flex justify-content-between align-items-start">
                <div class="row align-items-center w-75  ml-1">
                    <div class="px-1 mr-2 mb-1 border rounded bg-warning">
                       <b><?= $kode_soal; ?></b>
                    </div>
                    <small><?= $soal['jenis_ujian']; ?></small>
                </div>
                <div class="d-flex p-2">
                    <a href="cetak_ba.php?kode=<?= $kode_soal; ?>" target="blank" class="icon-sm px-2" style="text-decoration: none;">
                        <b class="icon-print"></b>
                    </a>
                    <!-- validasi petugas admin yang hanya bisa akses tool ini -->
                    <?php if($_SESSION['petugas'] == "admin"): ?>
                    <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#edit_ba<?= $kode_soal; ?>">
                        <b class="icon-cog"></b>
                    </a>
                    <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#del_ba<?= $kode_soal; ?>">
                        <b class="icon-remove"></b>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- body -->
            <div class="row p-2 ml-2 justify-content-between align-items-center">
                <!-- mapel -->
                <div class="d-flex flex-column mb-1 col-sm-4">
                    <div style="font-weight: bold; font-size: 16pt;"><?= $nama_mapel; ?></div>
                    <div>
                        <span class="mr-2">Kelas <?= $peng['tingkat']; ?></span>
                        <?php
                            // ambil jurusan berdasarkan id pengampu
                            $jur_peng_q = $conn->query("SELECT * FROM tb_pengampu_jur JOIN tb_jurusan ON tb_pengampu_jur.kode_jurusan = tb_jurusan.kode_jurusan WHERE id_pengampu = '$id_peng'");
                            while($jur = $jur_peng_q->fetch_assoc()):
                        ?>
                            <b class="icon-circle" title="<?= $jur['nama_jurusan']; ?>" style="color: <?= $jur['warna_jurusan']; ?>;"></b>
                        <?php endwhile; ?>
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="row col-sm-5 justify-content-between">
                    <div class="d-flex flex-column align-items-center px-3">
                        <small>Tanggal</small>
                        <b style="font-size: large;"><?= $ba['tanggal']; ?></b>
                    </div>
                    <div class="d-flex flex-column align-items-center px-3">
                        <small>Guru Pengampu</small>
                        <b style="font-size: large;"><?= substr($peng['nama_guru'],0,15)."..."; ?></b>
                    </div>
                    <div class="d-flex flex-column align-items-center px-3">
                        <small>Absen</small>
                        <b style="font-size: large;">
                                <!-- cari jumlah siswa absen -->
                                <?php
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

                                    echo count($siswa_absen);
                                ?>
                        </b>
                    </div>
                </div> 

                <!-- keterangan jenis jadwal -->
                <a href="?cnt=siswa_absen&kode=<?= $kode_soal; ?>" class="col-sm-3 text-right">
                    <button type="button" class="btn btn-danger" style="font-size: small;">Lihat Siswa Absen</button>
                </a>
            </div>
        </div>


        <!-- Modal Edit Berita Acara-->
        <div class="modal fade" id="edit_ba<?= $kode_soal; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Berita Acara</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                <input type="hidden" name="kode_soal" value="<?= $kode_soal; ?>">
                <div class="modal-body">
                    <div class="mb-2 px-2">
                        <h4 style="font-weight: bold;"><?= $nama_mapel; ?></h4>
                        <span>Kelas <?= $peng['tingkat']; ?></span>
                        <?php
                            // ambil jurusan berdasarkan id pengampu
                            $jur_peng_qx = $conn->query("SELECT * FROM tb_pengampu_jur JOIN tb_jurusan ON tb_pengampu_jur.kode_jurusan = tb_jurusan.kode_jurusan WHERE id_pengampu = '$id_peng'");
                            while($jurx = $jur_peng_qx->fetch_assoc()):
                        ?>
                            <b class="icon-circle" title="<?= $jurx['nama_jurusan']; ?>" style="color: <?= $jurx['warna_jurusan']; ?>;"></b>
                        <?php endwhile; ?>
                    </div>
                    <input type="date" name="tanggal" class="form-control mb-2" value="<?= $ba['tanggal']; ?>">
                    <input type="time" name="wk_mulai" class="form-control mb-2" value="<?= $ba['wk_mulai']; ?>">
                    <input type="time" name="wk_selesai" class="form-control mb-2" value="<?= $ba['wk_selesai']; ?>">
                    <textarea name="catatan" id="" cols="20" rows="5" class="form-control" placeholder="Catatan selama ujian"><?= $ba['catatan']; ?></textarea>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" name="exc_edit_ba" class="btn btn-info">Simpan Perubahan</button>
                </div>
            </form>
            </div>
        </div>
        </div>

        <!-- Modal hapus -->
        <div class="modal" tabindex="-1" role="dialog" id="del_ba<?= $kode_soal; ?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Seriusan, hapus ini?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-footer">
            <form action="" method="POST">
                <input type="hidden" name="kode_soal" value="<?= $kode_soal; ?>">
                <button type="submit" name="exc_del_ba" class="btn btn-danger">Hapus</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </form>
            </div>
            </div>
        </div>
        </div>

        <?php endwhile; ?>
        <?php else: ?>
            <div class="text-center p-3">Data tidak ada</div>
        <?php endif; ?>

        

    </div>
</div>




<!-- MODAL -->

<!-- Modal Cari Berita Acara-->
<div class="modal fade" id="cari_ba" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cari Berita Acara</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="">
        <div class="modal-body">
            <input type="text" class="form-control mb-2" placeholder="cari apa?" required>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" name="exc_cari_ba" class="btn btn-info">Cari</button>
        </div>
      </form>
    </div>
  </div>
</div>


