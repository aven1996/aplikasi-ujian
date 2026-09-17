<!-- upload multiple file -->
<?php
    if(isset($_POST['exc_add_media'])){
        global $conn;
        
        $jmlFile = count($_FILES['media_add']['name']);
        $no_match = [];
        $match = [];

        for($i = 0; $i < $jmlFile; $i++)
        {
            $namaFile = "media_add/".$_FILES['media_add']['name'][$i];
            $ukuranFile = $_FILES['media_add']['size'][$i];
            $errorFile = $_FILES['media_add']['error'][$i];
            $tmpName = $_FILES['media_add']['tmp_name'][$i];

            // cek jenis file //output image / audio
            $jenisFile = cekFile($namaFile);

            // validasi file yang akan diupload
            if($errorFile === 4){
                echo "<script>
                        alert('File belum dipilih!');
                    </script>";
            }elseif($jenisFile == "bukan image/audio"){
                $error = "File yang kamu upload tidak valid! Jika file audio hanya boleh berekstensi .mp3 atau .wav"; 
                echo "<script>
                        alert('$error');
                    </script>";
            }elseif($ukuranFile > 3000000 ){
                echo "<script>
                        alert('Ukuran file maksimal 3 MB!');
                    </script>";
            }else{

                // cek kecocokan nama
                $nama_DB_Q = mysqli_query($conn, "SELECT * FROM tb_pertanyaan WHERE media_pendukung = '$namaFile'");
                $nama_DB_O = mysqli_query($conn, "SELECT * FROM tb_opsi_jwb WHERE media_pendukung = '$namaFile'");
                if(mysqli_num_rows($nama_DB_Q) > 0){
                    // jika match di tabel pertanyaan
                    $match[] = $namaFile;
                    move_uploaded_file($tmpName, 'assets/img/media/'.$namaFile);
                }elseif(mysqli_num_rows($nama_DB_O) > 0){
                    //jika match di tabel opsi jwb
                    $match[] = $namaFile;
                    move_uploaded_file($tmpName, 'assets/img/media/'.$namaFile);
                }else{
                    // jika tidak ada yang cocok/match
                    $no_match[] = $namaFile;
                }

            }

        }
        echo "<script> alert(' ".count($match)." File berhasil diupload! ". count($no_match)." File tidak cocok! [". implode(",",$no_match) ."] '); </script>";

    }

// bersihkan file media pendukung
if(isset($_POST['exc_bersihkan_media'])){
    $files = glob("assets/img/media/media_add/*");
    foreach ($files as $f) {
            unlink($f);
    }
    echo "<script> alert('File berhasil dibersihkan!'); </script>";
}


?>