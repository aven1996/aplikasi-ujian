// function untuk mengambil nilai cookie dari nama cookie tertentu
function getCookie(cn){
    var name = cn + "=";
    var ca = document.cookie.split(";");
    
    for (let i = 0; i < ca.length; i++) {
        var c = ca[i].trim();
        if(c.indexOf(name) == 0){
            var cook = c.substring(name.lenght, c.lenght);
            var cookarray = cook.split("=");
            return cookarray[1];
        }
        
    }
    return "";
}
