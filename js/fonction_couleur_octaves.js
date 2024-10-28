function couleur_octaves()
{

    var tabCouleurs0 = [];
    $(".octave0").hover(function(){ 
        $(".octave0").each(function(index) {
            tabCouleurs0.push($(this).css("background-color"));
            $(this).css( "backgroundColor", "#ffff57CC");
            $('input[name=registre]', '#formHauteur').val(['0']);
        });
    }).on("mouseout",function(){
        $(".octave0").each(function(index) {
            $(this).css( "backgroundColor",tabCouleurs0[index]);
        });
    });
    $(".octave0").on("click",function() {
        transpoOctave(0);
    });

    var tabCouleurs1 = [];
    $(".octave1").hover(function(){ 
        $(".octave1").each(function(index) {
            tabCouleurs1.push($(this).css("background-color"));
            $(this).css( "backgroundColor", "#ffff57CC");
            $('input[name=registre]', '#formHauteur').val(['1']);
        });
    }).on("mouseout",function(){
        $(".octave1").each(function(index) {
            $(this).css( "backgroundColor",tabCouleurs1[index]);
        });
    });
    $(".octave1").on("click",function() {
        transpoOctave(1);
    });

    var tabCouleurs2 = [];
    $(".octave2").hover(function(){ 
        $(".octave2").each(function(index) {
            tabCouleurs2.push($(this).css("background-color"));
            $(this).css( "backgroundColor", "#ffff57CC");
            $('input[name=registre]', '#formHauteur').val(['2']);
        });
    }).on("mouseout",function(){
        $(".octave2").each(function(index) {
            $(this).css( "backgroundColor",tabCouleurs2[index]);
        });
    });
    $(".octave2").on("click",function() {
        transpoOctave(2);
    });

    var tabCouleurs3 = [];
    $(".octave3").hover(function(){ 
        $(".octave3").each(function(index) {
            tabCouleurs3.push($(this).css("background-color"));
            $(this).css( "backgroundColor", "#ffff57CC");
            $('input[name=registre]', '#formHauteur').val(['3']);
        });
    }).on("mouseout",function(){
        $(".octave3").each(function(index) {
            $(this).css( "backgroundColor",tabCouleurs3[index]);
        });
    });
    $(".octave3").on("click",function() {
        transpoOctave(3);
    });

    var tabCouleurs4 = [];
    $(".octave4").hover(function(){ 
        $(".octave4").each(function(index) {
            tabCouleurs4.push($(this).css("background-color"));
            $(this).css( "backgroundColor", "#ffff57CC");
            $('input[name=registre]', '#formHauteur').val(['4']);
        });
    }).on("mouseout",function(){
        $(".octave4").each(function(index) {
            $(this).css( "backgroundColor",tabCouleurs4[index]);
        });
    });
    $(".octave4").on("click",function() {
        transpoOctave(4);
    });

    var tabCouleurs5 = [];
    $(".octave5").hover(function(){ 
        $(".octave5").each(function(index) {
            tabCouleurs5.push($(this).css("background-color"));
            $(this).css( "backgroundColor", "#ffff57CC");
            $('input[name=registre]', '#formHauteur').val(['5']);
        });
    }).on("mouseout",function(){
        $(".octave5").each(function(index) {
            $(this).css( "backgroundColor",tabCouleurs5[index]);
        });
    });
    $(".octave5").on("click",function() {
        transpoOctave(5);
    });

    var tabCouleurs6 = [];
    $(".octave6").hover(function(){ 
        $(".octave6").each(function(index) {
            tabCouleurs6.push($(this).css("background-color"));
            $(this).css( "backgroundColor", "#ffff57CC");
            $('input[name=registre]', '#formHauteur').val(['6']);
        });
    }).on("mouseout",function(){
        $(".octave6").each(function(index) {
            $(this).css( "backgroundColor",tabCouleurs6[index]);
        });
    });
    $(".octave6").on("click",function() {
        transpoOctave(6);
    });

    var tabCouleurs7 = [];
    $(".octave7").hover(function(){ 
        $(".octave7").each(function(index) {
            tabCouleurs7.push($(this).css("background-color"));
            $(this).css( "backgroundColor", "#ffff57CC");
            //$('input[name=registre]', '#formHauteur').val(['7']);
        });
    }).on("mouseout",function(){
        $(".octave7").each(function(index) {
            $(this).css( "backgroundColor",tabCouleurs7[index]);
        });
    });
    $(".octave7").on("click",function() {
        transpoOctave(7);
    });

    var tabCouleurs8 = [];
    $(".octave8").hover(function(){ 
        $(".octave8").each(function(index) {
            tabCouleurs8.push($(this).css("background-color"));
            $(this).css( "backgroundColor", "#ffff57CC");
            //$('input[name=registre]', '#formHauteur').val(['8']);
        });
    }).on("mouseout",function(){
        $(".octave8").each(function(index) {
            $(this).css( "backgroundColor",tabCouleurs8[index]);
        });
    });
    $(".octave8").on("click",function() {
        transpoOctave(8);
    });
}