function random(LenString,idEl){
    document.getElementById(idEl).value = randomString(LenString);
}

function randomString(LenString){
    var TextY = "";
    var StringX = "QWERTYUIOPLKJHGFDSAZXCVBNM1234567890";
    for (var i = 0; i < LenString; i++) {
        TextY += StringX.charAt(Math.floor(Math.random() * StringX.length));
    }
    var TextZ = "JUR" + TextY;
    return TextZ;

}
