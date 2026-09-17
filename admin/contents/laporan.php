<div class="container py-3">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="text-info py-2" style="font-weight:bold;">Laporan</h3>
        <div class="d-flex">
            <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#cari_lap">
                <b class="icon-search"></b>
            </a>
        </div>
    </div> 
    <div class="pl-2 pt-2 pr-2 pb-0 border rounded mb-2 bg-white">
    <?php 
        // ambil data laporan join kode soal
        $lap_q = $conn->query("SELECT * FROM tb_laporan JOIN tb_soal ON tb_laporan.kode_soal = tb_soal.kode_soal JOIN tb_guru_pengampu ON tb_laporan.id_pengampu = tb_guru_pengampu.id_pengampu JOIN tb_mapel ON tb_laporan.id_mapel = tb_mapel.id_mapel $cari");
        if(mysqli_num_rows($lap_q)):
            while($lap = $lap_q->fetch_assoc()):
                $kode_soal = $lap['kode_soal'];
        ?>
        <!-- card mapel -->
        <div class="rounded p-2 mb-2" style="background-color:whitesmoke;">
            <!-- title -->
            <div class="d-flex justify-content-between align-items-start">
                <div class="row align-items-center w-75  ml-1">
                    <div class="px-1 mr-2 mb-1 border rounded bg-warning">
                       <b><?= $kode_soal; ?></b>
                    </div>
                    <small>
                        <?php
                            $soal_q = $conn->query("SELECT * FROM tb_soal JOIN tb_jenis_ujian ON tb_soal.id_jenis_ujian = tb_jenis_ujian.id_jenis_ujian WHERE tb_soal.kode_soal = '$kode_soal'");
                            $soal = $soal_q->fetch_assoc();
                            echo $soal['jenis_ujian'];
                        ?>
                    </small>
                </div>
                <div class="d-flex p-2">
                    <a href="cetak_laporan.php?kode=<?= $kode_soal; ?>" target="blank" class="icon-sm px-2" style="text-decoration: none;">
                        <b class="icon-print"></b>
                    </a>
                    <a href="excel_laporan.php?kode=<?= $kode_soal; ?>" target="blank" class="icon-sm px-2" style="text-decoration: none;">
                        <b class="icon-file-excel-o"></b>
                    </a>
                    <?php if($_SESSION['petugas'] == "admin"): ?>
                    <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#del_lap<?= $kode_soal; ?>">
                        <b class="icon-remove"></b>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- body -->
            <div class="row p-2 ml-2 justify-content-between align-items-center">
                <!-- mapel -->
                <div class="d-flex flex-column mb-1 col-sm-5">
                    <div style="font-weight: bold; font-size: 16pt;"><?= $lap['nama_mapel']; ?></div>
                    <div>
                        <span class="mr-2">Kelas <?= $lap['tingkat']; ?></span>
                        <?php
                            // ambil jurusan berdasarkan id pengampu
                            $id_peng = $lap['id_pengampu'];
                            $jur_peng_q = $conn->query("SELECT * FROM tb_pengampu_jur JOIN tb_jurusan ON tb_pengampu_jur.kode_jurusan = tb_jurusan.kode_jurusan WHERE id_pengampu = '$id_peng'");
                            while($jur = $jur_peng_q->fetch_assoc()):
                        ?>
                            <b class="icon-circle" title="<?= $jur['nama_jurusan']; ?>" style="color: <?= $jur['warna_jurusan']; ?>;"></b>
                        <?php endwhile; ?>
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="row align-items-center col-sm-5">
                    <div class="d-flex flex-column align-items-center px-3">
                        <small>Tanggal</small>
                        <b style="font-size: x-large;"><?= $lap['tgl_update']; ?></b>
                    </div>
                    <div class="d-flex flex-column align-items-center px-3">
                        <small>Siswa</small>
                        <b style="font-size: x-large;">
                            <?php 
                                // cek dulu apkah soal pdf atau bukan
                                $soal_pdf = $conn->query("SELECT * FROM tb_butir_pdf WHERE kode_soal = '$kode_soal'");
                                if(mysqli_num_rows($soal_pdf) > 0){
                                    // hitung jml siswa yang sudah menjawab
                                    $jwb_q = $conn->query("SELECT kode_soal FROM tb_jawaban_pdf GROUP BY nomor_peserta HAVING kode_soal = '$kode_soal'");
                                    echo mysqli_num_rows($jwb_q);
                                }else{
                                    $jwb_q = $conn->query("SELECT kode_soal FROM tb_jawaban GROUP BY nomor_peserta HAVING kode_soal = '$kode_soal'");
                                    echo mysqli_num_rows($jwb_q);
                                    
                                }
                            ?>
                        </b>
                    </div>
                    <?php if($_SESSION['petugas'] == "admin"): ?>
                    <div id="set-balance<?= $kode_soal; ?>" class="d-flex flex-column align-items-center px-3" title="Hitung Nilai Akhir" onclick="set_balance('<?= $kode_soal; ?>');">
                        <?php if($lap['set_balance'] == "Ya"): ?>
                            <h2 class="icon-balance-scale text-danger"></h2>
                        <?php else: ?>
                            <h2 class="icon-balance-scale text-secondary"></h2>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Tindakan -->
                <a href="?cnt=laporan_detil&kode=<?= $kode_soal; ?>" class="col-sm-2 text-right">
                    <button type="button" class="btn btn-info" style="font-size: small;">Lihat Detil</button>
                </a>
            </div>
        </div>


        <!-- Modal hapus -->
        <div class="modal" tabindex="-1" role="dialog" id="del_lap<?= $kode_soal; ?>">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Seriusan, hapus laporan ini?</h5>
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
            <div class="p-3 text-center">Data tidak ada</div>
        <?php endif; ?>

       

    </div>
</div>




<!-- MODAL -->
<!-- Modal Cari Berita Acara-->
<div class="modal fade" id="cari_lap" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cari Laporan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST">
        <div class="modal-body">
            <input type="text" class="form-control mb-2" name="mapel" placeholder="Cari nama mapel" required>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" name="exc_cari_ba" class="btn btn-info">Cari</button>
        </div>
      </form>
    </div>
  </div>
</div>


