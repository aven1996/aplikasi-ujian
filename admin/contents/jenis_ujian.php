<!-- JURUSAN -->

<div class="container py-3">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="text-info py-2" style="font-weight:bold;">Jenis Ujian</h3>
        <div class="d-flex">
            <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#tambah_jenis_uj">
                <b class="icon-plus"></b>
            </a>
        </div>
    </div>

    <div class="pl-2 pt-2 pr-2 pb-0 border rounded mb-2 bg-white">
        <!-- looping jenis ujian -->
        <?php
            $q_jenis_uj = mysqli_query($conn, "SELECT * FROM tb_jenis_ujian");
            if(mysqli_num_rows($q_jenis_uj) > 0):
              while($jenis_uj = $q_jenis_uj->fetch_assoc()):
        ?>
        <div class="card-jur d-flex justify-content-between p-2 rounded" style="background-color: whitesmoke;">
            <b><?= $jenis_uj['jenis_ujian']; ?></b>
            <b>Tahun Pelajaran <?= $jenis_uj['tahun_ajaran']; ?></b>
            <div class="d-flex">
                <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#edit_jenis_uj<?= $jenis_uj['id_jenis_ujian']; ?>">
                    <b class="icon-cog"></b>
                </a>
                <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#del_jenis_uj<?= $jenis_uj['id_jenis_ujian']; ?>">
                    <b class="icon-remove"></b>
                </a>
            </div>
        </div>

        <!-- Modal Edit Jenis Ujian-->
        <div class="modal fade" id="edit_jenis_uj<?= $jenis_uj['id_jenis_ujian']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Jenis Ujian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="id_jenis_ujian" value="<?= $jenis_uj['id_jenis_ujian']; ?>">
                    <input value="<?= $jenis_uj['jenis_ujian']; ?>" name="jenis_ujian" type="text" class="form-control mb-2" placeholder="Jenis Ujian" required>
                    <input value="<?= $jenis_uj['tahun_ajaran']; ?>" name="tahun_ajaran" type="text" class="form-control mb-2" placeholder="Tahun Pelajaran" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" name="exc_edit_jenis_uj" class="btn btn-info">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Modal hapus -->
        <div class="modal" tabindex="-1" role="dialog" id="del_jenis_uj<?= $jenis_uj['id_jenis_ujian']; ?>">
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
                  <input type="hidden" name="id_jenis_ujian" value="<?= $jenis_uj['id_jenis_ujian']; ?>">
                  <button type="submit" name="exc_del_jenis_uj" class="btn btn-danger">Hapus</button>
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
<!-- Modal Tambah Jenis Ujian-->
<div class="modal fade" id="tambah_jenis_uj" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Jenis Ujian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST">
        <div class="modal-body">
            <input name="jenis_ujian" type="text" class="form-control mb-2" placeholder="Jenis Ujian" required>
            <input name="tahun_ajaran" type="text" class="form-control mb-2" placeholder="Tahun Pelajaran" required>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" name="exc_add_jenis_uj" class="btn btn-info">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>







