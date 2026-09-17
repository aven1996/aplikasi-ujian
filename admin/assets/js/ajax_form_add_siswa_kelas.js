// saat halaman dimuat pertama kali
$("#tambah_siswa").ready(function(){
    // ambil value tingkat&jurusan
    var tingkat = $("#tingkat").val();
    var jurusan = $("#jurusan").val();
    $.ajax({url: "../admin/modules/ajax_form_add_siswa_kelas.php?tg="+tingkat+"&jur="+jurusan, success: function(result){
      $("#kelas").html(result);
    }});
  });



// jika tingkat/jurusan diganti
$("#tingkat").change(function(){
        // ambil value tingkat&jurusan
        var tingkat = $("#tingkat").val();
        var jurusan = $("#jurusan").val();
        $.ajax({url: "../admin/modules/ajax_form_add_siswa_kelas.php?tg="+tingkat+"&jur="+jurusan, success: function(result){
        $("#kelas").html(result);
        }});
});  

$("#jurusan").change(function(){
        // ambil value tingkat&jurusan
        var tingkat = $("#tingkat").val();
        var jurusan = $("#jurusan").val();
        $.ajax({url: "../admin/modules/ajax_form_add_siswa_kelas.php?tg="+tingkat+"&jur="+jurusan, success: function(result){
        $("#kelas").html(result);
        }});    
});



// INI GAK JADI DIPAKAI
// jika tingkat/jurusan diganti
$("#tingkat_edit").change(function(){
      // ambil value tingkat&jurusan
      var tg = $("#tingkat_edit").val();
      var jur = $("#jurusan_edit").val();
      $.ajax({url: "../admin/modules/ajax_form_edit_siswa_kelas.php?tg="+tg+"&jur="+jur, success: function(result){
      $(".kelas_edit").html(result);
      }});
});

$("#jurusan_edit").change(function(){
      // ambil value tingkat&jurusan
      var tg = $("#tingkat_edit").val();
      var jur = $("#jurusan_edit").val();
      $.ajax({url: "../admin/modules/ajax_form_edit_siswa_kelas.php?tg="+tg+"&jur="+jur, success: function(result){
      $(".kelas_edit").html(result);
      }});    
});



