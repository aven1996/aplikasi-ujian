<div class="container py-3">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="text-info py-2" style="font-weight:bold;">Siswa Login</h3>
    </div>

    <div class="w-100 overflow-auto">
    <table class="table table-striped border bg-white" id="tabel_siswa_login">
    <thead>
        <tr>
            <th scope="col" class="text-info" style="min-width: 250px;">Nama</th>
            <th scope="col" class="text-info">Nomor</th>
            <th scope="col" class="text-info" style="min-width: 100px;">Kelas</th>
            <th scope="col" class="text-info">Status</th>
            <th scope="col" class="text-info">Tindakan</th>
        </tr>
    </thead>
    <tbody>
      <?php
        $siswa_login_q = $conn->query("SELECT * FROM tb_stt_siswa_login JOIN tb_siswa ON tb_stt_siswa_login.nomor_peserta = tb_siswa.nomor_peserta WHERE status_login = 'online' OR status_ujian = 'Mengerjakan'");
        if(mysqli_num_rows($siswa_login_q) > 0):
          while($siswa_log = $siswa_login_q->fetch_assoc()):
            $id_kelas = $siswa_log['id_kelas'];
      ?>
        <tr>
            <th scope="row"><?= $siswa_log['nama_siswa']; ?></th>
            <td><?= $siswa_log['nomor_peserta']; ?></td>
            <td>
              <?php
                $kelas_q = mysqli_query($conn, "SELECT * FROM tb_siswa JOIN tb_kelas ON tb_siswa.id_kelas = tb_kelas.id_kelas WHERE tb_siswa.id_kelas = '$id_kelas'");
                $kelas = $kelas_q->fetch_assoc();
                echo $kelas['nama_kelas'];
              ?>
            </td>
            <?php if($siswa_log['status_ujian'] == "Mengerjakan"): ?>
                <td class="text-danger"><?= $siswa_log['status_ujian']; ?></td>
            <?php else: ?>
                <td class="text-dark"><?= $siswa_log['status_ujian']; ?></td>
            <?php endif; ?>
            <td>
              <!-- validasi petugas admin yang hanya bisa akses tool ini -->
              <?php if($_SESSION['petugas'] == "admin"): ?>
                <div class="d-flex">
                    <a href="?cnt=<?= $_GET['cnt']; ?>&logout=<?= $siswa_log['id_siswa_login']; ?>" class="icon-sm px-2" style="text-decoration: none;" title="Logout Siswa">
                        <b class="icon-refresh"></b>
                    </a>
                    <a href="?cnt=<?= $_GET['cnt']; ?>&done=<?= $siswa_log['id_siswa_login']; ?>" class="icon-sm px-2" style="text-decoration: none;" title="Selesaikan Ujian">
                        <b class="icon-check"></b>
                    </a>
                </div>
              <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="5" class="text-center p-2">Data tidak ada</td>
        </tr>
      <?php endif; ?>
        
    </tbody>
    </table>
    </div>
</div>




<!-- MODAL -->

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


<!-- Modal hapus -->
<div class="modal" tabindex="-1" role="dialog" id="akhiri_siswa">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Akhiri ujian siswa ini?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-footer">
        <button type="button" name="exc_akhiri_siswa" class="btn btn-danger">Akhiri</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>