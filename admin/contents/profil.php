<!-- FORM PROFIL -->

<div class="container py-3">
    <h3 class="text-info py-2" style="font-weight:bold;">Profil</h3>
    <div class="p-3 d-flex justify-content-between border rounded mb-2 bg-white">
        <div>
            <h6 class="text-info">Nama Sekolah</h6>
            <h6><?= $sekolah['nama_sekolah']; ?></h6>
        </div>
        <a href="#" class="icon-sm" data-toggle="modal" data-target="#edit_sekolah">
            <b class="icon-cog"></b>
        </a>
    </div>

    <div class="p-3 d-flex justify-content-between border rounded mb-2 bg-white">
        <div>
            <h6 class="text-info">Nama Kepala Sekolah</h6>
            <h6><?= $sekolah['nama_kepsek']; ?></h6>
        </div>
        <a href="#" class="icon-sm" data-toggle="modal" data-target="#edit_kepsek">
            <b class="icon-cog"></b>
        </a>
    </div>

    <div class="p-3 d-flex justify-content-between border rounded mb-2 bg-white">
        <div>
            <h6 class="text-info">Logo Sekolah</h6>
            <img src="assets/img/profil_smk/<?= $sekolah['logo_sekolah']; ?>" alt="" width="100">
        </div>
        <a href="#" class="icon-sm" data-toggle="modal" data-target="#edit_logo">
            <b class="icon-cog"></b>
        </a>
    </div>

    <div class="p-3 d-flex justify-content-between border rounded mb-2 bg-white">
        <div>
            <h6 class="text-info">Kop Sekolah</h6>
            <img src="assets/img/profil_smk/<?= $sekolah['kop_sekolah']; ?>" alt="" style="width: 90%;">
        </div>
        <a href="#" class="icon-sm" data-toggle="modal" data-target="#edit_kop">
            <b class="icon-cog"></b>
        </a>
    </div>

    <div class="p-3 d-flex justify-content-between border rounded mb-2 bg-white">
        <div>
            <h6 class="text-info">Background Sekolah</h6>
            <img src="assets/img/profil_smk/<?= $sekolah['bg_sekolah']; ?>" alt="" style="width: 90%;">
        </div>
        <a href="#" class="icon-sm" data-toggle="modal" data-target="#edit_bg">
            <b class="icon-cog"></b>
        </a>
    </div>

</div>



<!-- MODAL -->
<!-- Edit Nama Sekolah-->
<div class="modal fade" id="edit_sekolah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nama Sekolah</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST">
        <div class="modal-body">
            <input name="id_profil" type="hidden" value="<?= $sekolah['id_profil']; ?>">
            <input name="nama_sekolah" type="text" class="form-control mb-2" placeholder="Nama Sekolah" value="<?= $sekolah['nama_sekolah']; ?>" required>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" name="exc_edit_sekolah" class="btn btn-info">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Nama Kepsek-->
<div class="modal fade" id="edit_kepsek" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Nama Kepala Sekolah</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST">
        <div class="modal-body">
            <input name="id_profil" type="hidden" value="<?= $sekolah['id_profil']; ?>">
            <input name="nama_kepsek" type="text" class="form-control mb-2" placeholder="Nama Kepala Sekolah" required value="<?= $sekolah['nama_kepsek']; ?>">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" name="exc_edit_kepsek" class="btn btn-info">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Logo-->
<div class="modal fade" id="edit_logo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Logo Sekolah</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
            <input name="id_profil" type="hidden" value="<?= $sekolah['id_profil']; ?>">
            <input name="file" type="file" class="form-control mb-2" required>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" name="exc_edit_logo" class="btn btn-info">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Kop-->
<div class="modal fade" id="edit_kop" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Kop Sekolah</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
            <input name="id_profil" type="hidden" value="<?= $sekolah['id_profil']; ?>">
            <input name="file" type="file" class="form-control mb-2" required>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" name="exc_edit_kop" class="btn btn-info">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Background-->
<div class="modal fade" id="edit_bg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Background Sekolah</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
            <input name="id_profil" type="hidden" value="<?= $sekolah['id_profil']; ?>">
            <input name="file" type="file" class="form-control mb-2" required>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" name="exc_edit_bg" class="btn btn-info">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>