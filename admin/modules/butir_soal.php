<?php
// tambah butir soal
    if(isset($_POST['exc_add_butir_soal'])){
        $kode_soal = $_POST['kode_soal'];
        $pertanyaan = htmlspecialchars($_POST['pertanyaan']);
 
        // validasi ada 2 file yg terlampir
        if(!empty($_FILES['fileIMG']['name']) AND !empty($_FILES['fileAUD']['name'])){
            echo "<script> alert('Maaf, hanya dapat melampirkan 1 file gambar/audio'); </script>";
        }elseif(!empty($_FILES['fileIMG1']['name']) AND !empty($_FILES['fileAUD1']['name'])){
            echo "<script> alert('Maaf, hanya dapat melampirkan 1 file gambar/audio'); </script>";
        }elseif(!empty($_FILES['fileIMG2']['name']) AND !empty($_FILES['fileAUD2']['name'])){
            echo "<script> alert('Maaf, hanya dapat melampirkan 1 file gambar/audio'); </script>";
        }elseif(!empty($_FILES['fileIMG3']['name']) AND !empty($_FILES['fileAUD3']['name'])){
            echo "<script> alert('Maaf, hanya dapat melampirkan 1 file gambar/audio'); </script>";
        }elseif(!empty($_FILES['fileIMG4']['name']) AND !empty($_FILES['fileAUD4']['name'])){
            echo "<script> alert('Maaf, hanya dapat melampirkan 1 file gambar/audio'); </script>";
        }elseif(!empty($_FILES['fileIMG5']['name']) AND !empty($_FILES['fileAUD5']['name'])){
            echo "<script> alert('Maaf, hanya dapat melampirkan 1 file gambar/audio'); </script>";
        }else{
            // input pertanyaan
            $fileQ = "";
            $kunci_tmp = $_POST['kunci'];
            if(!empty($_FILES['fileIMG']['name'])){
                $fileQ = upload_file_bs("fileIMG","image","tb_pertanyaan","media_pendukung")[0];
            }elseif(!empty($_FILES['fileAUD']['name'])){
                $fileQ = upload_file_bs("fileAUD","audio","tb_pertanyaan","media_pendukung")[0];
            }
            
            $q_pertanyaan = mysqli_query($conn, "INSERT INTO tb_pertanyaan VALUES ('','$kode_soal','$pertanyaan','$fileQ','$kunci_tmp')");

            if(mysqli_affected_rows($conn) > 0){
                // jika data pertanyaan berhasil diinput
                // input opsi tp sblumnya ambil id pertanyaan
                $idQ  = tampilQuery("SELECT MAX(id_pertanyaan) FROM tb_pertanyaan ")[0]['MAX(id_pertanyaan)'];
                $Q = tampilQuery("SELECT * FROM tb_pertanyaan WHERE id_pertanyaan = '$idQ'")[0];
                $kunciQ = $Q['kunci_jwb'];
                
                for($i = 1; $i < 6; $i++){
                    $file = "";
                    if(!empty($_FILES['fileIMG'.$i]['name'])){
                        $file = upload_file_bs("fileIMG$i","image","tb_pertanyaan","media_pendukung")[0];
                    }elseif(!empty($_FILES['fileAUD'.$i]['name'])){
                        $file = upload_file_bs("fileAUD$i","audio","tb_pertanyaan","media_pendukung")[0];
                    }

                    // input opsi jwb
                    $opsi = htmlspecialchars($_POST['opsi'.$i]);
                    mysqli_query($conn, "INSERT INTO tb_opsi_jwb VALUES ('','$idQ','$opsi','$file')");
                    // update kunci jwb di pertanyaan sesuai id opsi
                    if(mysqli_affected_rows($conn) > 0){
                        if($kunciQ == "opsi$i"){
                            $idO = tampilQuery("SELECT MAX(id_opsi) FROM tb_opsi_jwb")[0]['MAX(id_opsi)'];
                            
                            mysqli_query($conn, "UPDATE tb_pertanyaan SET kunci_jwb = '$idO' WHERE id_pertanyaan = '$idQ' ");

                            if(mysqli_affected_rows($conn) > 0){
                                echo "<script> alert('Butir soal berhasil ditambahkan!'); </script>";
                            }
                        }
                    }
                }
            }
        }
    }




// edit butir soal
if(isset($_POST['exc_edit_butir_soal'])){
    $id_pertanyaan = $_POST['id_pertanyaan'];
    $pertanyaan = htmlspecialchars($_POST['pertanyaan']);

    // validasi ada 2 file yg terlampir
    if(!empty($_FILES['fileIMG']['name']) AND !empty($_FILES['fileAUD']['name'])){
        echo "<script> alert('Maaf, hanya dapat melampirkan 1 file gambar/audio'); </script>";
    }elseif(!empty($_FILES['fileIMG1']['name']) AND !empty($_FILES['fileAUD1']['name'])){
        echo "<script> alert('Maaf, hanya dapat melampirkan 1 file gambar/audio'); </script>";
    }elseif(!empty($_FILES['fileIMG2']['name']) AND !empty($_FILES['fileAUD2']['name'])){
        echo "<script> alert('Maaf, hanya dapat melampirkan 1 file gambar/audio'); </script>";
    }elseif(!empty($_FILES['fileIMG3']['name']) AND !empty($_FILES['fileAUD3']['name'])){
        echo "<script> alert('Maaf, hanya dapat melampirkan 1 file gambar/audio'); </script>";
    }elseif(!empty($_FILES['fileIMG4']['name']) AND !empty($_FILES['fileAUD4']['name'])){
        echo "<script> alert('Maaf, hanya dapat melampirkan 1 file gambar/audio'); </script>";
    }elseif(!empty($_FILES['fileIMG5']['name']) AND !empty($_FILES['fileAUD5']['name'])){
        echo "<script> alert('Maaf, hanya dapat melampirkan 1 file gambar/audio'); </script>";
    }else{
        // input pertanyaan
        $fileQ = "";
        $kunci_tmp = $_POST['kunci'];
        if(!empty($_FILES['fileIMG']['name'])){
            $fileQ = upload_file_bs("fileIMG","image","tb_pertanyaan","media_pendukung")[0];
        }elseif(!empty($_FILES['fileAUD']['name'])){
            $fileQ = upload_file_bs("fileAUD","audio","tb_pertanyaan","media_pendukung")[0];
        }
        
        $q_pertanyaan = mysqli_query($conn, "UPDATE tb_pertanyaan SET pertanyaan = '$pertanyaan', media_pendukung = '$fileQ', kunci_jwb = '$kunci_tmp' WHERE id_pertanyaan = '$id_pertanyaan' ");

        // jika data pertanyaan berhasil diinput
        // input opsi tp sblumnya ambil id pertanyaan
        $Q = tampilQuery("SELECT * FROM tb_pertanyaan WHERE id_pertanyaan = '$id_pertanyaan'")[0];
        $kunciQ = $Q['kunci_jwb'];
        
        for($i = 1; $i < 6; $i++){
            $file = "";
            if(!empty($_FILES['fileIMG'.$i]['name'])){
                $file = upload_file_bs("fileIMG$i","image","tb_pertanyaan","media_pendukung")[0];
            }elseif(!empty($_FILES['fileAUD'.$i]['name'])){
                $file = upload_file_bs("fileAUD$i","audio","tb_pertanyaan","media_pendukung")[0];
            }

            // input opsi jwb
            $id_opsi = $_POST['id_opsi'.$i];
            $opsi = htmlspecialchars($_POST['opsi'.$i]);
            mysqli_query($conn, "UPDATE tb_opsi_jwb SET opsi_jwb = '$opsi', media_pendukung = '$file' WHERE id_opsi = '$id_opsi'");

            // update kunci jwb di pertanyaan sesuai id opsi
            if($kunciQ == "opsi$i"){

                mysqli_query($conn, "UPDATE tb_pertanyaan SET kunci_jwb = '$id_opsi' WHERE id_pertanyaan = '$id_pertanyaan' ");
                
                echo "<script> alert('Butir soal berhasil diperbarui!'); </script>";
                
            }
            
        }
        
    }
}


// hapus butir soal
if(isset($_POST['exc_del_butirsoal'])){
    $id = $_POST['id_pertanyaan'];
    mysqli_query($conn, "DELETE FROM tb_pertanyaan WHERE id_pertanyaan = '$id' ");
    if(mysqli_affected_rows($conn) > 0){
        echo "<script> alert('Butir soal berhasil dihapus!'); </script>";
    }
}

// bersihkan butir soal
if(isset($_POST['exc_bersihkan_butirsoal'])){
    $kode_soal = $_POST['kode_soal'];
    mysqli_query($conn, "DELETE FROM tb_pertanyaan WHERE kode_soal = '$kode_soal' ");
    mysqli_query($conn, "DELETE FROM tb_butir_pdf WHERE kode_soal = '$kode_soal' ");
    if(mysqli_affected_rows($conn) > 0){
        echo "<script> alert('Butir soal berhasil dibersihkan!'); </script>";
    }
}



// download excel
if(isset($_GET['d_temp'])){
    $file = "assets/contoh_format_soal.xlsx";
    header('Content-Description:File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: private');
    header('Pragma: private');
    header('Content-Length:'.filesize($file));
    ob_clean();
    flush();
    readfile($file);
}








// proses tambah butir soal EXCEL

if (isset($_POST['exc_up_excel'])) {
    $kode_soal = $_POST['kode_soal'];
    $q_bs_pdf = mysqli_query($conn, "SELECT * FROM tb_butir_pdf WHERE kode_soal = '$kode_soal'");
    if(mysqli_num_rows($q_bs_pdf) > 0){
        echo "<script> alert('Tidak bisa upload butir soal PDF, bersihkan butir soal terlebih dahulu!'); </script>";
    }else{
        $up_excel = upload_file_add("dokumen","tb_dokumen","nama_dokumen");
        $nama = $up_excel[0];
        $jenis = $up_excel[1];

        $ex_img = ['jpg','jpeg','png','gif','svg'];
        $ex_audio = ['mp3','wav'];
        $ex_dok = ['doc','docx','xls','xlsx','pdf'];
        if(in_array($jenis, $ex_img)){
            $jenis = "image";
        }elseif(in_array($jenis, $ex_audio)){
            $jenis = "audio";
        }elseif(in_array($jenis, $ex_dok)){
            $jenis = "dokumen";
        }
        
        mysqli_query($conn, "INSERT INTO tb_dokumen VALUES ('','$nama')");
        if(mysqli_affected_rows($conn) > 0):

            $objFileExcel = PHPExcel_IOFactory::load("assets/img/media/$nama");
            foreach($objFileExcel -> getWorksheetIterator() as $ex):
                $jmlRows = $ex -> getHighestDataRow();
                for ($row = 2; $row <= $jmlRows; $row++) :
                    
                    $pertanyaan = mysqli_real_escape_string($conn, $ex -> getCellByColumnAndRow(0, $row) -> getValue());
                    $file0 = mysqli_real_escape_string($conn, $ex -> getCellByColumnAndRow(1, $row) -> getValue());
                    $opsi1 = mysqli_real_escape_string($conn, $ex -> getCellByColumnAndRow(2, $row) -> getValue());
                    $file1 = mysqli_real_escape_string($conn, $ex -> getCellByColumnAndRow(3, $row) -> getValue());
                    $opsi2 = mysqli_real_escape_string($conn, $ex -> getCellByColumnAndRow(4, $row) -> getValue());
                    $file2 = mysqli_real_escape_string($conn, $ex -> getCellByColumnAndRow(5, $row) -> getValue());
                    $opsi3 = mysqli_real_escape_string($conn, $ex -> getCellByColumnAndRow(6, $row) -> getValue());
                    $file3 = mysqli_real_escape_string($conn, $ex -> getCellByColumnAndRow(7, $row) -> getValue());
                    $opsi4 = mysqli_real_escape_string($conn, $ex -> getCellByColumnAndRow(8, $row) -> getValue());
                    $file4 = mysqli_real_escape_string($conn, $ex -> getCellByColumnAndRow(9, $row) -> getValue());
                    $opsi5 = mysqli_real_escape_string($conn, $ex -> getCellByColumnAndRow(10, $row) -> getValue());
                    $file5 = mysqli_real_escape_string($conn, $ex -> getCellByColumnAndRow(11, $row) -> getValue());
                    $kunci = mysqli_real_escape_string($conn, $ex -> getCellByColumnAndRow(12, $row) -> getValue());
                    
                     
                    if(!empty($file0)){
                        $file0 = "media_add/".$file0;
                        if(autoRename($file0, "tb_pertanyaan","media_pendukung")[1] == "rename"){
                            $file0 = autoRename($file0, "tb_pertanyaan","media_pendukung")[0];
                        }
                    }
    
                    // input ke tb butirsoal
                    mysqli_query($conn, "INSERT INTO tb_pertanyaan VALUES ('','$kode_soal','$pertanyaan','$file0','$kunci')");
                    if(mysqli_affected_rows($conn) > 0){
                         // jika data pertanyaan berhasil diinput
                        // input opsi tp sblumnya ambil id pertanyaan
                        $idQ  = tampilQuery("SELECT MAX(id_pertanyaan) FROM tb_pertanyaan ")[0]['MAX(id_pertanyaan)'];
                        $Q = tampilQuery("SELECT * FROM tb_pertanyaan WHERE id_pertanyaan = '$idQ'")[0];
                        $kunciQ = $Q['kunci_jwb'];
                        
                       
    
                        // input opsi1
                        if(!empty($file1)){
                            $file1 = "media_add/".$file1;
                            if(autoRename($file1, "tb_opsi_jwb","media_pendukung")[1] == "rename"){
                                $file1 = autoRename($file1, "tb_opsi_jwb","media_pendukung")[0];
                            }
                        }
                        mysqli_query($conn, "INSERT INTO tb_opsi_jwb VALUES ('','$idQ','$opsi1','$file1')");
                        // update kunci jwb di pertanyaan sesuai id opsi
                        if(mysqli_affected_rows($conn) > 0){
                            if($kunciQ == "opsi1"){
                                $id_O = tampilQuery("SELECT MAX(id_opsi) FROM tb_opsi_jwb")[0]['MAX(id_opsi)'];
                                
                                mysqli_query($conn, "UPDATE tb_pertanyaan SET kunci_jwb = '$id_O' WHERE id_pertanyaan = '$idQ' ");
    
                            }
                        }
    
                        // input opsi2
                        if(!empty($file2)){
                            $file2 = "media_add/".$file2;
                            if(autoRename($file2, "tb_opsi_jwb","media_pendukung")[1] == "rename"){
                                $file2 = autoRename($file2, "tb_opsi_jwb","media_pendukung")[0];
                            }
                        }
                        mysqli_query($conn, "INSERT INTO tb_opsi_jwb VALUES ('','$idQ','$opsi2','$file2')");
                        // update kunci jwb di pertanyaan sesuai id opsi
                        if(mysqli_affected_rows($conn) > 0){
                            if($kunciQ == "opsi2"){
                                $id_O = tampilQuery("SELECT MAX(id_opsi) FROM tb_opsi_jwb")[0]['MAX(id_opsi)'];
                                
                                mysqli_query($conn, "UPDATE tb_pertanyaan SET kunci_jwb = '$id_O' WHERE id_pertanyaan = '$idQ' ");
                            }
                        }
    
    
                        // input opsi3
                        if(!empty($file3)){
                            $file3 = "media_add/".$file3;
                            if(autoRename($file3, "tb_opsi_jwb","media_pendukung")[1] == "rename"){
                                $file3 = autoRename($file3, "tb_opsi_jwb","media_pendukung")[0];
                            }
                            
                        }
                        mysqli_query($conn, "INSERT INTO tb_opsi_jwb VALUES ('','$idQ','$opsi3','$file3')");
                        // update kunci jwb di pertanyaan sesuai id opsi
                        if(mysqli_affected_rows($conn) > 0){
                            if($kunciQ == "opsi3"){
                                $id_O = tampilQuery("SELECT MAX(id_opsi) FROM tb_opsi_jwb")[0]['MAX(id_opsi)'];
                                
                                mysqli_query($conn, "UPDATE tb_pertanyaan SET kunci_jwb = '$id_O' WHERE id_pertanyaan = '$idQ' ");
                            }
                        }
                        
                        // input opsi4
                        if(!empty($file4)){
                            $file4 = "media_add/".$file4;
                            if(autoRename($file4, "tb_opsi_jwb","media_pendukung")[1] == "rename"){
                                $file4 = autoRename($file4, "tb_opsi_jwb","media_pendukung")[0];
                            }
                        }
                        mysqli_query($conn, "INSERT INTO tb_opsi_jwb VALUES ('','$idQ','$opsi4','$file4')");
                        // update kunci jwb di pertanyaan sesuai id opsi
                        if(mysqli_affected_rows($conn) > 0){
                            if($kunciQ == "opsi4"){
                                $id_O = tampilQuery("SELECT MAX(id_opsi) FROM tb_opsi_jwb")[0]['MAX(id_opsi)'];
                                
                                mysqli_query($conn, "UPDATE tb_pertanyaan SET kunci_jwb = '$id_O' WHERE id_pertanyaan = '$idQ' ");
    
                            }
                        }
    
                        // input opsi5
                        if(!empty($file5)){
                            $file5 = "media_add/".$file5;
                            if(autoRename($file5, "tb_opsi_jwb","media_pendukung")[1] == "rename"){
                                $file5 = autoRename($file5, "tb_opsi_jwb","media_pendukung")[0];
                            }
                        }
                        mysqli_query($conn, "INSERT INTO tb_opsi_jwb VALUES ('','$idQ','$opsi5','$file5')");
                        // update kunci jwb di pertanyaan sesuai id opsi
                        if(mysqli_affected_rows($conn) > 0){
                            if($kunciQ == "opsi5"){
                                $id_O = tampilQuery("SELECT MAX(id_opsi) FROM tb_opsi_jwb")[0]['MAX(id_opsi)'];
                                
                                mysqli_query($conn, "UPDATE tb_pertanyaan SET kunci_jwb = '$id_O' WHERE id_pertanyaan = '$idQ' ");
    
                            }
                        }
    
                        
                    }
                    
                endfor;
            
            endforeach;
    
        endif;
    } 

}

// proses tambah butir soal pdf
if(isset($_POST['exc_up_pdf'])){
    $kode_soal = $_POST['kode_soal'];
    $kunci_pdf = htmlspecialchars($_POST['kunci_pdf']);
    $q_bs = mysqli_query($conn, "SELECT * FROM tb_pertanyaan WHERE kode_soal = '$kode_soal'");
    $q_bs_pdf = mysqli_query($conn, "SELECT * FROM tb_butir_pdf WHERE kode_soal = '$kode_soal'");
    // cek apakah butir soal sudah ada
    if(mysqli_num_rows($q_bs) > 0){
        echo "<script> alert('Tidak bisa upload butir soal PDF, bersihkan butir soal terlebih dahulu!'); </script>";
    }elseif(mysqli_num_rows($q_bs_pdf) > 0){
        echo "<script> alert('Tidak bisa upload butir soal PDF, bersihkan butir soal terlebih dahulu!'); </script>";
    }else{
        $filePDF = upload_file_add("dokumen","tb_butir_pdf","nama_pdf")[0];
        mysqli_query($conn, "INSERT INTO tb_butir_pdf VALUES ('','$kode_soal','$filePDF','$kunci_pdf')");
        if(mysqli_affected_rows($conn) > 0){
            echo "<script> alert('Butir soal berhasil ditambahkan!'); </script>";
        }
    }
    



}








?>