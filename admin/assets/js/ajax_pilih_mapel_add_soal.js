
$("#cari_mapel").keyup(function(){
    var key = $("#cari_mapel").val();
    $.ajax({url: "../admin/modules/ajax_mapel_add_soal.php?key="+key, success: function(result){
    $("#cov-card-mapel").html(result);
    }});
});