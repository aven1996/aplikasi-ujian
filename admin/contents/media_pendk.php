<!-- Media Pendukung -->
<div class="container py-3">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="text-info py-2" style="font-weight:bold;">Media Pendukung</h3>
        <div class="d-flex">
            
            <!-- <a href="#" class="icon-sm px-2" style="text-decoration: none;background-color:whitesmoke;" data-toggle="modal" data-target="#cari_media">
                <b class="icon-search"></b>
            </a> -->
            <a href="#" class="icon-sm px-2" style="text-decoration: none;background-color:whitesmoke;" data-toggle="modal" data-target="#tambah_media">
                <b class="icon-plus"></b>
            </a>

            <a href="#" class="icon-sm px-2" style="text-decoration: none; background-color:whitesmoke;" data-toggle="modal" data-target="#bersihkan_media">
                <b class="icon-trash"></b>
            </a>
            
        </div>
    </div>
    <div class="bg-warning p-2 mb-2 d-flex">
      <b class="icon-lightbulb-o text-white" style="font-size: 28pt;"></b>
      <ul>
        <li>Upload file media pendukung yang terisi pada butir soal excel</li>
        <li>Mengatasi gambar/audio yang tidak tampil yaitu upload ulang dengan nama file yang sama</li>
      </ul>
    </div>

    <div class="p-2 border rounded mb-2 bg-white">

        <div class="row px-3">
           <?php
            $md_Q = mysqli_query($conn, "SELECT media_pendukung FROM tb_pertanyaan");
            $md_O = mysqli_query($conn, "SELECT media_pendukung FROM tb_opsi_jwb");
            if(mysqli_num_rows($md_Q) == 0 AND mysqli_num_rows($md_O) == 0):
          ?>
              <div class="text-center p-3">Data tidak ada</div>
          <?php
            else:
          ?>
              <?php
              // looping media pada tabel pertanyaan
                if(mysqli_num_rows($md_Q) > 0):
                  while($mdQ = $md_Q->fetch_assoc()):
                    // filter yang tampil hanya nama file yang mengandung "media_add"
                    if(in_array("media_add",explode("/",$mdQ['media_pendukung']))):
                      // validasi apakah file berupa gambar/audio
                      if(cekFile($mdQ['media_pendukung']) == "image"):
              ?>
                      <div class="d-flex flex-column text-center p-2 overflow-hidden border mr-1 mb-1" style="max-width: 150px;">
                          <img src="assets/img/media/<?= $mdQ['media_pendukung']; ?>" alt="<?= $mdQ['media_pendukung']; ?>" class="w-100">
                          <small title="<?= $mdQ['media_pendukung']; ?>"><?= $mdQ['media_pendukung']; ?></small>
                      </div>
              <?php
                      elseif(cekFile($mdQ['media_pendukung']) == "audio"):
              ?>
                      <div class="d-flex flex-column text-center p-2 overflow-hidden border mr-1 mb-1">
                          <audio src="assets/img/media/<?= $mdQ['media_pendukung']; ?>" controls></audio>
                          <small title="<?= $mdQ['media_pendukung']; ?>"><?= $mdQ['media_pendukung']; ?></small>
                      </div>
              <?php
                      endif;
                    endif;
                  endwhile;
                endif;
              ?>


              <?php
              // looping media pada tabel opsi jwb
                if(mysqli_num_rows($md_O) > 0):
                  while($mdO = $md_O->fetch_assoc()):
                    // filter yang tampil hanya nama file yang mengandung "media_add"
                    if(in_array("media_add",explode("/",$mdO['media_pendukung']))):
                      // validasi apakah file berupa gambar/audio
                      if(cekFile($mdO['media_pendukung']) == "image"):
              ?>
                      <div class="d-flex flex-column text-center p-2 overflow-hidden border mr-1 mb-1" style="max-width: 150px;">
                          <img src="assets/img/media/<?= $mdO['media_pendukung']; ?>" alt="<?= $mdO['media_pendukung']; ?>" class="w-100">
                          <small title="<?= $mdO['media_pendukung']; ?>"><?= $mdO['media_pendukung']; ?></small>
                      </div>
              <?php
                      elseif(cekFile($mdO['media_pendukung']) == "audio"):
              ?>
                      <div class="d-flex flex-column text-center p-2 overflow-hidden border mr-1 mb-1">
                          <audio src="assets/img/media/<?= $mdO['media_pendukung']; ?>" controls></audio>
                          <small title="<?= $mdO['media_pendukung']; ?>"><?= $mdO['media_pendukung']; ?></small>
                      </div>
              <?php
                      endif;
                    endif;
                  endwhile;
                endif;
              ?>


          <?php
            endif;
          ?>
        </div>

    </div>
</div>





<!-- MODAL -->

<!-- Modal Tambah Jenis Ujian-->
<div class="modal fade" id="tambah_media" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Media Pendukung</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <small class="d-block mx-3 rounded text-center p-2 my-1 bg-warning"><b class="icon-lightbulb-o"></b> Upload file gambar atau audio</small>
      <form action="" method="POST" enctype="multipart/form-data">
        <div class="modal-body">
            <input name="media_add[]" type="file" multiple class="form-control mb-2" required>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" name="exc_add_media" class="btn btn-info">Upload</button>
        </div>
      </form>
    </div>
  </div>
</div>



<!-- Modal Cari Media-->
<div class="modal fade" id="cari_media" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cari Media Pendukung</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="">
        <div class="modal-body">
            <input type="text" class="form-control mb-2" placeholder="File name media" required>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" name="exc_cari_media" class="btn btn-info">Cari</button>
        </div>
      </form>
    </div>
  </div>
</div>
 

<!-- Modal hapus -->
<div class="modal" tabindex="-1" role="dialog" id="bersihkan_media">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Seriusan, hapus semua file media?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-footer">
        <form action="" method="POST">
            <button type="submit" name="exc_bersihkan_media" class="btn btn-danger">bersihkan</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </form>
      </div>
    </div>
  </div>
</div>



