<?php
// tambah guru pengampu 
if(isset($_POST['exc_add_pengampu'])){
    $idmapel = $_POST['mapel'];
    $idguru = $_POST['guru'];
    $tingkat = $_POST['tingkat'];
    // input ke tabel pengampu
    mysqli_query($conn, "INSERT INTO tb_guru_pengampu VALUES('','$idmapel','$tingkat','$idguru')");
    if(mysqli_affected_rows($conn) > 0){
        // ambil id terbaru dari tabel pengampu
        $id_pengampu = tampilQuery("SELECT MAX(id_pengampu) FROM tb_guru_pengampu WHERE id_mapel = '$idmapel' AND id_guru = '$idguru' ");
        $id_pengampu = $id_pengampu[0]['MAX(id_pengampu)'];
        $idjurusan = $_POST['jurusan'];
        // insert looping sesuai jml pilihan jurusan
        for ($i=0; $i < count($idjurusan); $i++) { 
            $idjur = $idjurusan[$i];
            mysqli_query($conn, "INSERT INTO tb_pengampu_jur VALUES ('','$id_pengampu','$idjur')");
        }
        if(mysqli_affected_rows($conn) > 0){
            echo "<script> alert('Data pengampu berhasil ditambahkan!'); </script>";
        }
    }
}


// tambah guru pengampu 
if(isset($_POST['exc_edit_pengampu'])){
    $id_pengampu = $_POST['id_pengampu'];
    $idmapel = $_POST['mapel'];
    $idguru = $_POST['guru'];
    $tingkat = $_POST['tingkat'];
    // input ke tabel pengampu
    mysqli_query($conn, "UPDATE tb_guru_pengampu SET id_mapel = '$idmapel', tingkat = '$tingkat', id_guru = '$idguru' WHERE id_pengampu = '$id_pengampu'");
    // delete dulu data pengmapu jurusan
    mysqli_query($conn, "DELETE FROM tb_pengampu_jur WHERE id_pengampu = '$id_pengampu'");
    if(mysqli_affected_rows($conn) > 0){
        $idjurusan = $_POST['jurusan'];
        // insert looping sesuai jml pilihan jurusan
        for ($i=0; $i < count($idjurusan); $i++) { 
            $idjur = $idjurusan[$i];
            mysqli_query($conn, "INSERT INTO tb_pengampu_jur VALUES ('','$id_pengampu','$idjur')");
        }
        if(mysqli_affected_rows($conn) > 0){
            echo "<script> alert('Data berhasil diperbarui!'); </script>";
        }
    }
    
}

// hapus pengampu

if(isset($_POST['exc_del_pengampu'])){
    $id = $_POST['id_pengampu'];
    mysqli_query($conn, "DELETE FROM tb_guru_pengampu WHERE id_pengampu = '$id' ");
    if(mysqli_affected_rows($conn) > 0){
        echo "<script> alert('Data berhasil dihapus!'); </script>";
    }
}

// cari pengampu
$search_pengampu = "";
if(isset($_POST['exc_cari_pengampu'])){
    $key = htmlspecialchars($_POST['cari_pengampu']);
    $search_pengampu = " WHERE tb_mapel.nama_mapel LIKE '%$key%' OR tb_guru.nama_guru LIKE '%$key%' ";

}

?>