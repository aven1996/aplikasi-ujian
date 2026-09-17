function randomSoal(LenString,idEl){
    document.getElementById(idEl).value = randomStringSoal(LenString);
}

function randomStringSoal(LenString){
    var TextY = "";
    var StringX = "QWERTYUIOPLKJHGFDSAZXCVBNM1234567890";
    for (var i = 0; i < LenString; i++) {
        TextY += StringX.charAt(Math.floor(Math.random() * StringX.length));
    }
    var TextZ = "US" + TextY;
    return TextZ;

}
