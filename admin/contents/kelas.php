<!-- JURUSAN -->

<div class="container py-3">
    <h3 class="text-info py-2" style="font-weight:bold;">Kelas</h3>

    <div class="pl-2 pt-2 pr-2 pb-0 border rounded mb-2 bg-white">
      <!-- header -->
        <div class="d-flex justify-content-between mb-2">
            <h6 class="text-info" style="font-weight: bold;">Jurusan</h6>
            <div class="d-flex">
                <a href="#" class="icon-sm bg-white px-2" style="text-decoration: none;" data-toggle="modal" data-target="#tambah_jur">
                    <b class="icon-plus"></b>
                </a>
            </div>
        </div>

        <!-- ISI JURUSAN -->
        <?php 
          // ambil data jurusan
          $query_jur = mysqli_query($conn, "SELECT * FROM tb_jurusan");
        ?>
        <!-- looping -->
        <?php if(mysqli_num_rows($query_jur) > 0): ?>
        <?php while ($jur = $query_jur->fetch_assoc()) :?>
          <!-- isi data -->
          <div class="card-jur d-flex justify-content-between p-2 rounded" style="background-color: whitesmoke;">
              <b><b class="icon-circle" style="color: <?= $jur['warna_jurusan']; ?>;"></b> <?= $jur['nama_jurusan']; ?> ( <?= $jur['kode_jurusan']; ?> )</b>
              <div class="d-flex">
                  <a href="?cnt=kelas&id=" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#edit_jur<?= $jur['kode_jurusan']; ?>">
                      <b class="icon-cog"></b>
                  </a>
                  <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#del_jur<?= $jur['kode_jurusan']; ?>">
                      <b class="icon-remove"></b>
                  </a>
              </div>
          </div>
          <!-- modal edit -->
          <!-- Modal Edit Jurusan-->
          <div class="modal fade" id="edit_jur<?= $jur['kode_jurusan']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Edit Jurusan</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="" method="POST">
                  <div class="modal-body">
                      <input value="<?= $jur['kode_jurusan']; ?>" name="kode_jur" type="hidden" class="form-control mb-2" placeholder="Kode Jurusan" required>
                      <input value="<?= $jur['nama_jurusan']; ?>" name="nama_jur" type="text" class="form-control mb-2" placeholder="Nama Jurusan" onfocus="" required>
                      <label for="" class="pl-3">Warna icon</label>
                      <input name="warna_jur" type="color" value="<?= $jur['warna_jurusan']; ?>">
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                      <button type="submit" name="exc_edit_jur" class="btn btn-info">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Modal hapus -->
          <div class="modal" tabindex="-1" role="dialog" id="del_jur<?= $jur['kode_jurusan']; ?>">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Seriusan, hapus jurusan ini?</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-footer">
                  <form action="" method="POST">
                    <input value="<?= $jur['kode_jurusan']; ?>" name="kode_jur" type="hidden" class="form-control mb-2">
                    <button type="submit" name="exc_del_jur" class="btn btn-danger">Hapus</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                  </form>
                </div>
              </div>
            </div>
          </div>

        <?php endwhile; ?>
        <?php else: ?>
          <div class="text-center py-3 text-secondary">Data tidak ada</div>

        <?php endif; ?>
        
    </div>
</div>



<!-- KELAS -->
<div class="container py-3">
    <div class="pl-2 pt-2 pr-2 pb-0 border rounded mb-2 bg-white">

        <div class="d-flex justify-content-between mb-2">
            <h6 class="text-info" style="font-weight: bold;">Kelas</h6>
            <div class="d-flex">
                <a href="#" class="icon-sm bg-white px-2" style="text-decoration: none;" data-toggle="modal" data-target="#tambah_kls">
                    <b class="icon-plus"></b>
                </a>
            </div>
        </div>

        <!-- ISI KELAS -->
        <?php 
          // ambil data jurusan
          $jur_kel = mysqli_query($conn, "SELECT * FROM tb_jurusan");
        ?>
        <?php if(mysqli_num_rows($jur_kel) > 0): 
              while($jr = $jur_kel->fetch_assoc()):
                $kodejur = $jr['kode_jurusan'];
                 
        ?>
        <div class="card-jur d-flex justify-content-between p-2 rounded" style="background-color: <?= $jr['warna_jurusan']; ?>;">
            <div class="row col-sm-12 align-items-center justify-content-between">
                <b class="col-sm-6 "><?= $jr['nama_jurusan']; ?></b>
                <div class="row col-sm-6 p-0">
                  <?php
                    $kls = mysqli_query($conn, "SELECT * FROM tb_kelas WHERE kode_jurusan = '$kodejur'");
                    if(mysqli_num_rows($kls) > 0):
                      while($jk = $kls->fetch_assoc()): 
                  ?>
                  <!-- isi kelas -->
                  <div class="col-sm-4 p-1">
                    <span class="d-flex bg-dark text-white p-1 justify-content-center align-items-center rounded text-center" style="font-size: small;">
                        <b class="mr-2"><?= $jk['nama_kelas']; ?></b>
                        <div class="d-flex">
                            <a href="#" class="icon-sm px-2 text-white" style="text-decoration: none;" data-toggle="modal" data-target="#edit_kls<?= $jk['id_kelas']; ?>">
                                <b class="icon-cog"></b>
                            </a>
                            <a href="#" class="icon-sm px-2 text-white" style="text-decoration: none;" data-toggle="modal" data-target="#del_kls<?= $jk['id_kelas']; ?>">
                                <b class="icon-remove"></b>
                            </a>
                        </div>
                    </span>
                  </div>

                    <!-- Modal Edit Kelas-->
                    <div class="modal fade" id="edit_kls<?= $jk['id_kelas']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Kelas</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form action="" method="POST">
                            <div class="modal-body">
                                <input type="hidden" name="id_kls" value="<?= $jk['id_kelas']; ?>">
                                <select name="jurusan" id="" class="form-control mb-2">
                                  <?php
                                    $query_jk = mysqli_query($conn, "SELECT * FROM tb_jurusan");
                                    if(mysqli_num_rows($query_jk) > 0) :
                                        while ($q = $query_jk->fetch_assoc()) :
                                  ?>
                                        <option value="<?= $q['kode_jurusan']; ?>" <?php if($q['kode_jurusan'] == $jk['kode_jurusan']){echo"selected";}?>><?= $q['nama_jurusan']; ?></option>
                                  <?php endwhile; ?>
                                  <?php else: ?>
                                        <option value="">Tidak ada jurusan</option>
                                  <?php endif; ?>
                                </select>
                                <select name="tingkat" id="" class="form-control mb-2">
                                    <option value="X" <?php if($jk['tingkat'] == "X"){echo "selected";} ?>>X</option>
                                    <option value="XI" <?php if($jk['tingkat'] == "XI"){echo "selected";} ?>>XI</option>
                                    <option value="XII" <?php if($jk['tingkat'] == "XII"){echo "selected";} ?>>XII</option>
                                </select>
                                <input name="kelas" type="text" class="form-control" placeholder="Nama Kelas" value="<?= $jk['nama_kelas']; ?>">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="submit" name="exc_edit_kls" class="btn btn-info">Simpan Perubahan</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>



                    <!-- Modal hapus -->
                    <div class="modal" tabindex="-1" role="dialog" id="del_kls<?= $jk['id_kelas']; ?>">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Seriusan, hapus kelas ini?</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-footer">
                            <form action="" method="POST">
                              <input type="hidden" name="id_kelas" value="<?= $jk['id_kelas']; ?>">
                              <button type="submit" name="exc_del_kls" class="btn btn-danger">Hapus</button>
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php endwhile; ?>
                    <?php else: ?>
                        <div class="text-center py-3 text-secondary">Data tidak kelas</div>
                    <?php endif; ?>
                </div>
            </div>
            
        </div>
            <?php endwhile; ?>        
             
            <!-- jika tidak ada data kelas -->
        <?php else: ?>
            <div class="text-center py-3 text-secondary">Data tidak ada</div>
        <?php endif; ?>

    </div>
</div>



<!-- MODAL -->

<!-- Modal Tambah Jurusan-->
<div class="modal fade" id="tambah_jur" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Jurusan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST">
        <div class="modal-body">
            <div class="position-relative">
              <b class="btn btn-warning position-absolute" style="right:0;" title="Isi Otomatis" onclick="random(5,'kode_j');">Generate</b>
              <input name="kode_jur" type="text" id="kode_j" class="form-control mb-2" placeholder="Kode Jurusan" required>
            </div>
            <input name="nama_jur" type="text" class="form-control mb-2" placeholder="Nama Jurusan" required>
            <label for="" class="pl-3">Warna icon</label>
            <input name="warna_jur" type="color">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" name="exc_add_jur" class="btn btn-info">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>





<!-- Modal Tambah Kelas-->
<div class="modal fade" id="tambah_kls" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Kelas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST">
        <div class="modal-body">
            <select name="jurusan" id="" class="form-control mb-2">
              <?php
                $query_jur_kel = mysqli_query($conn, "SELECT * FROM tb_jurusan");
                if(mysqli_num_rows($query_jur_kel) > 0) :
                    while ($jur_kel = $query_jur_kel->fetch_assoc()) :
              ?>
                    <option value="<?= $jur_kel['kode_jurusan']; ?>"><?= $jur_kel['nama_jurusan']; ?></option>
              <?php endwhile; ?>
              <?php else: ?>
                    <option value="">Tidak ada jurusan</option>
              <?php endif; ?>
            </select>
            <select name="tingkat" id="" class="form-control mb-2">
                <option value="X">X</option>
                <option value="XI">XI</option>
                <option value="XII">XII</option>
            </select>
            <input name="kelas" type="text" class="form-control" placeholder="Nama Kelas" required>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" name="exc_add_kelas" class="btn btn-info">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

