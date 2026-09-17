$(document).ready(function(){
    $("#tabel_siswa").DataTable({
        "order": [[ 1, "asc" ]]
    });


    $("#tabel_guru").DataTable({
        "order": [[ 0, "asc" ]]
    });

    $("#tabel_siswa_login").DataTable({
        "order": [[ 1, "asc" ]]
    });

    $("#siswa-absen").DataTable({
        "order": [[ 1, "asc" ]]
    });
    $("#tbl-nilai").DataTable({
        "order": [[ 1, "asc" ]]
    });
});