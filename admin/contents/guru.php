<div class="container py-3">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="text-info py-2" style="font-weight:bold;">Guru</h3>
        <div class="d-flex">
            <!-- <a href="#" class="icon-sm  px-2" style="text-decoration: none;" data-toggle="modal" data-target="#cari_guru">
                <b class="icon-search"></b>
            </a> -->
            <a href="#" class="icon-sm  px-2" style="text-decoration: none;" data-toggle="modal" data-target="#tambah_guru">
                <b class="icon-plus"></b> 
            </a>
        </div>
    </div>

    <div class="w-100 overflow-auto"> 
    <table class="table table-striped bg-white" id="tabel_guru">
    <thead>
        <tr>
            <th scope="col" class="text-info w-50" style="min-width: 250px;">Nama</th>
            <th scope="col" class="text-info">Username</th>
            <th scope="col" class="text-info">Password</th>
            <th scope="col" class="text-info">Tindakan</th>
        </tr>
    </thead>
    <tbody>
      <!-- looping guru -->
      <?php
        $guru_q = mysqli_query($conn, "SELECT * FROM tb_guru $search ORDER BY id_guru DESC");
        if(mysqli_num_rows($guru_q) > 0):
          while($guru = $guru_q->fetch_assoc()):
      ?>
        <tr>
            <th scope="row"><?= $guru['nama_guru']; ?></th>
            <td><?= $guru['username_guru']; ?></td>
            <td><?= $guru['pass_show_guru']; ?></td>
            <td>
                <div class="d-flex"> 
                    <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#edit_guru<?= $guru['id_guru']; ?>">
                        <b class="icon-cog"></b>
                    </a>
                    <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#del_guru<?= $guru['id_guru']; ?>">
                        <b class="icon-remove"></b>
                    </a>
                </div>
            </td>
        </tr>


        <!-- modal -->
        <!-- Modal Edit Guru-->
          <div class="modal fade" id="edit_guru<?= $guru['id_guru']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Edit Guru</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <form action="" method="POST">
                  <div class="modal-body">
                      <input type="hidden" name="id" value="<?= $guru['id_guru']; ?>">
                      <input name="nama" type="text" class="form-control mb-2" placeholder="Nama" value="<?= $guru['nama_guru']; ?>">
                      <input name="username" type="text" class="form-control mb-2" placeholder="Username" value="<?= $guru['username_guru']; ?>">
                      <input name="password" type="text" class="form-control" placeholder="Password" value="<?= $guru['pass_show_guru']; ?>">
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                      <button type="submit" name="exc_edit_guru" class="btn btn-info">Simpan Perubahan</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- Modal hapus -->
          <div class="modal" tabindex="-1" role="dialog" id="del_guru<?= $guru['id_guru']; ?>">
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
                  <input type="hidden" name="id" value="<?= $guru['id_guru']; ?>">
                  <button type="submit" name="exc_del_guru" class="btn btn-danger">Hapus</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </form>
                </div>
              </div>
            </div>
          </div>

          <?php endwhile; ?>
        <?php else: ?>
          <tr>
              <td colspan="4" class="text-center">Data tidak ada</td>
          </tr>
        <?php endif; ?>
    </tbody>
    </table>
    </div>
</div>




<!-- MODAL -->
<!-- Modal Tambah Guru-->
<div class="modal fade" id="tambah_guru" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Guru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST">
        <div class="modal-body">
            <input name="nama" type="text" class="form-control mb-2" placeholder="Nama" >
            <input name="username" type="text" class="form-control mb-2" placeholder="Username" >
            <input name="password" type="text" class="form-control" placeholder="Password" >
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" name="exc_add_guru" class="btn btn-info">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>




<!-- Modal Cari Kelas-->
<div class="modal fade" id="cari_guru" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cari Guru</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST">
        <div class="modal-body">
            <input name="c_guru" type="text" class="form-control" placeholder="Nama Guru" required>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" name="cari" class="btn btn-info">Cari</button>
        </div>
      </form>
    </div>
  </div>
</div>


