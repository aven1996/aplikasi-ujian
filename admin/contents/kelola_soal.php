<div class="container py-3">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="text-info py-2" style="font-weight:bold;">Kelola Soal</h3>
        <div class="d-flex">
            <!-- <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#cari_soal">
                <b class="icon-search"></b>
            </a>  -->
            <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#tambah_soal">
                <b class="icon-plus"></b>
            </a> 
        </div> 
    </div>

    <div class="pl-2 pt-2 pr-2 pb-0 border rounded mb-2 bg-white">
      <?php 
          if($_SESSION['petugas'] == "guru"){
            $id_ptg = $_SESSION['id_ptg'];
            $q_soal = mysqli_query($conn, "SELECT * FROM tb_soal JOIN tb_guru_pengampu ON tb_soal.id_pengampu = tb_guru_pengampu.id_pengampu JOIN tb_jenis_ujian ON tb_soal.id_jenis_ujian = tb_jenis_ujian.id_jenis_ujian WHERE tb_guru_pengampu.id_guru = '$id_ptg' ");
          }else{
            $id_ptg = $_SESSION['id_ptg'];
            $q_soal = mysqli_query($conn, "SELECT * FROM tb_soal JOIN tb_guru_pengampu ON tb_soal.id_pengampu = tb_guru_pengampu.id_pengampu JOIN tb_jenis_ujian ON tb_soal.id_jenis_ujian = tb_jenis_ujian.id_jenis_ujian");
          }
          if(mysqli_num_rows($q_soal) > 0):
            while($soal =$q_soal->fetch_assoc()):
              $id_pengampu = $soal['id_pengampu'];
              $kode_soal = $soal['kode_soal'];
      ?>
        <!-- card mapel -->
        <div class="rounded p-2 mb-2" style="background-color:whitesmoke;">
            <!-- title -->
            <div class="d-flex justify-content-between align-items-start">
                <div class="row align-items-center w-75  ml-1">
                    <div class="px-1 mr-2 mb-1 border rounded bg-warning">
                       <b><?= $soal['kode_soal']; ?></b>
                    </div>
                    <small><?= $soal['jenis_ujian']; ?></small>
                </div>
                <div class="d-flex p-2">
                    <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#edit_soal<?= $soal['kode_soal']; ?>">
                        <b class="icon-cog"></b>
                    </a>
                    <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#del_soal<?= $soal['kode_soal']; ?>">
                        <b class="icon-remove"></b>
                    </a>
                </div>
            </div>
            
            <!-- body -->
            <div class="row p-2 ml-2 justify-content-between align-items-center ">
                <!-- mapel -->
                <?php
                    $pengampu_q = mysqli_query($conn, "SELECT * FROM tb_guru_pengampu JOIN tb_mapel ON tb_guru_pengampu.id_mapel = tb_mapel.id_mapel WHERE id_pengampu = '$id_pengampu'");
                    $pengampu = $pengampu_q->fetch_assoc();
                ?>
                <div class="d-flex flex-column mb-1 col-sm-4">
                    <div style="font-weight: bold; font-size: 16pt;"><?= $pengampu['nama_mapel']; ?></div>
                    <div>
                        <span class="mr-2">Kelas <?= $pengampu['tingkat']; ?></span>
                        <!-- jurusan -->
                        <?php
                          $jur_query = mysqli_query($conn, "SELECT * FROM tb_pengampu_jur JOIN tb_jurusan ON tb_pengampu_jur.kode_jurusan = tb_jurusan.kode_jurusan WHERE id_pengampu = '$id_pengampu'");
                          while($j = $jur_query->fetch_assoc()):
                        ?>
                        <b class="icon-circle" style="color: <?= $j['warna_jurusan']; ?>;"></b>
                        <?php endwhile; ?>
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="d-flex col-sm-4 my-2">
                    <div class="d-flex flex-column align-items-center px-3">
                        <small>Pertanyaan</small>
                        <b class="<?php if($soal['acak_pertanyaan'] == "Ya"){echo "icon-shuffle";}else{echo "icon-sort-numeric-asc";} ?>" style="font-size: xx-large;"></b>
                    </div>
                    <div class="d-flex flex-column align-items-center px-3">
                        <small>Opsi</small>
                        <b class="<?php if($soal['acak_opsi'] == "Ya"){echo "icon-shuffle";}else{echo "icon-sort-numeric-asc";} ?>" style="font-size: xx-large;"></b>
                    </div>
                    <div class="d-flex flex-column align-items-center px-3">
                        <small>Butir Soal</small>
                        
                        <?php 
                          $pdf_q = mysqli_query($conn, "SELECT * FROM tb_butir_pdf WHERE kode_soal = '$kode_soal'");
                          if(mysqli_num_rows($pdf_q) > 0):
                        ?>
                            <b class="icon-file-pdf-o" style="font-size: xx-large; line-height:28pt; "></b>
                        <?php else: ?>
                            <b style="font-size: xx-large; line-height:28pt; ">
                            <?= jmlRowsById("tb_pertanyaan","kode_soal","$kode_soal"); ?></b>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- tombol tindakan -->
                <a href="?cnt=soal_butir&id=<?= $soal['kode_soal']; ?>" class="col-sm-4 text-center">
                    <button type="button" class="btn btn-info">Tambah Butir Soal</button>
                </a>
            </div>
        </div>


        <!-- Form Edit Soal-->
        <div class="modal fade" id="edit_soal<?= $soal['kode_soal']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Soal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <form action="" method="POST">
                    <div class="modal-body">
                      <!-- ambil nama mapel -->
                        <?php
                            $peng_q = mysqli_query($conn, "SELECT * FROM tb_guru_pengampu JOIN tb_mapel ON tb_guru_pengampu.id_mapel = tb_mapel.id_mapel WHERE id_pengampu = '$id_pengampu'");
                            $mpl = $peng_q->fetch_assoc();
                        ?> 
                        <input type="hidden" name="kode_soal_lama" id="" value="<?= $soal['kode_soal']; ?>">
                        <h5><?= $mpl['nama_mapel']; ?></h5>
                        <select name="jenis_ujian" id="" class="form-control mb-2">
                            <?php
                              $q_jenis_uj = mysqli_query($conn, "SELECT * FROM tb_jenis_ujian");
                              if(mysqli_num_rows($q_jenis_uj)):
                                while($uj = $q_jenis_uj->fetch_assoc()):
                            ?>
                            <option value="<?= $uj['id_jenis_ujian']; ?>" <?php if($uj['id_jenis_ujian'] == $soal['id_jenis_ujian']){echo "selected";} ?>><?= $uj['jenis_ujian']; ?> (<?= $uj['tahun_ajaran']; ?>)</option>
                            <?php endwhile; ?>
                            <?php else: ?>
                              <option value="">Tidak ada jenis ujian</option>
                            <?php endif; ?>
                        </select>
                        <div class="position-relative">
                          <b class="btn btn-warning position-absolute" style="right:0;" title="Isi Otomatis" onclick="randomSoal(3,'kode_soal<?= $soal['kode_soal']; ?>');">Generate</b>
                          <input value="<?= $soal['kode_soal']; ?>" name="kode_soal_baru" type="text" class="form-control mb-2" placeholder="Kode Soal" id="kode_soal<?= $soal['kode_soal']; ?>" required>
                        </div>
                        <select name="acak_pertanyaan" id="" class="form-control mb-2">
                            <option value="Ya" <?php if($soal['acak_pertanyaan'] == "Ya"){echo "selected";} ?>>Ya Acak Pertanyaan</option>
                            <option value="Tidak" <?php if($soal['acak_pertanyaan'] == "Tidak"){echo "selected";} ?>>Tidak Acak Pertanyaan</option>
                        </select>
                        <select name="acak_opsi" id="" class="form-control mb-2">
                            <option value="Ya" <?php if($soal['acak_opsi'] == "Ya"){echo "selected";} ?>>Ya Acak Opsi</option>
                            <option value="Tidak" <?php if($soal['acak_opsi'] == "Tidak"){echo "selected";} ?>>Tidak Acak Opsi</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" name="exc_edit_soal" class="btn btn-info">Simpan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

            
          <!-- Modal hapus -->
          <div class="modal" tabindex="-1" role="dialog" id="del_soal<?= $soal['kode_soal']; ?>">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Seriusan, hapus soal ini?</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-footer">
                  <form action="" method="POST">
                      <input type="hidden" name="kode_soal" value="<?= $soal['kode_soal']; ?>">
                      <button type="submit" name="exc_del_soal" class="btn btn-danger">Hapus</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                  </form>
                </div>
              </div>
            </div>
          </div>


        <?php endwhile; ?>
        <?php else: ?>

          <div class="text-center">Tidak ada data</div>
        <?php endif; ?>

    </div>
</div>




<!-- MODAL -->
<!-- Pilih Mapel-->
<div class="modal fade" id="tambah_soal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pilih Mata Pelajaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="position-relative p-3">
          <b class="icon-search text-secondary position-absolute" style="top: 27px; left: 25px;"></b>
          <input type="text" class="form-control" id="cari_mapel" placeholder="cari nama mapel" style="padding-left: 30px;">
        </div>
        <div class="modal-body row w-100 m-auto pt-0" id="cov-card-mapel">
          <?php
            if($_SESSION['petugas'] == "admin"):
              $q_mapel = mysqli_query($conn, "SELECT * FROM tb_guru_pengampu JOIN tb_mapel ON tb_guru_pengampu.id_mapel = tb_mapel.id_mapel JOIN tb_guru ON tb_guru_pengampu.id_guru = tb_guru.id_guru");
            else:
              $user_ptg = $_SESSION['user'];
              $q_mapel = mysqli_query($conn, "SELECT * FROM tb_guru_pengampu JOIN tb_mapel ON tb_guru_pengampu.id_mapel = tb_mapel.id_mapel JOIN tb_guru ON tb_guru_pengampu.id_guru = tb_guru.id_guru WHERE username_guru = '$user_ptg'");
            endif;
            if(mysqli_num_rows($q_mapel) > 0):
              while($mp = $q_mapel->fetch_assoc()):
          ?>
            <!-- card mapel -->
            <div class="col-sm-6 p-1">
                <div class="card-mapel border p-2 rounded" data-toggle="modal" data-target="#isi_form_tambah_soal<?= $mp['id_pengampu']; ?>">
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
                <span class="d-block" style="font-size: small;"><?= $mp['nama_guru']; ?></span>
                </div>
            </div>


            <!-- Form Tambah Soal-->
            <div class="modal fade" id="isi_form_tambah_soal<?= $mp['id_pengampu']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Soal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <form action="" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id_pengampu" id="" value="<?= $mp['id_pengampu']; ?>">
                        <h5><?= $mp['nama_mapel']; ?></h5>
                        <select name="jenis_ujian" id="" class="form-control mb-2">
                            <?php
                              $q_jenis_uj = mysqli_query($conn, "SELECT * FROM tb_jenis_ujian");
                              if(mysqli_num_rows($q_jenis_uj)):
                                while($uj = $q_jenis_uj->fetch_assoc()):
                            ?>
                            <option value="<?= $uj['id_jenis_ujian']; ?>"><?= $uj['jenis_ujian']; ?> (<?= $uj['tahun_ajaran']; ?>)</option>
                            <?php endwhile; ?>
                            <?php else: ?>
                              <option value="">Tidak ada jenis ujian</option>
                            <?php endif; ?>
                        </select>
                        <div class="position-relative">
                          <b class="btn btn-warning position-absolute" style="right:0;" title="Isi Otomatis" onclick="randomSoal(3,'kode_soal<?= $mp['id_pengampu']; ?>');">Generate</b>
                          <input name="kode_soal" type="text" class="form-control mb-2" placeholder="Kode Soal" id="kode_soal<?= $mp['id_pengampu']; ?>" required>
                        </div>
                        <select name="acak_pertanyaan" id="" class="form-control mb-2">
                            <option value="Ya">Ya Acak Pertanyaan</option>
                            <option value="Tidak">Tidak Acak Pertanyaan</option>
                        </select>
                        <select name="acak_opsi" id="" class="form-control mb-2">
                            <option value="Ya">Ya Acak Opsi</option>
                            <option value="Tidak">Tidak Acak Opsi</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" name="exc_add_soal" class="btn btn-info">Simpan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <?php endwhile; ?>
            <?php else: ?>
              <div>Data mapel tidak ada</div>
            <?php endif; ?>
        </div>
    </div>
  </div>
</div>


<!-- Modal Cari Soal-->
<div class="modal fade" id="cari_soal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cari Soal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST">
        <div class="modal-body">
            <input type="text" name="cari" class="form-control mb-2" placeholder="Cari Soal" required>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" name="exc_cari_soal" class="btn btn-info">Cari</button>
        </div>
      </form>
    </div>
  </div>
</div>

