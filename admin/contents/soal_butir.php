
<div class="container py-3">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="text-info py-2" style="font-weight:bold;"><a href="?cnt=kelola_soal">Kelola Soal</a> > Butir Soal</h3>
    </div>
    <?php
        $kode_soal = $_GET['id'];
        $q_soal = mysqli_query($conn, "SELECT * FROM tb_soal JOIN tb_jenis_ujian ON tb_soal.id_jenis_ujian = tb_jenis_ujian.id_jenis_ujian WHERE kode_soal = '$kode_soal'");
        $soal = $q_soal->fetch_assoc();
    ?>
    <div class="pl-2 pt-2 pr-2 pb-0 border rounded bg-white">
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

                    <a href="#" id="icon-add" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#tambah_butirsoal">
                        <b class="icon-plus"></b>
                    </a>

                    <!-- <a href="#" class="icon-sm px-2" style="text-decoration: none;">
                        <b class="icon-print"></b>
                    </a> -->

                    <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#bersihkan_butirsoal">
                        <b class="icon-trash"></b>
                    </a>
                </div>
            </div>
            
            <!-- body -->
            <div class="row p-2 ml-2 justify-content-between align-items-center">
                <!-- mapel -->
                <div class="d-flex flex-column mb-1">
                    <?php
                        $id_pengampu = $soal['id_pengampu'];
                        $q_mapel = mysqli_query($conn, "SELECT * FROM tb_guru_pengampu JOIN tb_mapel ON tb_guru_pengampu.id_mapel = tb_mapel.id_mapel WHERE id_pengampu = '$id_pengampu'");
                        $mapel = $q_mapel->fetch_assoc();
                    ?>
                    <div style="font-weight: bold; font-size: 16pt;">
                        <?= $mapel['nama_mapel']; ?>
                    </div>
                    <div>
                        <span class="mr-2">Kelas <?= $mapel['tingkat']; ?></span>
                        <?php
                            $jur_q = mysqli_query($conn, "SELECT * FROM tb_pengampu_jur JOIN tb_jurusan ON tb_pengampu_jur.kode_jurusan = tb_jurusan.kode_jurusan WHERE id_pengampu = '$id_pengampu'");
                            while($j = $jur_q->fetch_assoc()):
                        ?>
                            <b class="icon-circle" style="color: <?= $j['warna_jurusan']; ?>;" title="<?= $j['nama_jurusan']; ?>"></b>
                        <?php endwhile; ?>
                    </div>
                </div>


                <!-- tombol tindakan -->
                <div class="d-flex justify-content-center">
                    <a href="#" class="mr-3">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#up_excel">Upload Butir Soal Excel</button>
                    </a>
                    <a href="#" class="mr-3">
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#up_pdf">Upload Butir Soal PDF</button>
                    </a>
                </div>
                
            </div>
        </div>

    </div>
 
    <!-- BUTIR SOAL -->
    <div class="pl-2 pt-2 pr-2 pb-0 border rounded bg-white">
    <!-- looping butir soal -->
    <!-- cek apakah ada butir pdf  -->
    <?php
        $q_pdf = mysqli_query($conn, "SELECT * FROM tb_butir_pdf WHERE kode_soal = '$kode_soal'");
        if(mysqli_num_rows($q_pdf) > 0):
            
                $filepdf = $q_pdf->fetch_assoc();
                $filepdf = $filepdf['nama_pdf'];
    ?>
                <div id="path" hidden>assets/img/media/<?= $filepdf; ?></div>
                <div id="viewpdf" class="mb-2" style="height: 700px;"></div>
                <script src="../PDFObject/pdfobject.min.js"></script>
                <script src="../jquery/jquery.min.js"></script>
                <script>
                    $("#icon-add").css("display","none");
                    var path = document.querySelector('#path').innerHTML;
                    var viewer = $('#viewpdf');
                    PDFObject.embed(path, viewer);
                </script>
        <?php
        else:
            $bs_q = mysqli_query($conn, "SELECT * FROM tb_pertanyaan WHERE kode_soal = '$kode_soal'");
            if(mysqli_num_rows($bs_q) > 0):
                while($bs = $bs_q->fetch_assoc()):
                    $id_Q = $bs['id_pertanyaan'];
        ?>
                <div class="d-flex flex-column p-2 mb-2" style="background-color: whitesmoke;">
                    <div class="d-flex justify-content-end">
                        <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#edit_butirsoal<?= $bs['id_pertanyaan']; ?>">
                            <b class="icon-cog"></b>
                        </a>
                        <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#del_butirsoal<?= $bs['id_pertanyaan']; ?>">
                            <b class="icon-remove"></b>
                        </a>
                    </div>
                    <div class="d-flex flex-column justify-content-start p-2">
                        <!-- tampil file -->
                        <?php
                            if(!empty($bs['media_pendukung'])){
                                
                                if(cekFile($bs['media_pendukung']) == "image"){
                        ?>
                            <div class="py-2">
                                <img src="assets/img/media/<?= $bs['media_pendukung']; ?>" alt="<?= $bs['media_pendukung']; ?>" style="max-height: 100px;">
                            </div>
                        <?php
                                }else{
                        ?>
                                    <audio class="py-2" controls>
                                        <source src="assets/img/media/<?= $bs['media_pendukung']; ?>">
                                    </audio>
                        <?php
                                }
                            }
                        ?>
                        <div class="mb-2">
                            <?= $bs['pertanyaan']; ?>
                        </div>

                        <ul class="pl-1" style="list-style: none;">
                        <!-- looping opsi jwb -->
                            <?php
                                $opsi_q = mysqli_query($conn, "SELECT * FROM tb_opsi_jwb WHERE id_pertanyaan = '$id_Q'");
                                while($opsi = $opsi_q->fetch_assoc()):
                            ?>
                                <li class="d-flex flex-column">
                                    <div>
                                        <!-- tampil file -->
                                        <?php
                                            if(!empty($opsi['media_pendukung'])){
                                                
                                                if(cekFile($opsi['media_pendukung']) == "image"){
                                        ?>
                                            <div class="py-2 ml-4">
                                                <img src="assets/img/media/<?= $opsi['media_pendukung']; ?>" alt="<?= $opsi['media_pendukung']; ?>" style="max-height: 100px;">
                                            </div>
                                        <?php
                                                }else{
                                        ?>
                                                    <audio class="py-2 ml-4" controls>
                                                        <source src="assets/img/media/<?= $opsi['media_pendukung']; ?>">
                                                    </audio>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <b class="icon-circle mr-2 <?php if($bs['kunci_jwb'] == $opsi['id_opsi']){echo "text-primary";}else{echo "text-secondary";} ?>"></b>
                                        <?= $opsi['opsi_jwb']; ?>
                                    </div>
                                </li>

                            <?php endwhile; ?>
                            
                        </ul>
                    </div>
                </div>


                <!-- Modal Edit Butir Soal-->
                <div class="modal fade" id="edit_butirsoal<?= $bs['id_pertanyaan']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Butir Soal</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                
                    <form action="" method="POST" enctype="multipart/form-data">
                    <?php
                        $e_bs_q = mysqli_query($conn, "SELECT * FROM tb_pertanyaan WHERE id_pertanyaan = '$id_Q'");
                        $e_bs = $e_bs_q->fetch_assoc();
                        $e_id_Q = $e_bs['id_pertanyaan'];
                    ?>
                        <input type="hidden" name="id_pertanyaan" value="<?= $e_id_Q; ?>">
                        <div class="modal-body">
                            <!-- pertanyaan -->
                            
                            <!-- isi pertanyaan -->
                            <div class="d-flex">
                                <textarea name="pertanyaan" id="" cols="30" rows="5" class="form-control mb-2 mr-1" style="width: 95%;" placeholder="Pertanyaan ketik disini" required><?= $e_bs['pertanyaan']; ?></textarea>
                                <!-- tombol media -->
                                <div class="d-flex flex-column">
                                    <label for="img<?= $e_id_Q; ?>" class="icon-sm "><b class="icon-image"></b></label>
                                    <input type="file" name="fileIMG" id="img<?= $e_id_Q; ?>" hidden>
                                    <label for="audio<?= $e_id_Q; ?>" class="icon-sm"><b class="icon-music"></b></label>
                                    <input type="file" name="fileAUD" id="audio<?= $e_id_Q; ?>" hidden>
                                </div>
                               
                            </div>

                        <!-- opsi1 -->
                        <?php
                            $idx = 1;
                            $e_opsi_q = mysqli_query($conn, "SELECT * FROM tb_opsi_jwb WHERE id_pertanyaan = '$e_id_Q'");
                            while($e_opsi = $e_opsi_q->fetch_assoc()):
                                $id_e_opsi = $e_opsi['id_opsi'];
                        ?>
                        <div class="d-flex align-items-start justify-content-center mb-2">
                            <input type="hidden" name="id_opsi<?= $idx; ?>" value="<?= $id_e_opsi; ?>">

                            <div class="form-check mr-2">
                                <input type="radio" class="form-check-input form-control" name="kunci" value="opsi<?= $idx; ?>" required <?php if($e_bs['kunci_jwb'] == $id_e_opsi){echo "checked";} ?>>
                            </div>

                            <input type="text" name="opsi<?= $idx; ?>" placeholder="Opsi pertama" class="form-control mr-2" id="" style="width: 95%;" value="<?= $e_opsi['opsi_jwb']; ?>" required>
                            <!-- tombol media -->
                            <div class="d-flex justify-content-center">
                                <label for="img_O<?= $e_id_Q; ?>" class="icon-sm mr-2"><b class="icon-image"></b></label>
                                <input type="file" name="fileIMG<?= $idx; ?>" id="img_O<?= $e_id_Q; ?>" hidden>
                                <label for="audio_O<?= $e_id_Q; ?>" class="icon-sm "><b class="icon-music"></b></label>
                                <input type="file" name="fileAUD<?= $idx; ?>" id="audio_O<?= $e_id_Q; ?>" hidden>
                            </div>

                        </div>
                        <?php 
                            $idx++; 
                            endwhile; 
                        ?>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" name="exc_edit_butir_soal" class="btn btn-info">Simpan Perubahan</button>
                        </div>
                    </form>
                    </div>
                </div>
                </div>

                <!-- Modal hapus -->
                <div class="modal" tabindex="-1" role="dialog" id="del_butirsoal<?= $bs['id_pertanyaan']; ?>">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Seriusan, hapus butir soal ini?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-footer">
                        <form action="" method="POST">
                            <input type="hidden" name="id_pertanyaan" value="<?= $bs['id_pertanyaan']; ?>">
                            <button type="submit" name="exc_del_butirsoal" class="btn btn-danger">Hapus</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </form>
                    </div>
                    </div>
                </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div style="background-color: whitesmoke;" class="p-3 text-center">Data tidak ada</div>
        <?php endif; ?>
    
        <!-- tombol tambah -->
        <div class="mb-2 d-flex justify-content-center align-items-center mx-auto rounded" style="background-color: whitesmoke;">
            <a href="#" class="icon-sm w-100 text-center p-2" style="text-decoration: none; font-size: x-large;" data-toggle="modal" data-target="#tambah_butirsoal">
                <b class="icon-plus"></b>
            </a>
        </div>
    <?php endif; ?>
    </div>

    
</div>




<!-- MODAL -->
<!-- Modal Tambah Butir Soal--> 
<div class="modal fade" id="tambah_butirsoal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Butir Soal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
 
      <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="kode_soal" value="<?= $_GET['id']; ?>">
        <div class="modal-body">
            <!-- pertanyaan -->
            <!-- jika ada file yang akan diupload -->
            <div id="img-prev"></div>
            <audio controls id="audio-prev" class="mb-1"></audio>

            <!-- isi pertanyaan -->
            <div class="d-flex">
                <textarea name="pertanyaan" id="" cols="30" rows="5" class="form-control mb-2 mr-1" style="width: 95%;" placeholder="Pertanyaan ketik disini" required></textarea>
                <!-- tombol media -->
                <div class="d-flex flex-column">
                    <label for="img" class="icon-sm "><b class="icon-image"></b></label>
                    <input type="file" name="fileIMG" id="img" hidden>
                    <label for="audio" class="icon-sm"><b class="icon-music"></b></label>
                    <input type="file" name="fileAUD" id="audio" hidden>
                </div>
           </div>

            <!-- opsi1 -->
            <!-- jika ada file yang akan diupload -->
            <div id="img-prev1"></div>
            <audio controls id="audio-prev1" class="mb-1"></audio>

            <div class="d-flex align-items-start justify-content-center mb-2">
                <div class="form-check mr-2">
                    <input type="radio" class="form-check-input form-control" name="kunci" value="opsi1" required>
                </div>
                <input type="text" name="opsi1" placeholder="Opsi pertama" class="form-control mr-2" id="" style="width: 95%;" required>
                <!-- tombol media -->
                <div class="d-flex justify-content-center">
                    <label for="img1" class="icon-sm mr-2"><b class="icon-image"></b></label>
                    <input type="file" name="fileIMG1" id="img1" hidden>
                    <label for="audio1" class="icon-sm "><b class="icon-music"></b></label>
                    <input type="file" name="fileAUD1" id="audio1" hidden>
                </div>
           </div>

           <!-- opsi2 -->
           <!-- jika ada file yang akan diupload -->
            <div id="img-prev2"></div>
            <audio controls id="audio-prev2" class="mb-1"></audio>

           <div class="d-flex align-items-start justify-content-center mb-2">
                <div class="form-check mr-2">
                    <input type="radio" class="form-check-input form-control" name="kunci" value="opsi2" required>
                </div>
                <input type="text" name="opsi2" placeholder="Opsi kedua" class="form-control mr-2" id="" style="width: 95%;" required>
                <!-- tombol media -->
                <div class="d-flex justify-content-center">
                    <label for="img2" class="icon-sm mr-2"><b class="icon-image"></b></label>
                    <input type="file" name="fileIMG2" id="img2" hidden>
                    <label for="audio2" class="icon-sm "><b class="icon-music"></b></label>
                    <input type="file" name="fileAUD2" id="audio2" hidden>
                </div>
           </div>

           <!-- opsi3 -->
           <!-- jika ada file yang akan diupload -->
            <div id="img-prev3"></div>
            <audio controls id="audio-prev3" class="mb-1"></audio>

           <div class="d-flex align-items-start justify-content-center mb-2">
                <div class="form-check mr-2">
                    <input type="radio" class="form-check-input form-control" name="kunci" value="opsi3" required>
                </div>
                <input type="text" name="opsi3" placeholder="Opsi ketiga" class="form-control mr-2" id="" style="width: 95%;" required>
                <!-- tombol media -->
                <div class="d-flex justify-content-center">
                    <label for="img3" class="icon-sm mr-2"><b class="icon-image"></b></label>
                    <input type="file" name="fileIMG3" id="img3" hidden>
                    <label for="audio3" class="icon-sm "><b class="icon-music"></b></label>
                    <input type="file" name="fileAUD3" id="audio3" hidden>
                </div>
           </div>

           <!-- opsi4 -->
           <!-- jika ada file yang akan diupload -->
           <div id="img-prev4"></div>
            <audio controls id="audio-prev4" class="mb-1"></audio>

           <div class="d-flex align-items-start justify-content-center mb-2">
                <div class="form-check mr-2">
                    <input type="radio" class="form-check-input form-control" name="kunci" value="opsi4" required>
                </div>
                <input type="text" name="opsi4" placeholder="Opsi keempat" class="form-control mr-2" id="" style="width: 95%;" required>
                <!-- tombol media -->
                <div class="d-flex justify-content-center">
                    <label for="img4" class="icon-sm mr-2"><b class="icon-image"></b></label>
                    <input type="file" name="fileIMG4" id="img4" hidden>
                    <label for="audio4" class="icon-sm "><b class="icon-music"></b></label>
                    <input type="file" name="fileAUD4" id="audio4" hidden>
                </div>
           </div>
           <!-- opsi5 -->
           <!-- jika ada file yang akan diupload -->
            <div id="img-prev5"></div>
            <audio controls id="audio-prev5" class="mb-1"></audio>

           <div class="d-flex align-items-start justify-content-center mb-2">
                <div class="form-check mr-2">
                    <input type="radio" class="form-check-input form-control" name="kunci" value="opsi5" required>
                </div>
                <input type="text" name="opsi5" placeholder="Opsi kelima" class="form-control mr-2" id="" style="width: 95%;" required>
                <!-- tombol media -->
                <div class="d-flex justify-content-center">
                    <label for="img5" class="icon-sm mr-2"><b class="icon-image"></b></label>
                    <input type="file" name="fileIMG5" id="img5" hidden>
                    <label for="audio5" class="icon-sm "><b class="icon-music"></b></label>
                    <input type="file" name="fileAUD5" id="audio5" hidden>
                </div>
           </div>
           
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" name="exc_add_butir_soal" class="btn btn-info">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>





<!-- Modal bersihkan -->
<div class="modal" tabindex="-1" role="dialog" id="bersihkan_butirsoal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Seriusan, bersihkan semua butir soal?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-footer">
        <form action="" method="POST">
            <input type="hidden" name="kode_soal" value="<?= $_GET['id']; ?>">
            <button type="submit" name="exc_bersihkan_butirsoal" class="btn btn-danger">Bersihkan</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </form>
      </div>
    </div>
  </div>
</div>



<!-- Modal upload excel -->
<div class="modal" tabindex="-1" role="dialog" id="up_excel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Upload Butir Soal Excel</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
            <a href="?cnt=soal_butir&id=<?= $_GET['id']; ?>&d_temp">
                <button type="button" class="btn btn-success mb-2">Download Template</button>
            </a>
            <input type="hidden" name="kode_soal" value="<?= $_GET['id']; ?>">
            <input type="file" name="file" class="form-control">
      </div>
      <div class="modal-footer">
            <button type="submit" name="exc_up_excel" class="btn btn-info">Upload</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
      </form>
    </div>
  </div>
</div>




<!-- Modal upload excel -->
<div class="modal" tabindex="-1" role="dialog" id="up_pdf">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Upload Butir Soal PDF</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
            <input type="hidden" name="kode_soal" value="<?= $_GET['id']; ?>">
            <input type="file" name="file" class="form-control mb-2" required>
            <input type="text" name="kunci_pdf" class="form-control mb-2" placeholder="Kunci jawaban. Ex: A,B,A,C..dst." required>
      </div>
      <div class="modal-footer">
            <button type="submit" name="exc_up_pdf" class="btn btn-info">Upload</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
      </form>
    </div>
  </div>
</div>