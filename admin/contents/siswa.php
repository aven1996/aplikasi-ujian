<div class="container py-3">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="text-info py-2" style="font-weight:bold;">Siswa</h3>
        <div class="d-flex">
            <a href="#" class="icon-sm  px-2" style="text-decoration: none;" data-toggle="modal" data-target="#tambah_siswa">
                <b class="icon-plus"></b>
            </a>
        </div>
    </div>
    <!-- tabel -->
    <div class="w-100 overflow-auto">
    <table class="table table-striped bg-white" id="tabel_siswa">
    <thead>
        <tr>
            <th scope="col" class="text-info w-50" style="min-width: 250px;">Nama</th>
            <th scope="col" class="text-info">Nomor</th>
            <th scope="col" class="text-info" style="min-width: 100px;">Kelas</th>
            <th scope="col" class="text-info">Password</th>
            <th scope="col" class="text-info">Tindakan</th>
        </tr>
    </thead>
    <tbody>
      <?php 
        // looping siswa
        $siswa_q = mysqli_query($conn, "SELECT * FROM tb_siswa INNER JOIN tb_kelas ON tb_siswa.id_kelas = tb_kelas.id_kelas ORDER BY nomor_peserta ASC");
        if(mysqli_num_rows($siswa_q) > 0):
          while($siswa = $siswa_q->fetch_assoc()):
      ?>
        <tr>
            <th scope="row"><?= $siswa['nama_siswa']; ?></th>
            <td><?= $siswa['nomor_peserta']; ?></td>
            <td><?= $siswa['nama_kelas']; ?></td>
            <td><?= $siswa['pass_show_siswa']; ?></td>
            <td>
                <div class="d-flex">
                    <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#edit_siswa<?= $siswa['nomor_peserta']; ?>">
                        <b class="icon-cog"></b>
                    </a>
                    <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#del_siswa<?= $siswa['nomor_peserta']; ?>">
                        <b class="icon-remove"></b>
                    </a>
                </div>
            </td>
        </tr>

        <!-- Modal Edit Guru-->
        <div class="modal fade" id="edit_siswa<?= $siswa['nomor_peserta']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="" method="POST">
                <div class="modal-body">
                      <?php
                        // ambil tingkat dan jurusan
                        $id_kls = $siswa['id_kelas'];
                        $q_kls = mysqli_query($conn, "SELECT * FROM tb_kelas WHERE id_kelas = '$id_kls'");
                        $tingkat_jurusan = $q_kls->fetch_assoc();
                        $tg = $tingkat_jurusan['tingkat'];
                        $jur = $tingkat_jurusan['kode_jurusan'];
                      ?>
                    <input value="<?= $siswa['nama_siswa']; ?>" name="nama" type="text" class="form-control mb-2" placeholder="Nama" required>
                    <input value="<?= $siswa['nomor_peserta']; ?>" name="nomor_lama" type="hidden" class="form-control mb-2" placeholder="Nomor Peserta" required>
                    <input value="<?= $siswa['nomor_peserta']; ?>" name="nomor_baru" type="text" class="form-control mb-2" placeholder="Nomor Peserta" required>

                    <!-- Tidak jadi bisa memilih tingkat dan jurusan karena loopingan kedua dan str nya gagal -->
                    <!-- <select name="tingkat" id="tingkat_edit" class="form-control mb-2">
                        <option value="X" <?php if($tg == "X"){echo "selected";} ?>>X</option>
                        <option value="XI" <?php if($tg == "XI"){echo "selected";} ?>>XI</option>
                        <option value="XII" <?php if($tg == "XII"){echo "selected";} ?>>XII</option>
                    </select> -->

                    <!-- <select name="jurusan" id="jurusan_edit" class="form-control mb-2" required>
                    <?php
                          $jur_qq = mysqli_query($conn, "SELECT * FROM tb_jurusan");
                          if(mysqli_num_rows($jur_qq) > 0):
                            while($jurq = $jur_qq->fetch_assoc()):
                        ?>
                            <option value="<?= $jurq['kode_jurusan']; ?>" <?php if($jurq['kode_jurusan']==$jur){echo "selected";} ?>><?= $jurq['nama_jurusan']; ?></option>
                        <?php
                            endwhile;
                          else:
                        ?>
                            <option value="">Tidak ada jurusan</option>
                        <?php
                          endif;
                        ?>
                    </select> -->

                    <select name="kelas" class="kelas_edit form-control mb-2" required>
                      <?php
                        $q_klz = mysqli_query($conn, "SELECT * FROM tb_kelas WHERE tingkat = '$tg' AND kode_jurusan = '$jur'");
                        while($klz = $q_klz->fetch_assoc()):
                      ?>
                        <option value="<?= $klz['id_kelas']; ?>" <?php if($id_kls == $klz['id_kelas']){echo "selected";} ?>><?= $klz['nama_kelas']; ?></option>
                      <?php endwhile; ?>
                    </select>

                    <input value="<?= $siswa['pass_show_siswa']; ?>" name="password" type="text" class="form-control" placeholder="Password" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" name="exc_edit_siswa" class="btn btn-info">Simpan</button>
                </div>
              </form>
            </div>
          </div>
        </div>

        <!-- Modal hapus -->
        <div class="modal" tabindex="-1" role="dialog" id="del_siswa<?= $siswa['nomor_peserta']; ?>">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Seriusan, hapus siswa ini?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-footer">
              <form action="" method="POST">
                <input type="hidden" name="nomor_siswa" value="<?= $siswa['nomor_peserta']; ?>">
                <button type="submit" name="exc_del_siswa" class="btn btn-danger">Hapus</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
              </form>
              </div>
            </div>
          </div>
        </div>
        

      <?php endwhile; ?>
      <?php else: ?>
        <tr>
            <td colspan="5">Tidak ada data</td>
        </tr>
      <?php endif; ?>
    </tbody>
    </table>
    </div>
</div>


<!-- MODAL -->
<!-- Modal Tambah Siswa-->
<div class="modal fade" id="tambah_siswa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Siswa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST">
        <div class="modal-body">
            <input name="nama" type="text" class="form-control mb-2" placeholder="Nama" required>
            <input name="nomor" type="text" class="form-control mb-2" placeholder="Nomor Peserta" required>
            <select name="tingkat" id="tingkat" class="form-control mb-2">
                <option value="X">X</option>
                <option value="XI">XI</option>
                <option value="XII">XII</option>
            </select>
            <select name="jurusan" id="jurusan" class="form-control mb-2" required>
            <?php
                  $jur_qz = mysqli_query($conn, "SELECT * FROM tb_jurusan");
                  if(mysqli_num_rows($jur_qz) > 0):
                    while($jurz = $jur_qz->fetch_assoc()):
                ?>
                    <option value="<?= $jurz['kode_jurusan']; ?>"><?= $jurz['nama_jurusan']; ?></option>
                <?php
                    endwhile;
                  else:
                ?>
                    <option value="">Tidak ada jurusan</option>
                <?php
                  endif;
                ?>
            </select>
            <select name="kelas" id="kelas" class="form-control mb-2" required>
                <option value=""></option>
            </select>
            <input name="password" type="text" class="form-control" placeholder="Password" required>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" name="exc_add_siswa" class="btn btn-info">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>



<!-- Modal Cari Kelas-->
<div class="modal fade" id="cari_siswa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cari Siswa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action=""> 
        <div class="modal-body">
            <input type="text" class="form-control" placeholder="Nama Siswa" required>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" name="exc_cari_siswa" class="btn btn-info">Cari</button>
        </div>
      </form>
    </div>
  </div>
</div>


