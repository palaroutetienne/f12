<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>FORCE 12</title>
		
		<link rel="stylesheet" type="text/css" href="../css/style.css">
		<link rel="stylesheet" href="../js/bootstrap-4.0.0-dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
		
        <script src="../js/jquery-3.3.1.min.js"></script>
        <script src="../js/bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>	
		<script type="text/javascript" src="../js/maphilight/jquery.maphilight.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@magenta/music"></script>

        <script src="../js/fonction_chercheIndiceMatrice.js"></script>
        <script src="../js/fonction_chercheNomenclature.js"></script>
        <script src="../js/fonction_chercheEnonceMatrice.js"></script>
        <script src="../js/fonction_chercheOrigine.js"></script>
        <?php
            include_once('../Matrice.php');
            include_once('../Note.php');
        ?>

        <script type="text/javascript">

            function origine(id)
            {
                $('#sous-menu').remove();
                chercheOrigine(id,tabToutesLesMatrices);
            }
            function soumettreChoixMenu(numMat)
            {//numMat est un rang que je mets dans $_POST['enonce']
                $('#enonce').val(numMat);
                $('#formulaire').submit();
            }
            
            window.onload
            {
                <?php
                    include_once('../vue/matricePHPEnJSBis.php');
                ?>
            }

            $(document).ready(function(){
                var donnees = {}; //Pour stocker les param de maphilight (eq à mettre l'attribut data-maphilight dans les areas
                $('#image-spirale').maphilight(); //Instancier l'objet maphilight
                
                //Paramétrer l'objet maphilight
                donnees.alwaysOn = false;
                donnees.fillColor = 'FFFFFF'; //blanc
                donnees.strokeColor = 'f39e77'; //orange
                donnees.strokeWidth ='4';
                donnees.fillOpacity = '0.4';
                
                //Appliquer les paramètres à l'objet maphilight
                $('area').data('maphilight', donnees).trigger('alwaysOn.maphilight');

                $("area[shape='circle']").on('mouseover', function(){
                    //Fermer le sous menu, s'il est ouvert
                    if($('#sous-menu').lentgh != 0)
                    {
                        $('#sous-menu').remove();
                    }
                    //Montrer la matrice dans le panneau de gauche
                    survolCarte($(this).attr('id'));
                    //Pour placer le texte aux coord de la matrice survolée
                    var coordonnees=$(this).attr('coords');
                    var coordSsRayon=coordonnees.split(',');
                    var gauche=coordSsRayon[0];
                    var haut=coordSsRayon[1];

                    var $html=$('<a id="numero">'+$(this).attr('id')+'</a>');        
                    //M.E.F. étiquette num Matrice
                    var position = $("#colonne-spirale").position();

                    $html.css({
                        "pointer-events": "none", //Pour ne pas que la souris détecte le passage au dessus du #numero. Cool.
                        "top": haut-8+position.top+'px', //-7.5 pour compenser les 15px de rayon du cercle de l'area
                        "left": gauche-10+position.left+'px', //Un peu plus car 3 caractères du texte à centre par rapport au centre du cercle
                        "position":'absolute',
                        "color":"#000000",
                        "font-family": 'bauhausregular',
                        "font-size": "small"
                    });
                    $html.appendTo('.texte-blanc-encyc');
                });
                $("area[shape='circle']").on('mouseout', function(){
                    $('#numero').remove();
                });
                $('#bouton19').on("click", function(){

                    if($('#sous-menu').lentgh != 0)
                    {
                        $('#sous-menu').remove();
                    }
                    $('#croix').css('visibility', 'visible');

                    var html='<div class="row text-center">'; 
                    html+='<form id="formu" method="POST" action="../vue/v_etude_manuel.php"><div id="taperNumMat">Tapez le N°<BR/>de la matrice<BR/>à étudier<BR/>(de 0 à 351)<BR/></div>';
                    html+='<input id="numRose" class="form-control-rose" type="text" pattern="[0-9]{5}" placeholder="123" title="Taper un nombre de 3 chiffres" value="000" name="enonce" onchange="trouverNbSons($(this).val())"/>';
                    html+='<div id="fleches"><img src="../images/flechasses.png"><input id="nbSonsPanneau" class="texte-blanc-encyc" readonly type="text" value="0" name="nbSons"/> sons<BR/>';
                    html+='<img id="soumettre" src="../images/bouton_ok_spirale.png" onclick="$(\'#formu\').submit()"/></div>';
                    html+='</form>';

                    $('#matrice').html(html);
                });
                $('#bouton19').on("mouseover", function(){
                    $(this).html("<img src='../images/but_1-9_rouge.png'/>");
                });
                $('#bouton19').on("mouseout", function(){
                    $(this).html("<img src='../images/but_1-9.png'/>");
                });
                $('#boutonAZ').on("click", function(){
                    $('#croix').css('visibility', 'visible');
                    var html='<div id="menu">';
                        html+='<div class="row">';
                        html+='<div class="col-12">';
                        html+='<div class="row menu-opt"><div id="Accords classiques" class="col-12" onclick="origine(this.id)">Accords classiques - 6</div></div>';
                        html+='<div class="row menu-opt"><div id="Accords extrapolés" class="col-12" onclick="origine(this.id)">Accords extrapolés - 88</div></div>';
                        html+='<div class="row menu-opt"><div id="Accords modaux dominante" class="col-12" onclick="origine(this.id)">Accords modaux dominante - 59</div></div>';
                        html+='<div class="row menu-opt"><div id="Accords modaux majeurs" class="col-12" onclick="origine(this.id)">Accords modaux majeurs - 28</div></div>';
                        html+='<div class="row menu-opt"><div id="Accords modaux mineurs" class="col-12" onclick="origine(this.id)">Accords modaux mineurs - 50</div></div>';
                        html+='<div class="row menu-opt"><div id="Accords neutres" class="col-12" onclick="origine(this.id)">Accords neutres - 14</div></div>';
                        html+='<div class="row menu-opt"><div id="Accords signature" class="col-12" onclick="origine(this.id)">Accords signature - 2</div></div>';
                        html+='<div class="row menu-opt"><div id="Accords tonals dominante" class="col-12" onclick="origine(this.id)">Accords tonals dominante - 204</div></div>';
                        html+='<div class="row menu-opt"><div id="Accords tonals majeurs" class="col-12" onclick="origine(this.id)">Accords tonals majeurs - 37</div></div>';
                        html+='<div class="row menu-opt"><div id="Accords tonals mineurs" class="col-12" onclick="origine(this.id)">Accords tonals mineurs - 44</div></div>';
                        html+='<div class="row menu-opt"><div id="Gammes / modes classiques" class="col-12" onclick="origine(this.id)">Gammes / modes classiques - 45</div></div>';
                        html+='<div class="row menu-opt"><div id="Gammes / modes extrapolés" class="col-12" onclick="origine(this.id)">Gammes / modes extrapolés - 189</div></div>';
                        html+='<div class="row menu-opt"><div id="Gammes / modes modernes" class="col-12" onclick="origine(this.id)">Gammes / modes modernes - 229</div></div>';
                        html+='<div class="row menu-opt"><div id="Gammes / modes signature" class="col-12" onclick="origine(this.id)">Gammes / modes signature - 11</div></div>';
                        html+='<div class="row menu-opt"><div id="Gammes / modes traditionnels" class="col-12" onclick="origine(this.id)">Gammes / modes traditionnels - 126</div></div>';
                        html+='<div class="row menu-opt"><div id="Intervalles" class="col-12" onclick="origine(this.id)">Intervalles - 26</div></div>';
                        html+='</div>';
                        html+='</div>';
                        html+='</div>';
                    $('#matrice').html(html);
                });
                $('#croix').on("click", function(){
                    $('#croix').css('visibility', 'hidden');
                    $('#sous-menu').remove();
                    $('#matrice').html('<img src="../images/matrices/000_matrice.png"/>');
                });
                $('#list-exporter-list').on("click", function(){
                    exportMIDI($('#numRose').val());
                });
            });
        </script>
    </head>
    <body>
       <?php
            include_once("logoF12.html");
       ?>
        <!--Fin Logo Force 12-->
        <form id="formulaire" method="POST" action="v_etude_manuel.php">
                <input id="enonce" type="hidden" name="enonce" value="001"/>
                <input id="encyclopedie_manuel" type="hidden" name="encyclopedie_manuel" value="1"/>
        </form>
        <div class="texte-blanc-encyc">
            <div class="row">
                <div class="col-3 apercu-matrice">
                    <div class="row p-0 m-2">
                        <div id="vortex" class="col-12 text-center">
                            <a href="../images/affiche351MTR spirale A3.pdf"><img src="../images/vortex.png" alt="X"/></a>
                        </div>
                    </div>
                    <div class="row m-2">
                        <div id="descript-matrice" class="col-12 text-center texte-blanc">

                        </div>
                        <div id="fenetre" class="col-12 text-center fond-gris-opaque">
                            <div id="croix">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <div id="matrice">
                                <img src="../images/matrices/000_matrice.png"/>
                            </div>
                        </div>
                        <div class="col-12 fond-gris-panneau">
                            <div class="row p-0">
                                <div class="col-4 text-center p-0">
                                    <img id="bouton19" src="../images/but_1-9.png"/>
                                </div>
                                <div id="AZ" class="col-4 text-center p-0">
                                    <img id="boutonAZ" src="../images/but_A-Z.png"/>
                                </div>
                                <div class="col-4 text-center p-0">
                                    <img id="retour" src="../images/but_retour_spirale.png"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="colonne-spirale" class="col-7 p-0">
                    <div class="fond-spirale">
                        <img id="image-spirale" src="../images/dlg_351_a.png" alt="351Matrices" width="754" height="774" usemap="#cartematrice" />
                    </div>
                </div>
            </div>
        
            <map name="cartematrice">
                <area class="aire" id="000" shape="circle" coords="377,395,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="001" shape="circle" coords="344,390,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="002" shape="circle" coords="349,423,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="003" shape="circle" coords="381,433,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="004" shape="circle" coords="409,415,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="005" shape="circle" coords="412,382,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="006" shape="circle" coords="393,354,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="007" shape="circle" coords="362,344,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="008" shape="circle" coords="330,356,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="009" shape="circle" coords="309,383,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="010" shape="circle" coords="308,417,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="011" shape="circle" coords="322,447,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="012" shape="circle" coords="350,467,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="013" shape="circle" coords="385,469,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="014" shape="circle" coords="416,456,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="015" shape="circle" coords="440,432,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="016" shape="circle" coords="450,399,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="017" shape="circle" coords="444,366,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="018" shape="circle" coords="427,337,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="019" shape="circle" coords="400,316,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="020" shape="circle" coords="367,309,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="021" shape="circle" coords="332,315,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="022" shape="circle" coords="304,330,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="023" shape="circle" coords="282,357,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="024" shape="circle" coords="270,390,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="025" shape="circle" coords="274,424,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="026" shape="circle" coords="286,456,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="027" shape="circle" coords="308,482,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="028" shape="circle" coords="338,501,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="029" shape="circle" coords="370,506,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="030" shape="circle" coords="405,500,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="031" shape="circle" coords="436,487,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="032" shape="circle" coords="461,464,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="033" shape="circle" coords="479,435,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="034" shape="circle" coords="485,401,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="035" shape="circle" coords="481,367,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="036" shape="circle" coords="470,336,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="037" shape="circle" coords="450,308,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="038" shape="circle" coords="422,287,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="039" shape="circle" coords="390,275,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="040" shape="circle" coords="356,275,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="041" shape="circle" coords="323,280,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="042" shape="circle" coords="291,296,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="043" shape="circle" coords="265,319,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="044" shape="circle" coords="245,348,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="045" shape="circle" coords="235,381,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="046" shape="circle" coords="235,414,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="047" shape="circle" coords="244,448,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="048" shape="circle" coords="257,479,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="049" shape="circle" coords="279,506,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="050" shape="circle" coords="306,527,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="051" shape="circle" coords="339,538,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="052" shape="circle" coords="374,543,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="053" shape="circle" coords="408,538,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="054" shape="circle" coords="441,524,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="055" shape="circle" coords="471,506,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="056" shape="circle" coords="494,481,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="057" shape="circle" coords="511,450,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="058" shape="circle" coords="520,417,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="059" shape="circle" coords="520,383,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="060" shape="circle" coords="513,350,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="061" shape="circle" coords="500,318,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="062" shape="circle" coords="481,290,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="063" shape="circle" coords="456,266,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="064" shape="circle" coords="426,249,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="065" shape="circle" coords="393,239,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="066" shape="circle" coords="360,237,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="067" shape="circle" coords="326,243,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="068" shape="circle" coords="293,254,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="069" shape="circle" coords="264,271,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="070" shape="circle" coords="239,294,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="071" shape="circle" coords="218,322,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="072" shape="circle" coords="205,354,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="073" shape="circle" coords="199,386,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="074" shape="circle" coords="200,421,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="075" shape="circle" coords="207,454,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="076" shape="circle" coords="221,487,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="077" shape="circle" coords="239,515,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="078" shape="circle" coords="264,540,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="079" shape="circle" coords="294,560,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="080" shape="circle" coords="327,572,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="081" shape="circle" coords="361,578,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="082" shape="circle" coords="397,577,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="083" shape="circle" coords="431,567,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="084" shape="circle" coords="463,554,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="085" shape="circle" coords="493,534,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="086" shape="circle" coords="518,508,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="087" shape="circle" coords="538,479,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="088" shape="circle" coords="551,446,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="089" shape="circle" coords="556,412,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="090" shape="circle" coords="556,377,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="091" shape="circle" coords="549,343,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="092" shape="circle" coords="537,311,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="093" shape="circle" coords="520,281,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="094" shape="circle" coords="498,254,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="095" shape="circle" coords="470,232,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="096" shape="circle" coords="440,217,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="097" shape="circle" coords="407,206,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="098" shape="circle" coords="374,201,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="099" shape="circle" coords="340,203,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="100" shape="circle" coords="306,211,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="101" shape="circle" coords="274,224,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="102" shape="circle" coords="244,242,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="103" shape="circle" coords="218,265,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="104" shape="circle" coords="195,292,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="105" shape="circle" coords="179,323,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="106" shape="circle" coords="167,356,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="107" shape="circle" coords="162,391,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="108" shape="circle" coords="163,426,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="109" shape="circle" coords="171,459,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="110" shape="circle" coords="184,493,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="111" shape="circle" coords="201,524,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="112" shape="circle" coords="224,552,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="113" shape="circle" coords="251,576,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="114" shape="circle" coords="281,594,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="115" shape="circle" coords="314,606,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="116" shape="circle" coords="348,614,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="117" shape="circle" coords="383,613,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="118" shape="circle" coords="417,608,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="119" shape="circle" coords="451,599,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="120" shape="circle" coords="483,584,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="121" shape="circle" coords="512,564,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="122" shape="circle" coords="537,540,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="123" shape="circle" coords="559,513,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="124" shape="circle" coords="576,481,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="125" shape="circle" coords="587,450,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="126" shape="circle" coords="593,414,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="127" shape="circle" coords="591,380,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="128" shape="circle" coords="588,346,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="129" shape="circle" coords="576,312,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="130" shape="circle" coords="561,279,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="131" shape="circle" coords="542,250,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="132" shape="circle" coords="517,225,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="133" shape="circle" coords="489,202,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="134" shape="circle" coords="458,186,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="135" shape="circle" coords="426,173,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="136" shape="circle" coords="392,166,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="137" shape="circle" coords="357,165,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="138" shape="circle" coords="325,169,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="139" shape="circle" coords="290,178,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="140" shape="circle" coords="256,192,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="141" shape="circle" coords="225,211,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="142" shape="circle" coords="198,233,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="143" shape="circle" coords="174,260,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="144" shape="circle" coords="155,290,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="145" shape="circle" coords="140,322,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="146" shape="circle" coords="130,356,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="147" shape="circle" coords="127,389,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="148" shape="circle" coords="128,424,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="149" shape="circle" coords="134,460,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="150" shape="circle" coords="144,493,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="151" shape="circle" coords="160,526,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="152" shape="circle" coords="180,555,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="153" shape="circle" coords="203,582,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="154" shape="circle" coords="231,606,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="155" shape="circle" coords="261,624,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="156" shape="circle" coords="294,638,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="157" shape="circle" coords="328,647,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="158" shape="circle" coords="364,650,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="159" shape="circle" coords="399,648,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="160" shape="circle" coords="435,641,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="161" shape="circle" coords="469,631,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="162" shape="circle" coords="502,614,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="163" shape="circle" coords="531,595,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="164" shape="circle" coords="559,570,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="165" shape="circle" coords="583,541,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="166" shape="circle" coords="601,512,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="167" shape="circle" coords="615,478,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="168" shape="circle" coords="625,446,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="169" shape="circle" coords="629,411,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="170" shape="circle" coords="628,376,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="171" shape="circle" coords="622,342,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="172" shape="circle" coords="614,308,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="173" shape="circle" coords="600,275,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="174" shape="circle" coords="581,244,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="175" shape="circle" coords="559,216,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="176" shape="circle" coords="534,190,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="177" shape="circle" coords="505,168,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="178" shape="circle" coords="473,152,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="179" shape="circle" coords="441,138,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="180" shape="circle" coords="406,133,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="181" shape="circle" coords="372,129,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="182" shape="circle" coords="338,131,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="183" shape="circle" coords="304,136,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="184" shape="circle" coords="271,146,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="185" shape="circle" coords="238,161,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="186" shape="circle" coords="209,179,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="187" shape="circle" coords="180,200,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="188" shape="circle" coords="156,226,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="189" shape="circle" coords="133,254,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="190" shape="circle" coords="116,285,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="191" shape="circle" coords="103,318,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="192" shape="circle" coords="94,352,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="193" shape="circle" coords="91,386,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="194" shape="circle" coords="92,422,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="195" shape="circle" coords="96,457,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="196" shape="circle" coords="106,491,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="197" shape="circle" coords="118,524,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="198" shape="circle" coords="136,555,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="199" shape="circle" coords="158,586,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="200" shape="circle" coords="182,612,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="201" shape="circle" coords="211,634,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="202" shape="circle" coords="242,654,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="203" shape="circle" coords="274,670,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="204" shape="circle" coords="309,680,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="205" shape="circle" coords="345,685,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="206" shape="circle" coords="380,686,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="207" shape="circle" coords="416,682,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="208" shape="circle" coords="449,675,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="209" shape="circle" coords="483,664,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="210" shape="circle" coords="515,647,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="211" shape="circle" coords="546,628,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="212" shape="circle" coords="574,605,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="213" shape="circle" coords="599,579,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="214" shape="circle" coords="621,550,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="215" shape="circle" coords="638,517,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="216" shape="circle" coords="652,483,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="217" shape="circle" coords="660,448,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="218" shape="circle" coords="664,414,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="219" shape="circle" coords="664,379,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="220" shape="circle" coords="661,343,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="221" shape="circle" coords="652,309,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="222" shape="circle" coords="639,275,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="223" shape="circle" coords="623,244,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="224" shape="circle" coords="602,212,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="225" shape="circle" coords="579,184,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="226" shape="circle" coords="552,159,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="227" shape="circle" coords="523,138,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="228" shape="circle" coords="491,120,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="229" shape="circle" coords="458,107,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="230" shape="circle" coords="422,98,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="231" shape="circle" coords="388,94,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="232" shape="circle" coords="353,94,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="233" shape="circle" coords="320,98,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="234" shape="circle" coords="284,105,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="235" shape="circle" coords="249,116,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="236" shape="circle" coords="217,132,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="237" shape="circle" coords="185,151,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="238" shape="circle" coords="158,174,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="239" shape="circle" coords="131,199,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="240" shape="circle" coords="109,227,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="241" shape="circle" coords="90,257,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="242" shape="circle" coords="75,292,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="243" shape="circle" coords="64,325,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="244" shape="circle" coords="57,360,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="245" shape="circle" coords="54,397,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="246" shape="circle" coords="57,431,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="247" shape="circle" coords="62,467,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="248" shape="circle" coords="72,502,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="249" shape="circle" coords="84,536,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="250" shape="circle" coords="101,567,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="251" shape="circle" coords="121,598,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="252" shape="circle" coords="147,627,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="253" shape="circle" coords="173,652,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="254" shape="circle" coords="203,674,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="255" shape="circle" coords="236,691,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="256" shape="circle" coords="270,704,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="257" shape="circle" coords="305,715,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="258" shape="circle" coords="340,722,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="259" shape="circle" coords="375,723,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="260" shape="circle" coords="409,721,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="261" shape="circle" coords="444,712,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="262" shape="circle" coords="479,704,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="263" shape="circle" coords="511,690,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="264" shape="circle" coords="545,673,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="265" shape="circle" coords="573,652,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="266" shape="circle" coords="601,628,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="267" shape="circle" coords="627,602,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="268" shape="circle" coords="648,574,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="269" shape="circle" coords="665,542,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="270" shape="circle" coords="681,510,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="271" shape="circle" coords="691,475,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="272" shape="circle" coords="697,439,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="273" shape="circle" coords="701,403,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="274" shape="circle" coords="699,368,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="275" shape="circle" coords="695,334,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="276" shape="circle" coords="685,298,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="277" shape="circle" coords="673,264,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="278" shape="circle" coords="656,232,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="279" shape="circle" coords="638,201,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="280" shape="circle" coords="615,172,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="281" shape="circle" coords="591,145,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="282" shape="circle" coords="564,123,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="283" shape="circle" coords="533,104,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="284" shape="circle" coords="503,88,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="285" shape="circle" coords="469,73,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="286" shape="circle" coords="435,65,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="287" shape="circle" coords="400,60,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="288" shape="circle" coords="366,57,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="289" shape="circle" coords="330,59,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="290" shape="circle" coords="294,64,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="291" shape="circle" coords="260,75,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="292" shape="circle" coords="226,87,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="293" shape="circle" coords="195,103,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="294" shape="circle" coords="164,122,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="295" shape="circle" coords="136,143,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="296" shape="circle" coords="111,168,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="297" shape="circle" coords="86,196,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="298" shape="circle" coords="66,227,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="299" shape="circle" coords="47,260,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="300" shape="circle" coords="35,294,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="301" shape="circle" coords="28,331,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="302" shape="circle" coords="19,366,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                
                <area class="aire" id="303" shape="circle" coords="19,401,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="304" shape="circle" coords="20,437,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="305" shape="circle" coords="25,472,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="306" shape="circle" coords="34,505,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="307" shape="circle" coords="44,539,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="308" shape="circle" coords="61,570,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="309" shape="circle" coords="80,601,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="310" shape="circle" coords="102,629,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="311" shape="circle" coords="125,657,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="312" shape="circle" coords="153,681,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="313" shape="circle" coords="181,702,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="314" shape="circle" coords="212,720,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="315" shape="circle" coords="244,734,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="316" shape="circle" coords="278,744,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="317" shape="circle" coords="311,752,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="318" shape="circle" coords="346,756,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="319" shape="circle" coords="381,756,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="320" shape="circle" coords="415,753,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="321" shape="circle" coords="451,748,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="322" shape="circle" coords="484,739,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="323" shape="circle" coords="517,728,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="324" shape="circle" coords="550,710,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="325" shape="circle" coords="583,691,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="326" shape="circle" coords="610,668,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="327" shape="circle" coords="638,643,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="328" shape="circle" coords="661,618,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="329" shape="circle" coords="681,587,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="330" shape="circle" coords="699,559,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="331" shape="circle" coords="712,527,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="332" shape="circle" coords="723,493,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="333" shape="circle" coords="731,457,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="334" shape="circle" coords="735,424,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="335" shape="circle" coords="737,389,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="336" shape="circle" coords="733,353,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="337" shape="circle" coords="729,319,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="338" shape="circle" coords="718,284,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="339" shape="circle" coords="705,250,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="340" shape="circle" coords="691,218,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="341" shape="circle" coords="674,188,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="342" shape="circle" coords="652,157,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="343" shape="circle" coords="627,133,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="344" shape="circle" coords="602,107,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="345" shape="circle" coords="574,84,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="346" shape="circle" coords="544,67,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="347" shape="circle" coords="513,51,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="348" shape="circle" coords="480,39,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="349" shape="circle" coords="447,31,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="350" shape="circle" coords="413,24,15" href="#" onclick="clicCarte($(this).attr('id'))" />
                <area class="aire" id="351" shape="circle" coords="378,22,15" href="#" onclick="clicCarte($(this).attr('id'))" />
            </map>
        </div>   
       <script>
            function survolCarte(rang) 
            {
                $('#croix').css('visibility', 'hidden');
                $('#matrice').html("<img src='../images/matrices/"+rang+"_matrice.png'/>");
                var idMat = chercheIndiceMatrice(rang,tabToutesLesMatrices);
                MAJDescript(idMat);
            }
            function clicCarte(id) 
            {
                $('#enonce').val(id);
                $('#formulaire').submit();
            }
            function trouverNbSons(rangSaisi) 
            {
                var indice = chercheIndiceMatrice(rangSaisi,tabToutesLesMatrices);
                if(indice != null)
                {
                    $('#nbSonsPanneau').val(tabToutesLesMatrices[indice].nbSons);
                }
                else
                {
                    $('#descript-matrice').html("Non trouvée. Tapez un numéro de 3 chiffres");
                    $('#nbSonsPanneau').val("-");
                }
            }
            function MAJDescript(id)
            {
                var descript = chercheNomenclature(id,tabToutesLesMatrices);
                $('#descript-matrice').html(descript);
            }
            function exportMIDI(rang)
            {
                var enonce = chercheEnonceMatrice(rang,tabToutesLesMatrices);
                var freqChqNote = [];
                var freq = 60;
                for(var e=0;e<12;e++)
                {
                    freqChqNote[e] = freq;
                    freq++;
                }
                var notesEnonce = [];
                var duree = -0.5;
                for(e=0;e<enonce.length;e++)
                {
                    if(enonce[e]=="1")
                    {
                        duree=duree+0.5;
                        notesEnonce.push({
                            pitch: freqChqNote[e],
                            startTime: duree,
                            endTime: (duree+0.5),
                            velocity: 100});
                    }
                }
                console.log("notesEnonce "+notesEnonce);
                const sequence = {totalTime: 8, notes: notesEnonce}

                try {          
                    const quantizedSequence = mm.sequences.quantizeNoteSequence(sequence, 1)
                    var midi_bytes_array = mm.sequenceProtoToMidi(quantizedSequence)
                    saveByteArray("F12MIDI.mid", midi_bytes_array);
                
                } catch (error) {
                    console.error(error)
                }

                function saveByteArray(reportName, byte) {
                    var blob = new Blob([byte], {type: "audio/midi"});
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    var fileName = reportName;
                    link.download = fileName;
                    link.click();
                };
            }
        </script>
    </body>
</html>
