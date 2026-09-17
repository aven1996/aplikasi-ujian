
    function readURL(input, placeImage)
    {
        if(input.files )
        {
            var jmlFile = input.files.length;
            for(i = 0; i < jmlFile; i++)
            {
                var reader = new FileReader();

                reader.onload = (e)=>{
                    $($.parseHTML("<img style='max-height:100px; margin-bottom:5px;'>")).attr('src', e.target.result).appendTo(placeImage);
                }

                reader.readAsDataURL(input.files[i]);
            }
        }
    }


    function readURL_audio(input, place)
    {
        if(input.files )
        {
            var jmlFile = input.files.length;
            for(i = 0; i < jmlFile; i++)
            {
                var reader = new FileReader();

                reader.onload = (e)=>{
                    $($.parseHTML("<source type='audio/mpeg'>")).attr('src', e.target.result).appendTo(place);
                }

                reader.readAsDataURL(input.files[i]);
            }
        }
    }

    // img pertanyaan
    $("#img").change(function(){
        $("#img-prev").css("display","block");
        readURL(this, '#img-prev');
    });
    $("#img-prev").ready(function(){
        $("#img-prev").css("display","none");
    });

    // audio pertanyaan
    $("#audio").change(function(){
        $("#audio-prev").css("display","block");
        readURL_audio(this, '#audio-prev');
    });

    $("#audio-prev").ready(function(){
        $("#audio-prev").css("display","none");
    });

  



    // img opsi1
    $("#img1").change(function(){
        $("#img-prev1").css("display","block");
        readURL(this, '#img-prev1');
    });
    $("#img-prev1").ready(function(){
        $("#img-prev1").css("display","none");
    });

    // audio opsi1
    $("#audio1").change(function(){
        $("#audio-prev1").css("display","block");
        readURL_audio(this, '#audio-prev1');
    });

    $("#audio-prev1").ready(function(){
        $("#audio-prev1").css("display","none");
    }); 


     // img opsi2
     $("#img2").change(function(){
        $("#img-prev2").css("display","block");
        readURL(this, '#img-prev2');
    });
    $("#img-prev2").ready(function(){
        $("#img-prev2").css("display","none");
    });

    // audio opsi2
    $("#audio2").change(function(){
        $("#audio-prev2").css("display","block");
        readURL_audio(this, '#audio-prev2');
    });

    $("#audio-prev2").ready(function(){
        $("#audio-prev2").css("display","none");
    }); 


     // img opsi3
     $("#img3").change(function(){
        $("#img-prev3").css("display","block");
        readURL(this, '#img-prev3');
    });
    $("#img-prev3").ready(function(){
        $("#img-prev3").css("display","none");
    });

    // audio opsi3
    $("#audio3").change(function(){
        $("#audio-prev3").css("display","block");
        readURL_audio(this, '#audio-prev3');
    });

    $("#audio-prev3").ready(function(){
        $("#audio-prev3").css("display","none");
    }); 



    // img opsi4
    $("#img4").change(function(){
        $("#img-prev4").css("display","block");
        readURL(this, '#img-prev4');
    });
    $("#img-prev4").ready(function(){
        $("#img-prev4").css("display","none");
    });

    // audio opsi4
    $("#audio4").change(function(){
        $("#audio-prev4").css("display","block");
        readURL_audio(this, '#audio-prev4');
    });

    $("#audio-prev4").ready(function(){
        $("#audio-prev4").css("display","none");
    }); 



    // img opsi5
    $("#img5").change(function(){
        $("#img-prev5").css("display","block");
        readURL(this, '#img-prev5');
    });

    $("#img-prev5").ready(function(){
        $("#img-prev5").css("display","none");
    });

    // audio opsi5
    $("#audio5").change(function(){
        $("#audio-prev5").css("display","block");
        readURL_audio(this, '#audio-prev5');
    });

    $("#audio-prev5").ready(function(){
        $("#audio-prev5").css("display","none");
    });

