<!-- MAPEL -->
<div class="container py-3">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="text-info py-2" style="font-weight:bold;">Mata Pelajaran</h3>
        <div class="d-flex">
            <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#cari_mapel">
                <b class="icon-search"></b>
            </a>
            <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#tambah_mapel">
                <b class="icon-plus"></b>
            </a>
        </div>
    </div>

    <div class="w-100 overflow-auto">
    <table class="table table-striped bg-white">
    <thead>
        <tr>
            <th scope="col" class="text-info" style="min-width: 300px;">Mata Pelajaran</th>
            <th scope="col" class="text-info">Tindakan</th>
        </tr>
    </thead>
    <tbody>
        <!-- looping mapel -->
        <?php 
          $q_mapel = mysqli_query($conn, "SELECT * FROM tb_mapel $search ORDER BY id_mapel ASC");
          if(mysqli_num_rows($q_mapel) > 0):
            while($mapel = $q_mapel->fetch_assoc()):
        ?>
          <tr>
              <th scope="row" class="w-75"><?= $mapel['nama_mapel']; ?></th>
              <td>
                  <div class="d-flex">
                      <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#edit_mapel<?= $mapel['id_mapel']; ?>">
                          <b class="icon-cog"></b>
                      </a>
                      <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#del_mapel<?= $mapel['id_mapel']; ?>">
                          <b class="icon-remove"></b>
                      </a>
                  </div>
              </td>
          </tr>

          <!-- modal -->
          <!-- Modal Edit Mapel-->
          <div class="modal fade" id="edit_mapel<?= $mapel['id_mapel']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Edit Mapel</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="" method="POST">
                  <div class="modal-body">
                      <input type="hidden" name="id_mapel" value="<?= $mapel['id_mapel']; ?>">
                      <input type="text" name="mapel" id="" placeholder="Nama Mapel" class="form-control" value="<?= $mapel['nama_mapel']; ?>" required>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                      <button type="submit" name="exc_edit_mapel" class="btn btn-info">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Modal hapus -->
          <div class="modal" tabindex="-1" role="dialog" id="del_mapel<?= $mapel['id_mapel']; ?>">
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
                    <input type="hidden" name="id_mapel" value="<?= $mapel['id_mapel']; ?>">
                    <button type="submit" name="exc_del_mapel" class="btn btn-danger">Hapus</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        <?php
            endwhile;
          else:
        ?>
          <tr>
              <td colspan="2">Data tidak ada</td>
          </tr>
        <?php
          endif;
        ?>
    </tbody>
    </table>
    </div>
</div>


<!-- modal -->
<!-- Modal Tambah Mapel-->
<div class="modal fade" id="tambah_mapel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Mapel</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST">
        <div class="modal-body">
            <input type="text" name="mapel" id="" placeholder="Nama Mapel" class="form-control" required>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" name="exc_add_mapel" class="btn btn-info">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal Cari Mapel-->
<div class="modal fade" id="cari_mapel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cari Mapel</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST">
        <div class="modal-body">
            <input type="text" name="c_mapel" class="form-control" placeholder="Nama Mapel" required>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" name="cari_mapel" class="btn btn-info">Cari</button>
        </div>
      </form>
    </div>
  </div>
</div>







<!-- GURU PENGAMPU -->
<div class="container py-3">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="text-info py-2" style="font-weight:bold;">Guru Pengampu</h3>
        <div class="d-flex">
            <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#cari_pengampu">
                <b class="icon-search"></b>
            </a>
            <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#tambah_pengampu">
                <b class="icon-plus"></b>
            </a>
        </div>
    </div>

    <div class="w-100 overflow-auto">
    <table class="table table-striped bg-white">
    <thead>
        <tr>
            <th scope="col" class="text-info">Mata Pelajaran</th>
            <th scope="col" class="text-info">Tingkat</th>
            <th scope="col" class="text-info">Jurusan</th>
            <th scope="col" class="text-info">Guru Pengampu</th>
            <th scope="col" class="text-info">Tindakan</th>
        </tr>
    </thead>
    <tbody>
      <?php
      // looping data pengampu
      $pengampu_q = mysqli_query($conn, "SELECT * FROM tb_guru_pengampu INNER JOIN tb_guru ON tb_guru_pengampu.id_guru = tb_guru.id_guru INNER JOIN tb_mapel ON tb_guru_pengampu.id_mapel = tb_mapel.id_mapel $search_pengampu");
      if(mysqli_num_rows($pengampu_q) > 0):
        while($pengampu = $pengampu_q->fetch_assoc()):
      ?>
        <tr>
            <th scope="row" class="w-25"><?= $pengampu['nama_mapel']; ?></th>
            <td><?= $pengampu['tingkat']; ?></td>
            <td>
                <!-- looping jurusan pengampu -->
                <?php
                  $id_peng = $pengampu['id_pengampu'];
                  $pengampu_jur_q = mysqli_query($conn, "SELECT * FROM tb_pengampu_jur INNER JOIN tb_jurusan ON tb_pengampu_jur.kode_jurusan = tb_jurusan.kode_jurusan WHERE id_pengampu = '$id_peng'");
                  while($jur_p = $pengampu_jur_q->fetch_assoc()):
                ?>
                    <b class="icon-circle" style="color: <?= $jur_p['warna_jurusan'] ?>;" title="<?= $jur_p['nama_jurusan'] ?>" data-toggle="tooltip" data-placement="bottom"></b>
                <?php endwhile; ?>
            </td>
            <td class="w-25">
              <?= $pengampu['nama_guru']; ?>
            </td>
            <td>
                <div class="d-flex">
                    <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#edit_pengampu<?= $pengampu['id_pengampu']; ?>">
                        <b class="icon-cog"></b>
                    </a>
                    <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#del_pengampu<?= $pengampu['id_pengampu']; ?>">
                        <b class="icon-remove"></b>
                    </a>
                </div>
            </td>
        </tr>

        <!-- Modal Edit Pengampu-->
        <div class="modal fade" id="edit_pengampu<?= $pengampu['id_pengampu']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Pengampu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id_pengampu" value="<?= $pengampu['id_pengampu']; ?>">
                    <select name="mapel" id="" class="form-control mb-2">
                      <?php
                        $mp_qx = mysqli_query($conn, "SELECT * FROM tb_mapel");
                        if(mysqli_num_rows($mp_qx) > 0):
                          while($mpx = $mp_qx->fetch_assoc()):
                      ?>
                          <option value="<?= $mpx['id_mapel']; ?>" <?php if($mpx['id_mapel'] == $pengampu['id_mapel']){echo "selected";} ?>><?= $mpx['nama_mapel']; ?></option>
                      <?php
                          endwhile;
                        else:
                      ?>
                          <option value="">Tidak ada mapel</option>
                      <?php
                        endif;
                      ?>
                    </select>
                    <select name="tingkat" id="" class="form-control mb-2">
                        <option value="X" <?php if($pengampu['tingkat'] == "X"){echo "selected";} ?>>X</option>
                        <option value="XI" <?php if($pengampu['tingkat'] == "XI"){echo "selected";} ?>>XI</option>
                        <option value="XII" <?php if($pengampu['tingkat'] == "XII"){echo "selected";} ?>>XI</option>
                    </select>
                    <select name="jurusan[]" id="" class="form-control mb-2" multiple="multiple" style="min-height: 150px;">
                      <?php
                        $id_pengx = $pengampu['id_pengampu'];
                        $jur_qx = mysqli_query($conn, "SELECT * FROM tb_jurusan");
                        $arr_jur = mysqli_query($conn, "SELECT * FROM tb_pengampu_jur WHERE id_pengampu = '$id_pengx' ");
                        $arr_jurx = [];
                        while($jr = $arr_jur->fetch_assoc()){
                          $arr_jurx[] = $jr['kode_jurusan'];
                        }
                        if(mysqli_num_rows($jur_qx) > 0):
                          while($jurx = $jur_qx->fetch_assoc()):
                            
                      ?>
                          <option value="<?= $jurx['kode_jurusan']; ?>" <?php if(in_array($jurx['kode_jurusan'],$arr_jurx)){echo "selected";} ?>><?= $jurx['nama_jurusan']; ?></option>
                      <?php
                          endwhile;
                        else:
                      ?>
                          <option value="">Tidak ada jurusan</option>
                      <?php
                        endif;
                      ?>
                    </select>
                    <select name="guru" id="" class="form-control">
                      <?php
                        $guru_qx = mysqli_query($conn, "SELECT * FROM tb_guru");
                        if(mysqli_num_rows($guru_qx) > 0):
                          while($gurux = $guru_qx->fetch_assoc()):
                      ?>
                          <option value="<?= $gurux['id_guru']; ?>" <?php if($gurux['id_guru'] == $pengampu['id_guru']){echo "selected";} ?>><?= $gurux['nama_guru']; ?></option>
                      <?php
                          endwhile;
                        else:
                      ?>
                          <option value="">Tidak ada guru</option>
                      <?php
                        endif;
                      ?>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" name="exc_edit_pengampu" class="btn btn-info">Simpan Perubahan</button>
                </div>
              </form>
            </div>
          </div>
        </div>


        <!-- Modal hapus -->
        <div class="modal" tabindex="-1" role="dialog" id="del_pengampu<?= $pengampu['id_pengampu']; ?>">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Seriusan, hapus data ini?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-footer">
              <form action="" method="POST">
                <input type="hidden" name="id_pengampu" value="<?= $pengampu['id_pengampu']; ?>">
                <button type="submit" name="exc_del_pengampu" class="btn btn-danger">Hapus</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
              </form>
              </div>
            </div>
          </div>
        </div>
         <?php endwhile; ?>
      <?php else: ?>
          <tr>
            <td colspan="5">Tidak ada data pengampu</td>
          </tr>
      <?php endif; ?>
    </tbody>
    </table>
    </div>
</div>


<!-- MODAL -->

<!-- Modal Cari pengampu-->
<div class="modal fade" id="cari_pengampu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cari Guru Pengampu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST">
        <div class="modal-body">
            <input name="cari_pengampu" type="text" class="form-control" placeholder="Cari nama mapel atau nama guru" required>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" name="exc_cari_pengampu" class="btn btn-info">Cari</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Tambah Pengampu-->
<div class="modal fade" id="tambah_pengampu" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Pengampu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST">
        <div class="modal-body">
            <select name="mapel" id="" class="form-control mb-2" required>
                <?php
                  $mp_q = mysqli_query($conn, "SELECT * FROM tb_mapel");
                  if(mysqli_num_rows($mp_q) > 0):
                    while($mp = $mp_q->fetch_assoc()):
                ?>
                    <option value="<?= $mp['id_mapel']; ?>"><?= $mp['nama_mapel']; ?></option>
                <?php
                    endwhile;
                  else:
                ?>
                    <option value="">Tidak ada mapel</option>
                <?php
                  endif;
                ?>
            </select>
            <select name="tingkat" id="" class="form-control mb-2" required>
                <option value="X">X</option>
                <option value="XI">XI</option>
                <option value="XII">XII</option> 
            </select>
            <select name="jurusan[]" id="" class="form-control mb-2" multiple="multiple" style="min-height:150px;" required>
                <?php
                  $jur_q = mysqli_query($conn, "SELECT * FROM tb_jurusan");
                  if(mysqli_num_rows($jur_q) > 0):
                    while($jur = $jur_q->fetch_assoc()):
                ?>
                    <option value="<?= $jur['kode_jurusan']; ?>"><?= $jur['nama_jurusan']; ?></option>
                <?php
                    endwhile;
                  else:
                ?>
                    <option value="">Tidak ada jurusan</option>
                <?php
                  endif;
                ?> 
            </select>
            <select name="guru" id="" class="form-control" required>
                <?php
                  $guru_q = mysqli_query($conn, "SELECT * FROM tb_guru");
                  if(mysqli_num_rows($guru_q) > 0):
                    while($guru = $guru_q->fetch_assoc()):
                ?>
                    <option value="<?= $guru['id_guru']; ?>"><?= $guru['nama_guru']; ?></option>
                <?php
                    endwhile;
                  else:
                ?>
                    <option value="">Tidak ada guru</option>
                <?php
                  endif;
                ?>
            </select>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" name="exc_add_pengampu" class="btn btn-info">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

