<?php
    // ambil data petugas
    if(isset($_SESSION['petugas'])){
        if($_SESSION['petugas'] == "admin"){
            $user_admin = $_SESSION['user']; 
            $query_petugas = mysqli_query($conn, "SELECT * FROM tb_admin WHERE username_admin = '$user_admin'");
            $petugas_q = $query_petugas->fetch_assoc();
            $petugas = $petugas_q['username_admin'];
            $id_petugas = $petugas_q['id_admin'];
        }else{
            $user_guru = $_SESSION['user'];
            $query_petugasX = mysqli_query($conn, "SELECT * FROM tb_guru WHERE username_guru = '$user_guru' ");
            $petugas_q = $query_petugasX->fetch_assoc();
            $petugas = $petugas_q['nama_guru'];
            $id_petugas = $petugas_q['id_guru'];
        }

    }
 

    // fungsi upload file
    function upload_file($jenis_file,$tabel,$field){
		$namaFile = $_FILES['file']['name'];
		$ukuranFile = $_FILES['file']['size'];
		$errorFile = $_FILES['file']['error'];
		$tmpName = $_FILES['file']['tmp_name'];

        // identifikasikan jenis file
        if($jenis_file == "image"){
            $extensiFileValid = ['jpg','jpeg','png','gif','svg'];
        }elseif($jenis_file == "audio"){
            $extensiFileValid = ['mp3','wav'];
        }elseif($jenis_file == "dokumen"){
            $extensiFileValid = ['doc','docx','xls','xlsx','pdf'];
        }

		// ambil ekstensi file 
		$extensiFile = explode('.', $namaFile);
		$extensiFile = strtolower(end($extensiFile));

		// ambil nama file dari DB ( untuk mengecek ada kesamaan nama atau tidak)
		global $conn;
		$namaFileDB = mysqli_query($conn, "SELECT $field FROM $tabel WHERE $field = '$namaFile' ");

		// validasi gambar sudah dipilih apa belum
		if ($errorFile === 4) {
			$error = "File belum dipilih!"; 
			echo "<script>
					alert('$error');
				</script>";

        // validasi jenis file sudah sesuai apa belum
		}elseif(!in_array($extensiFile, $extensiFileValid)){
			$error = "File yang kamu upload tidak valid! File Audio harus berekstensi .mp3 atau .wav"; 
			echo "<script>
					alert('$error');
				</script>";

        // validasi ukuran file
		}elseif( $ukuranFile > 3000000 ){
			echo "<script>
					alert('Ukuran file maksimal 3 MB!');
				</script>";

		}else{
            // jika ada kesamaan nama maka otomatis akan direname
			if (mysqli_num_rows($namaFileDB) > 0){
                $AmbilnamaFileDB = tampilQuery("SELECT $field FROM $tabel WHERE $field = '$namaFile' ")[0];
                $AmbilnamaFileDB = $AmbilnamaFileDB[$field];
                // ambil nama file tanpa extensi
                // pisah jadi array
                $namaFileDBArray = explode(".", $AmbilnamaFileDB);
                // ambil index paling belakang (ekstensinya)
                $nama_depan = array_search(end($namaFileDBArray), $namaFileDBArray);
                // hapus item index tersebut
                unset($namaFileDBArray[$nama_depan]);
                // nama tanpa ekstensi
                $namaFileDBnotExtensi = implode("", $namaFileDBArray);
                // rename dengan menambhkan angka random dan ektensi
                $namaFileBaru = $namaFileDBnotExtensi.'_'.rand(1,100).'.'.$extensiFile;

			}elseif(mysqli_num_rows($namaFileDB) == 0){
                // jika tidak ada kesamaan maka gunakan nama yang sama
					$namaFileBaru = $namaFile;

			}
            // proses upload file dengan nama yang sudah diolah
            if($tabel == "tb_profil"){
                $result = move_uploaded_file($tmpName, 'assets/img/profil_smk/'.$namaFileBaru);
            }else{
                $result = move_uploaded_file($tmpName, 'assets/img/media/'.$namaFileBaru);
            }
			

            // output berupa array [namafile, ekstensi]
			return $array = [$namaFileBaru,$extensiFile];

		}
	}



// fungsi upload file dokumen
function upload_file_add($jenis_file,$tabel,$field){
    $namaFile = $_FILES['file']['name'];
    $ukuranFile = $_FILES['file']['size'];
    $errorFile = $_FILES['file']['error'];
    $tmpName = $_FILES['file']['tmp_name'];

    // identifikasikan jenis file
    if($jenis_file == "image"){
        $extensiFileValid = ['jpg','jpeg','png','gif','svg'];
    }elseif($jenis_file == "audio"){
        $extensiFileValid = ['mp3','wav'];
    }elseif($jenis_file == "dokumen"){
        $extensiFileValid = ['doc','docx','xls','xlsx','pdf'];
    }

    // ambil ekstensi file 
    $extensiFile = explode('.', $namaFile);
    $extensiFile = strtolower(end($extensiFile));

    // ambil nama file dari DB ( untuk mengecek ada kesamaan nama atau tidak)
    global $conn;
    $namaFileDB = mysqli_query($conn, "SELECT $field FROM $tabel WHERE $field = 'media_add/$namaFile' ");

    // validasi gambar sudah dipilih apa belum
    if ($errorFile === 4) {
        $error = "File belum dipilih!"; 
        echo "<script>
                alert('$error');
            </script>";

    // validasi jenis file sudah sesuai apa belum
    }elseif(!in_array($extensiFile, $extensiFileValid)){
        $error = "File yang kamu upload tidak valid! Jika file audio hanya boleh berekstensi .mp3 atau .wav"; 
        echo "<script>
                alert('$error');
            </script>";

    // validasi ukuran file
    }elseif( $ukuranFile > 3000000 ){
        echo "<script>
                alert('Ukuran file maksimal 3 MB!');
            </script>";

    }else{
        // jika ada kesamaan nama maka otomatis akan direname
        if (mysqli_num_rows($namaFileDB) > 0){
            $AmbilnamaFileDB = tampilQuery("SELECT $field FROM $tabel WHERE $field = 'media_add/$namaFile' ")[0];
            $AmbilnamaFileDB = $AmbilnamaFileDB[$field];
            // ambil nama file tanpa extensi
            // pisah jadi array
            $namaFileDBArray = explode(".", $AmbilnamaFileDB);
            // ambil index paling belakang (ekstensinya)
            $nama_depan = array_search(end($namaFileDBArray), $namaFileDBArray);
            // hapus item index tersebut
            unset($namaFileDBArray[$nama_depan]);
            // nama tanpa ekstensi
            $namaFileDBnotExtensi = implode("", $namaFileDBArray);
            // rename dengan menambhkan angka random dan ektensi
            $namaFileBaru = $namaFileDBnotExtensi.'_'.rand(1,100).'.'.$extensiFile;

        }elseif(mysqli_num_rows($namaFileDB) == 0){
            // jika tidak ada kesamaan maka gunakan nama yang sama
                $namaFileBaru = "media_add/".$namaFile;
        }
        // proses upload file dengan nama yang sudah diolah
       
        move_uploaded_file($tmpName, 'assets/img/media/'.$namaFileBaru);
        
        // output berupa array [namafile, ekstensi]
        return [$namaFileBaru,$extensiFile];

    }
}


// cek dan rename nama file
function autoRename($namaFile, $tabel, $attr){
    global $conn;
    $q = mysqli_query($conn, "SELECT * FROM $tabel WHERE $attr = '$namaFile'");
    
    if(mysqli_num_rows($q) > 0){
        $AmbilnamaFileDB = $namaFile;
        $namaFileDBArray = explode(".", $AmbilnamaFileDB);
        // ambil index paling belakang (ekstensinya)
        $index_ex = array_search(end($namaFileDBArray), $namaFileDBArray);
        // ekstensi file
        $extensiFile = $namaFileDBArray[$index_ex];
        // hapus item index tersebut
        unset($namaFileDBArray[$index_ex]);
        // nama tanpa ekstensi
        $namaFileDBnotExtensi = implode("", $namaFileDBArray);
        // rename dengan menambhkan angka random dan ektensi
        $namaFileBaru = $namaFileDBnotExtensi.'_'.rand(1,100).'.'.$extensiFile;
        return [$namaFileBaru, "rename"];
    }else{
        return [$namaFile, "original"];
    }
}

    // tampil data dengan query
    function tampilQuery($query){
		global $conn;
		$table = mysqli_query($conn, $query);
		$rows = [];
		while ($row = mysqli_fetch_assoc($table)) {
			$rows[] = $row;
		}
		return $rows;
	}

    // jumlah row spesifik
    function jmlRowsById($namaTbl,$idField,$id){
		global $conn;
		$jml = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM $namaTbl WHERE $idField = '$id'"));

		return $jml;
	}


    // cek file
    function cekFile($file){
        $eks_img = ['jpg','jpeg','png','gif','svg'];
        $eks_audio = ['mp3','wav'];
        // buat array
        $eks_file = explode(".", $file);
        // cari index item terakhir
        $index_eks = array_search(end($eks_file),$eks_file);
        // ambil item berdasarkan index tersebut
        $ex = $eks_file[$index_eks];

        if(in_array($ex, $eks_img)){
            return "image";
        }elseif(in_array($ex, $eks_audio)){
            return "audio";
        }else{
            return "bukan image/audio";
        }

    }




// function upload file
function upload_file_bs($name, $jenis_file, $tabel, $field){
    $namaFile = $_FILES[$name]['name'];
    $ukuranFile = $_FILES[$name]['size'];
    $errorFile = $_FILES[$name]['error'];
    $tmpName = $_FILES[$name]['tmp_name'];

    // identifikasikan jenis file
    if($jenis_file == "image"){
        $extensiFileValid = ['jpg','jpeg','png','gif','svg'];
    }elseif($jenis_file == "audio"){
        $extensiFileValid = ['mp3','wav'];
    }elseif($jenis_file == "dokumen"){
        $extensiFileValid = ['doc','docx','xls','xlsx','pdf'];
    }elseif($jenis_file == "media_butirsoal"){
        $extensiFileValid = ['jpg','jpeg','png','gif','svg','mp3','wav'];
    }

    // ambil ekstensi file 
    $extensiFile = explode('.', $namaFile);
    $extensiFile = strtolower(end($extensiFile));

    // ambil nama file dari DB ( untuk mengecek ada kesamaan nama atau tidak)
    global $conn;
    $namaFileDB = mysqli_query($conn, "SELECT $field FROM $tabel WHERE $field = '$namaFile' ");

    // validasi gambar sudah dipilih apa belum
    if ($errorFile === 4) {
        $error = "File belum dipilih!"; 
        echo "<script>
                alert('$error');
            </script>";

    // validasi jenis file sudah sesuai apa belum
    }elseif(!in_array($extensiFile, $extensiFileValid)){
        $error = "File yang kamu upload tidak valid! Jika file audio hanya boleh berekstensi .mp3 atau .wav"; 
        echo "<script>
                alert('$error');
            </script>";

    // validasi ukuran file
    }elseif( $ukuranFile > 3000000 ){
        echo "<script>
                alert('Ukuran file maksimal 3 MB!');
            </script>";

    }else{
        // jika ada kesamaan nama maka otomatis akan direname
        if (mysqli_num_rows($namaFileDB) > 0){
            $AmbilnamaFileDB = tampilQuery("SELECT $field FROM $tabel WHERE $field = '$namaFile' ")[0];
            $AmbilnamaFileDB = $AmbilnamaFileDB[$field];
            // ambil nama file tanpa extensi
            // pisah jadi array
            $namaFileDBArray = explode(".", $AmbilnamaFileDB);
            // ambil index paling belakang (ekstensinya)
            $nama_depan = array_search(end($namaFileDBArray), $namaFileDBArray);
            // hapus item index tersebut
            unset($namaFileDBArray[$nama_depan]);
            // nama tanpa ekstensi
            $namaFileDBnotExtensi = implode("", $namaFileDBArray);
            // rename dengan menambhkan angka random dan ektensi
            $namaFileBaru = $namaFileDBnotExtensi.'_'.rand(1,100).'.'.$extensiFile;

        }elseif(mysqli_num_rows($namaFileDB) == 0){
            // jika tidak ada kesamaan maka gunakan nama yang sama
                $namaFileBaru = $namaFile;

        }
        // proses upload file dengan nama yang sudah diolah
        if($tabel == "tb_profil"){
            $result = move_uploaded_file($tmpName, 'assets/img/profil_smk/'.$namaFileBaru);
        }else{
            $result = move_uploaded_file($tmpName, 'assets/img/media/'.$namaFileBaru);
        }
        

        // output berupa array [namafile, ekstensi]
        return $array = [$namaFileBaru,$extensiFile];

    }
}





// function menghitung nilai
function cekNilai($kode, $nomor){
    global $conn;
    // cek terlebih dahulu apakah soal berisikan pdf
    $soalPDF_q = $conn->query("SELECT * FROM tb_butir_pdf WHERE kode_soal = '$kode'");
    if(mysqli_num_rows($soalPDF_q) > 0){
        // jadikan kunci soal pdf menjadi array
        $soalPDF = $soalPDF_q->fetch_assoc();
        $soalPDF = explode(",",$soalPDF['kunci_jwb']);

        // ambil data jawaban pdf dan looping
        $jwbPDF_q = $conn->query("SELECT * FROM tb_jawaban_pdf WHERE nomor_peserta = '$nomor' AND kode_soal = '$kode'");
        $nilai = 0;
        $index_soalPDF = 0;
        if(mysqli_num_rows($jwbPDF_q) > 0){
            for($i = 0; $i < mysqli_num_rows($jwbPDF_q); $i++){
                $jwbPDF_qx = $conn->query("SELECT * FROM tb_jawaban_pdf WHERE nomor_peserta = '$nomor' AND kode_soal = '$kode' AND id_btr_pdf = '$i'");
                $jwbPDF = $jwbPDF_qx->fetch_assoc();
                // conversi index angka jadi huruf
                if($jwbPDF['jawaban_pdf'] == 1){
                    $jwbPDF = "A";
                }elseif($jwbPDF['jawaban_pdf'] == 2){
                    $jwbPDF = "B";
                }elseif($jwbPDF['jawaban_pdf'] == 3){
                    $jwbPDF = "C";
                }elseif($jwbPDF['jawaban_pdf'] == 4){
                    $jwbPDF = "D";
                }elseif($jwbPDF['jawaban_pdf'] == 5){
                    $jwbPDF = "E";
                }

                if($jwbPDF == $soalPDF[$index_soalPDF]){
                    $nilai++;
                }
                $index_soalPDF++;
            }
            // cek apakah set balance(cari nilai akhir) sedang aktif
            $lap_q = $conn->query("SELECT * FROM tb_laporan WHERE kode_soal = '$kode'");
            $lap = $lap_q->fetch_assoc();
            if($lap['set_balance'] == "Ya"){
                return $nilai = $nilai/count($soalPDF)*100;
            }else{
                return $nilai;
            }
        }else{
            return $nilai;
        }
    }else{
        $nilai = 0;
        $jwb_sw_q = $conn->query("SELECT * FROM tb_jawaban WHERE kode_soal = '$kode' AND nomor_peserta = '$nomor'");
        if(mysqli_num_rows($jwb_sw_q) > 0){
            while($jwb_sw = $jwb_sw_q->fetch_assoc()){
                $id_quest = $jwb_sw['id_pertanyaan'];
                $quest_q = $conn->query("SELECT * FROM tb_pertanyaan WHERE kode_soal = '$kode' AND id_pertanyaan = '$id_quest'");
                $quest = $quest_q->fetch_assoc();
                if($jwb_sw['jawaban'] == $quest['kunci_jwb']){
                    $nilai++;
                }
            }

            // cek apakah set balance(cari nilai akhir) sedang aktif
            $lap_q = $conn->query("SELECT * FROM tb_laporan WHERE kode_soal = '$kode'");
            $lap = $lap_q->fetch_assoc();
            if($lap['set_balance'] == "Ya"){
                $jml_quest_q = $conn->query("SELECT * FROM tb_pertanyaan WHERE kode_soal = '$kode'");
                return $nilai = $nilai/mysqli_num_rows($jml_quest_q)*100;
            }else{
                return $nilai;
            }
        }else{
            return $nilai;
        }
    }
}


// setting admin
if(isset($_POST['exc_setting'])){
    $user = htmlspecialchars($_POST['username']);
    $pass = htmlspecialchars($_POST['password']);
    if(!empty($pass)){
        $pass = password_hash($pass, PASSWORD_DEFAULT);
        $conn->query("UPDATE tb_admin SET username_admin = '$user', password_admin = '$pass'");
        if(mysqli_affected_rows($conn) > 0){
            echo "<script>
                    alert('Perubahan berhasil disimpan!');
                </script>";
        }
        
    }else{
        $conn->query("UPDATE tb_admin SET username_admin = '$user'");
        if(mysqli_affected_rows($conn) > 0){
            echo "<script>
                    alert('Perubahan berhasil disimpan!');
                </script>";
        }
    }
}

?>