<div class="container py-3">
    <div class="d-flex justify-content-between align-items-center">
        <h3 class="text-info py-2" style="font-weight:bold;"><a href="?cnt=berita_acara">Berita Acara</a> > Siswa Absen</h3>
        <!-- <div class="d-flex">
            <a href="#" class="icon-sm px-2" style="text-decoration: none;" data-toggle="modal" data-target="#cari_siswa">
                <b class="icon-search"></b>
            </a>
        </div> -->
    </div>

    <div class="pl-2 pt-2 pr-2 pb-0 border rounded bg-white mb-3">
    <?php  
      $kode_soal = $_GET['kode'];
      // ambil data berita acara join soal
      $ba_q = $conn->query("SELECT * FROM tb_berita_acara JOIN tb_soal ON tb_berita_acara.kode_soal = tb_soal.kode_soal");
              // ambil data pengampu yang ada di tb soal berdasarkan kode soal
              $soal_q = $conn->query("SELECT * FROM tb_soal JOIN tb_guru_pengampu ON tb_soal.id_pengampu = tb_guru_pengampu.id_pengampu JOIN tb_jenis_ujian ON tb_soal.id_jenis_ujian = tb_jenis_ujian.id_jenis_ujian WHERE kode_soal = '$kode_soal'");
              $soal = $soal_q->fetch_assoc();
              $id_peng = $soal['id_pengampu'];

              // ambil data mapel yang ada di tb guru pengampu berdasarkan id pengampu
              $peng_q = $conn->query("SELECT * FROM tb_guru_pengampu JOIN tb_mapel ON tb_guru_pengampu.id_mapel = tb_mapel.id_mapel JOIN tb_guru ON tb_guru_pengampu.id_guru = tb_guru.id_guru WHERE tb_guru_pengampu.id_pengampu = '$id_peng'");
              $peng = $peng_q->fetch_assoc();
              $nama_mapel = $peng['nama_mapel'];
      ?>
        <!-- card mapel -->
        <div class="rounded p-2 mb-2" style="background-color:whitesmoke;">
            <!-- title -->
            <div class="d-flex justify-content-between align-items-start">
                <div class="row align-items-center w-75  ml-1">
                    <div class="px-1 mr-2 mb-1 border rounded bg-warning">
                       <b><?= $kode_soal; ?></b>
                    </div>
                    <small><?= $soal['jenis_ujian']; ?></small>
                </div>
                <!-- <div class="d-flex p-2">
                    <a href="#" class="icon-sm px-2" style="text-decoration: none;">
                        <b class="icon-print"></b>
                    </a>
                </div> -->
            </div>
             
            <!-- body -->
            <div class="row p-2 ml-2 justify-content-between align-items-end">
                <!-- mapel -->
                <div class="d-flex flex-column mb-1">
                    <div style="font-weight: bold; font-size: 16pt;"><?= $nama_mapel; ?></div>
                    <div>
                        <span class="mr-2">Kelas <?= $peng['tingkat']; ?></span>
                        <?php
                            // ambil jurusan berdasarkan id pengampu
                            $jur_peng_q = $conn->query("SELECT * FROM tb_pengampu_jur JOIN tb_jurusan ON tb_pengampu_jur.kode_jurusan = tb_jurusan.kode_jurusan WHERE id_pengampu = '$id_peng'");
                            while($jur = $jur_peng_q->fetch_assoc()):
                        ?>
                            <b class="icon-circle" title="<?= $jur['nama_jurusan']; ?>" style="color: <?= $jur['warna_jurusan']; ?>;"></b>
                        <?php endwhile; ?>
                    </div>
                </div>
                <!-- <select name="kelas" id="" class="form-control w-auto mr-3">
                    <option value="">Semua</option>
                    <option value="">X MM 1</option>
                    <option value="">X MM 2</option>
                </select> -->
            </div>
        </div>
    </div>


    <!-- cari jumlah siswa absen -->
    <?php
        // cari id pengampu
        $soal_q = $conn->query("SELECT * FROM tb_soal JOIN tb_guru_pengampu ON tb_soal.id_pengampu = tb_guru_pengampu.id_pengampu JOIN tb_jenis_ujian ON tb_soal.id_jenis_ujian = tb_jenis_ujian.id_jenis_ujian WHERE kode_soal = '$kode_soal'");
        $soal = $soal_q->fetch_assoc();
        $id_peng = $soal['id_pengampu'];

        // ambil data mapel yang ada di tb guru pengampu berdasarkan id pengampu
        $peng_q = $conn->query("SELECT * FROM tb_guru_pengampu JOIN tb_mapel ON tb_guru_pengampu.id_mapel = tb_mapel.id_mapel JOIN tb_guru ON tb_guru_pengampu.id_guru = tb_guru.id_guru WHERE tb_guru_pengampu.id_pengampu = '$id_peng'");
        $peng = $peng_q->fetch_assoc();
        $nama_mapel = $peng['nama_mapel'];

        // amil semua data siswa sesuai kode soal
        $semua_siswa = [];
        $siswa_q = $conn->query("SELECT * FROM tb_siswa JOIN tb_kelas ON tb_siswa.id_kelas = tb_kelas.id_kelas");
        while($siswa = $siswa_q->fetch_assoc()):
            if($siswa['tingkat'] == $peng['tingkat']){
                $jur_sw_q = $conn->query("SELECT * FROM tb_pengampu_jur JOIN tb_jurusan ON tb_pengampu_jur.kode_jurusan = tb_jurusan.kode_jurusan WHERE id_pengampu = '$id_peng'");
                while($jur_sw = $jur_sw_q->fetch_assoc()):
                    if($siswa['kode_jurusan'] == $jur_sw['kode_jurusan']){
                        $semua_siswa[] = $siswa['nomor_peserta'];
                    }
                endwhile;
            }
        endwhile;

        $siswa_mengerjakan = [];
        // ambil data siswa yang mengerjakan
        $siswa_ujian_q = $conn->query("SELECT * FROM tb_stt_siswa_login JOIN tb_siswa ON tb_stt_siswa_login.nomor_peserta = tb_siswa.nomor_peserta WHERE kode_soal = '$kode_soal'");
        while($siswa_ujian = $siswa_ujian_q->fetch_assoc()){
            $siswa_mengerjakan[] = $siswa_ujian['nomor_peserta'];
        }

        $siswa_absen = [];
        // cocokan semua siswa dengan siswa yang mengerjakan
        foreach($semua_siswa as $sw){
            if(!in_array($sw, $siswa_mengerjakan)){
                $siswa_absen[] = $sw;
            }
        }
    ?>
    <div class="w-100 overflow-auto">
    <table class="table table-striped bg-white" id="siswa-absen">
    <thead>
        <tr>
            <th scope="col" class="text-info">Nama</th>
            <th scope="col" class="text-info">Nomor</th>
            <th scope="col" class="text-info">Kelas</th>
        </tr>
    </thead>
    <tbody>
      <?php
          if(count($siswa_absen) > 0):
              foreach($siswa_absen as $sw):
                  $siswa_q = $conn->query("SELECT * FROM tb_siswa JOIN tb_kelas ON tb_siswa.id_kelas = tb_kelas.id_kelas WHERE nomor_peserta = '$sw'");
                  $siswa = $siswa_q->fetch_assoc();
          ?>
        <tr>
            <th scope="row" class="w-50"><?= $siswa['nama_siswa']; ?></th>
            <td><?= $siswa['nomor_peserta']; ?></td>
            <td><?= $siswa['nama_kelas']; ?></td>
        </tr>
        <?php endforeach; ?>
      <?php else: ?>
          <tr>
              <td colspan="3" class="text-center">Tidak ada siswa absen</td>
          </tr>
      <?php endif; ?>
    </tbody>
    </table>
    </div>
</div>





