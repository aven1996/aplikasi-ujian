<div class="container py-3">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="text-info py-2" style="font-weight:bold;">Jadwal Ujian</h3>
        <div class="d-flex">
            <!-- <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#cari_jadwal">
                <b class="icon-search"></b>
            </a>  -->
            <?php if($_SESSION['petugas'] == "admin") :?>
            <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#tambah_jadwal">
                <b class="icon-plus"></b>
            </a> 
            <?php endif; ?>
        </div>
    </div> 
 
    <div class="pl-2 pt-2 pr-2 pb-0 border rounded mb-2 bg-white">
      <!-- looping jadwal -->
        <?php
            $jadwal_q = mysqli_query($conn, "SELECT * FROM tb_jadwal JOIN tb_soal ON tb_jadwal.kode_soal = tb_soal.kode_soal ORDER BY id_jadwal DESC");
            if(mysqli_num_rows($jadwal_q) > 0):
              while($jadwal = $jadwal_q->fetch_assoc()):
                  $id_jadwal = $jadwal['id_jadwal'];
                  $kode_soal = $jadwal['kode_soal'];
                  $q_soal = mysqli_query($conn, "SELECT * FROM tb_soal JOIN tb_guru_pengampu ON tb_soal.id_pengampu = tb_guru_pengampu.id_pengampu JOIN tb_jenis_ujian ON tb_soal.id_jenis_ujian = tb_jenis_ujian.id_jenis_ujian WHERE kode_soal = '$kode_soal'");
                  $sl = $q_soal->fetch_assoc();
                  $id_peng = $sl['id_pengampu'];
                  $peng_q = mysqli_query($conn, "SELECT * FROM tb_guru_pengampu JOIN tb_mapel ON tb_guru_pengampu.id_mapel = tb_mapel.id_mapel WHERE id_pengampu = '$id_peng'");
                  $peng = $peng_q->fetch_assoc();
        ?>
              <!-- card jadwal -->
              <div class="rounded p-2 mb-2" style="background-color:whitesmoke;">
                  <!-- title -->
                  <div class="d-flex justify-content-between align-items-start">
                      <div class="row align-items-center w-75  ml-1">
                          <div class="px-1 mr-2 mb-1 border rounded bg-warning">
                            <b><?= $jadwal['kode_soal']; ?></b>
                          </div>
                          <small><?= $sl['jenis_ujian']; ?></small>
                      </div>
                      <?php if($_SESSION['petugas'] == "admin") :?>
                      <div class="d-flex p-2">
                          <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#edit_jadwal<?= $id_jadwal; ?>">
                              <b class="icon-cog"></b>
                          </a>
                          <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#del_jadwal<?= $id_jadwal; ?>">
                              <b class="icon-remove"></b>
                          </a>
                      </div>
                      <?php endif; ?>
                  </div>
                  
                  <!-- body -->
                  <div class="row p-2 ml-2 justify-content-between align-items-center">
                      <!-- mapel -->
                      <div class="d-flex flex-column mb-1 col-sm-4">
                          <div style="font-weight: bold; font-size: 16pt;"><?= $peng['nama_mapel']; ?></div>
                          <div>
                              <span class="mr-2">Kelas <?= $peng['tingkat']; ?></span>
                              <!-- jurusan -->
                              <?php
                                  $jur_q = mysqli_query($conn, "SELECT * FROM tb_pengampu_jur JOIN tb_jurusan ON tb_pengampu_jur.kode_jurusan = tb_jurusan.kode_jurusan WHERE id_pengampu = '$id_peng'");
                                  while($jur = $jur_q->fetch_assoc()):
                              ?>
                              <b class="icon-circle" style="color: <?= $jur['warna_jurusan']; ?>;"></b>
                              <?php endwhile; ?>
                          </div>
                      </div>

                      <!-- Keterangan -->
                      <div class="row col-sm-6 align-items-center">
                          <div class="d-flex flex-column align-items-center px-3">
                              <small>Tanggal</small>
                              <b style="font-size: x-large;"><?php if($jadwal['tanggal'] != "0000-00-00"){echo $jadwal['tanggal'];}else{echo "-";} ?></b>
                          </div>
                          <div class="d-flex flex-column align-items-center px-3">
                              <small>Mulai</small>
                              <b style="font-size: x-large;"><?php if($jadwal['wk_mulai'] != "00:00:00"){echo $jadwal['wk_mulai'];}else{echo "-";} ?></b>
                          </div>
                          <div class="d-flex flex-column align-items-center px-3">
                              <small>Selesai</small>
                              <b style="font-size: x-large;"><?php if($jadwal['wk_selesai'] != "00:00:00"){echo $jadwal['wk_selesai'];}else{echo "-";} ?></b>
                          </div>
                          <div class="d-flex flex-column align-items-center px-3">
                              <small>Durasi</small>
                              <b style="font-size: x-large;"><?= $jadwal['durasi']; ?></b>
                          </div>
                      </div>

                      <!-- keterangan jenis jadwal -->
                      <div class="d-flex col-sm-2 justify-content-end">
                        <?php if($jadwal['tanggal'] != "0000-00-00"): ?>
                            <h2 class="icon-clock-o text-success display-6" title="Otomatis"></h2>
                        <?php else: ?>
                            <h2 class="icon-pencil-square text-danger display-6 mx-4" title="Manual"></h2>
                        <?php endif; ?>
                      </div>
                  </div>
              </div>

              <!-- Modal Edit Soal-->
              <div class="modal fade" id="edit_jadwal<?= $id_jadwal; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Edit Jadwal</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <form action="" method="POST">
                      <div class="modal-body">
                          <input type="hidden" name="id_jadwal" value="<?= $id_jadwal; ?>">
                          <input type="hidden" name="id_pengampu" value="<?= $id_peng; ?>">
                          <select name="mapel" id="" class="form-control mb-2">
                            <!-- looping data soal -->
                            <?php
                                // ambil nama mapel pada tabel pengampu
                                $mp_q_e = mysqli_query($conn, "SELECT * FROM tb_guru_pengampu JOIN tb_mapel ON tb_guru_pengampu.id_mapel = tb_mapel.id_mapel WHERE id_pengampu = '$id_peng'");
                                $mp_e = $mp_q_e->fetch_assoc();
                                $nama_mp_e = $mp_e['nama_mapel'];
                                
                            ?>
                              <option value="<?= $kode_soal; ?>"><?= $nama_mp_e; ?> - <?= $kode_soal; ?></option>
                          </select>

                          <select name="jenis_jadwal" id="handler<?= $id_jadwal; ?>" class="form-control mb-2" onchange="ganti_jenisJadwal('#tgl_wk<?= $id_jadwal; ?>','#handler<?= $id_jadwal; ?>')">
                              <option value="Otomatis" <?php if($jadwal['tanggal'] != "0000-00-00"){echo "selected";} ?>>Otomatis</option>
                              <option value="Manual" <?php if($jadwal['tanggal'] == "0000-00-00"){echo "selected";} ?>>Manual</option>
                          </select>
                          <div id="tgl_wk<?= $id_jadwal; ?>">
                            <input type="date" name="tanggal" class="form-control mb-2" value="<?= $jadwal['tanggal']; ?>">
                            <input type="time" name="wk_mulai" class="form-control mb-2" value="<?= $jadwal['wk_mulai']; ?>">
                            <input type="time" name="wk_selesai" class="form-control mb-2" value="<?= $jadwal['wk_selesai']; ?>">
                          </div>
                          <input value="<?= $jadwal['durasi']; ?>" type="text" name="durasi" class="form-control" placeholder="Durasi (satuan menit)" required>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                          <button type="submit" name="exc_edit_jadwal" class="btn btn-info">Simpan Perubahan</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>


              <!-- Modal hapus -->
              <div class="modal" tabindex="-1" role="dialog" id="del_jadwal<?= $id_jadwal; ?>">
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
              <div class="p-3 text-center mb-2" style="background-color: whitesmoke;">Data tidak ada</div>
          <?php endif; ?>

    </div>
</div>




<!-- MODAL -->
<!-- Modal Tambah Soal-->
<div class="modal fade" id="tambah_jadwal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Jadwal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST">
        <div class="modal-body">
            
            <select name="mapel" id="" class="form-control mb-2">
              <!-- looping data soal -->
              <?php
                  $soal_q = mysqli_query($conn, "SELECT * FROM tb_soal JOIN tb_guru_pengampu ON tb_soal.id_pengampu = tb_guru_pengampu.id_pengampu");
                  if(mysqli_num_rows($soal_q) > 0):
                    while($s = $soal_q->fetch_assoc()):
                      $id_pengampu = $s['id_pengampu'];
                      $kode_soal = $s['kode_soal'];
                      // ambil nama mapel pada tabel pengampu
                      $mp_q = mysqli_query($conn, "SELECT * FROM tb_guru_pengampu JOIN tb_mapel ON tb_guru_pengampu.id_mapel = tb_mapel.id_mapel WHERE id_pengampu = '$id_pengampu'");
                      $mp = $mp_q->fetch_assoc();
                      $nama_mp = $mp['nama_mapel'];
              ?>
                <option value="<?= $kode_soal; ?>"><?= $nama_mp; ?> - <?= $kode_soal; ?></option>
              <?php
                    endwhile;
                  else:
              ?>
                <option value="">Data tidak ada</option>
              <?php endif; ?>
            </select>
            <select name="jenis_jadwal" id="handler" class="form-control mb-2" onchange="ganti_jenisJadwal('#tgl_wk','#handler')">
                <option value="Otomatis">Otomatis</option>
                <option value="Manual">Manual</option>
            </select>
            <div id="tgl_wk">
              <input type="date" name="tanggal" class="form-control mb-2">
              <input type="time" name="wk_mulai" class="form-control mb-2">
              <input type="time" name="wk_selesai" class="form-control mb-2">
            </div>
            <input type="text" name="durasi" class="form-control" placeholder="Durasi (satuan menit)" required>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" name="exc_add_jadwal" class="btn btn-info">Tambah</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Cari Jadwal-->
<div class="modal fade" id="cari_jadwal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cari Jadwal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="">
        <div class="modal-body">
            <input type="text" class="form-control mb-2" placeholder="Cari Jadwal" required>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" name="exc_cari_jadwal" class="btn btn-info">Cari</button>
        </div>
      </form>
    </div>
  </div>
</div>


