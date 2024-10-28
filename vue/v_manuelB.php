<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>FORCE 12</title>
		
		<link rel="stylesheet" type="text/css" href="../css/style.css">
		<link rel="stylesheet" href="../js/bootstrap-4.0.0-dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
		
		<script src="../js/fonction_chercheRang.js"></script>
		
        <script src="../js/jquery-3.3.1.min.js"></script>
		<script src="../js/webcomponentsjs-master/externs/webcomponents.js"></script>

	</head>
    <body>
        <?php
            include_once("../Matrice.php");
            include_once("../Note.php");
        ?>
        <form id="versEtudeManuel" method="POST" action="v_etude_manuel.php">
            <input id="enonce" type="hidden" name="enonce" value=""/>
            <input id="manuelB" type="hidden" name="manuelB" value="1"/>
        </form>
        <div id="message-manuelB" class="text-center texte-blanc"></div>
        <div id="fond-manuelB" class="container-fluid text-center fond-gris-manuel texte-blanc-encyc">
        </div>
        <div id="fond-boutons" class="container-fluid text-center fond-gris-manuel texte-blanc-encyc">
        </div>
        <script>
            $( document ).ready(function() {
                <?php
                    include_once("matricePHPEnJSBis.php");
                    $liste = $_POST['listeMatrices'];

                    echo "
                    var listeMat = '".$liste."';";
            
                ?>
                    var tabListeMat = listeMat.split(";");
                    
                    //Parce qu'il existe plusieurs matrices qui ont le même rang : 031-1, 031-2, etc.
                    var rangsDejaTrouves = []; 

                    $('#fond-manuelB').append('<div class="row">');

                    for(var z=0;z<tabListeMat.length;z++)
                    {
                        var rang = chercheRang(tabListeMat[z],tabToutesLesMatrices);
                        rangPur = rang.split("-");

                        if(!rangsDejaTrouves.includes(rangPur[0]) && rangPur[0]!=null)
                        {//Si rang pas vide et si pas déjà trouvé dans ce traitement.
                            $('.row:last-child').append('<div class="col"><div id="'+rangPur[0]+'" class="aideB cadre-blanc-manuelB"><img src="../images/matrices/'+rangPur[0]+'_matrice.png"/></div></div>');
                        }
                        rangsDejaTrouves[z] = rangPur[0];
                    }
                    $('#fond-manuelB').append('</div>');
                    $('#fond-boutons').append('<form id="leFormulaire" method="POST" action="../index.php"><div class="row"><div id="img-centre" class="col-6"><input type="hidden" name="manuel" value="manuel"/><button id="ok" type="button" class="btn bouton-encyclopedie bouton_ok_transparent" name="ok"></button></div><div class="col-6"><div id="retour" type="button" class="btn bouton-encyclopedie bouton_ency_retour" name="retour"></div></div></form></div>');
                    $("#retour").on("click",function() {
                        $('#leFormulaire').submit();
                    });
                    $('.cadre-blanc-manuelB').on("mouseover", function() {
                        $(this).css("border-color","red");
                    });
                    $('.cadre-blanc-manuelB').on("mouseout", function() {
                        if($(this).css("background-color") == "rgb(255, 255, 255)")
                        {//Si la mat est sélectionnée, on n'ôte pas le cadre rouge
                            $(this).css("border-color","red");
                        }
                        else
                        {
                            $(this).css("border-color","white");
                        }
                    });
                    $('.cadre-blanc-manuelB').on("click", function() {
                        if($(this).css("background-color") == "rgb(255, 255, 255)")
                        {
                            $(this).css("background-color","transparent");
                            $(this).css("border-color","white");
                            var selectionnes = false; 
                            $('.cadre-blanc-manuelB').each(function() {
                                //On rech les fonds blancs
                                if($(this).css( "backgroundColor") == "rgb(255, 255, 255)")
                                {
                                    selectionnes = true;
                                }
                            });
                            //si aucun, on désactive bouton OK
                            if(selectionnes == false)
                            {
                                $("#message-manuelB").html("");
                                $('#ok').addClass("bouton_ok_transparent");
                                $('#ok').removeClass("bouton_ency_ok");
                            }
                        }
                        else
                        {
                            $('.cadre-blanc-manuelB').each(function(index) {
                                //On rech les fonds blancs et on les ôte
                                if($(this).css( "backgroundColor") == "rgb(255, 255, 255)")
                                {
                                    $(this).css( "backgroundColor","transparent");
                                }
                            });
                            $(this).css("background-color","white");
                            $(this).css("border-color","red");
                            $('#ok').addClass("bouton_ency_ok");
                            $('#ok').removeClass("bouton_ok_transparent");
                        }
                    });
                    $('#ok').on("click", function(){
                        if($(this).hasClass("bouton_ency_ok"))
                        {
                            var id;
                            $('.cadre-blanc-manuelB').each(function(index) {
                                //On rech le fond blanc et on recup son id
                                if($(this).css("backgroundColor") == "rgb(255, 255, 255)")
                                {
                                    id = $(this).attr( "id");
                                }
                            });
                            $('#enonce').val(id);
                            $('#versEtudeManuel').submit();
                        }
                        else
                        {
                            console.log("Il faut sélectionner une matrice avant.");
                        }
                    });

                    $(".aideB").on("mouseover",function() {

                        //Recherche DES nomenclatureS de la matrice sélectionnée (en blanc)
                        var trouve = false;
                        var indices = [];
                        var i = 0;
                        while(i<tabToutesLesMatrices.length && trouve == false)
                        {
                            var rangPur = tabToutesLesMatrices[i].rang.split("-");
                            if(rangPur[0] == $(this).attr('id'))
                            {
                                while(rangPur[0] == $(this).attr('id') && i<tabToutesLesMatrices.length)
                                {
                                    indices.push(i);
                                    i++;
                                    rangPur = tabToutesLesMatrices[i].rang.split("-");
                                }
                                trouve = true;
                            }
                            i++;
                        }
                        if(indices.length != 0)
                        {
                            var message;
                            //On n'utilise pas toutes les nomenclatures, sauf si Derek le demande
                            /*for(var o=0;o<indices.length;o++)
                            {
                               message += tabToutesLesMatrices[indices[o]].nomenclature;
                            }*/
                            message = tabToutesLesMatrices[indices[0]].nomenclature;
                        }
                        else
                        {
                            var message = "Aucune description";
                        }
                        $("#message-manuelB").html(message);
                    });
                    $(".aideB").on("mouseout",function() {
                        $("#message-manuelB").html("");
                    });
               });
            </script>
    </body>
</html>