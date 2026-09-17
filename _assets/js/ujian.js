// ajax input ragu
function add_ragu(){
    var nopes = $("#nopes").val();
    var kode = $("#kode").val();
    var idQ = $("#idQ").val();
    
    //instansiasi object ajax
    var xhr = new XMLHttpRequest();
    //eksekusi
    xhr.open('get', '_modules/ajax_add_ragu.php?nopes='+nopes+'&kode='+kode+'&idQ='+idQ, true);
    xhr.send();
}


// ajax input jawaban
function ajax_jwb(val){
    // ambil nilai nopes, kode soal, id pertanyaan
    var nopes = $("#nopes").val();
    var kode = $("#kode").val();
    var idQ = $("#idQ").val();
     //instansiasi object ajax
     var xhr = new XMLHttpRequest();
     //eksekusi
     xhr.open('get', '_modules/ajax_jwb.php?idO='+val+'&nopes='+nopes+'&kode='+kode+'&idQ='+idQ, true);
     xhr.send();
}



// TIMER COUTDOWN
    // ambil waktu saat siswa klik mulai dan disimpan di cookie
    var nows = Math.floor(getCookie("getTimeUser"));
    
    // ambil text html dari element dummy untuk menyimpan durasi (menit) dan dibuat milisecond
    var durasi = document.querySelector(".durasi").innerHTML * 60 * 1000;
    // ambil waktu yang sudah terpakai dari database
    var terpakai = document.querySelector(".terpakai").innerHTML * 60;//menit dikali 60 agar menjadi detik
    // buat waktu terpakai yang tadinya detik menjadi milidetik(miliseconds)
    var terpakai_ms = terpakai * 1000;
    // ubah durasi awal menjadi sisa durasi saat ini dengan mengurangi durasi dengan waktu terpakai dalam satuan miliseconds
    durasi = durasi - terpakai_ms;
    // tambahkan waktu skrg dan durasi 
    var countDownDate = nows + durasi;
    var durasi_terpakai = 0;//satuan detik
    if(terpakai > 0){
        durasi_terpakai = terpakai;
    }

    // Memperbarui hitungan mundur setiap 1 detik
    window.addEventListener("load", ()=>{
    var x = setInterval(function() {
        if(Math.floor(getCookie("durasi_terpakai")) > 0){
            durasi_terpakai = Math.floor(getCookie("durasi_terpakai"));
        }
        //update durasi yg terpakai dalam hitungan detik
        durasi_terpakai++;

        // durasi yang terpakai dimasukan ke cookie untuk ntinya diambil dan dimasukan ke db
        document.cookie="durasi_terpakai=" + durasi_terpakai;

        // Untuk mendapatkan tanggal dan waktu hari ini
        var now = new Date().getTime();

        // Temukan selisih antara sekarang dan tanggal hitung mundur
        var distance = countDownDate - now;
        
        // Perhitungan waktu untuk hari, jam, menit dan detik
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        // Keluarkan hasil dalam elemen dengan id = "demo"
        document.querySelector(".countDown").innerHTML = hours + ":" + minutes + ":" + seconds;
        
        // Jika hitungan mundur selesai, tulis beberapa teks 
        if (distance < 0) {
            clearInterval(x);
            var kode = $("#kode").val();
            document.location.href ="selesai.php?kode="+kode;
        }
    }, 1000);
    });