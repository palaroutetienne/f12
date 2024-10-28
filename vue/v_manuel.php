<script src="icheck/icheck.js"></script>

<script>
    $(document).ready(function(){
        $("#listeMatrices").val("0");

        $('input.pol1').iCheck({
            checkboxClass: 'iradio_polaris1'
        });
        $('input.pol2').iCheck({
            checkboxClass: 'iradio_polaris2'
        });
        $('input.pol3').iCheck({
            checkboxClass: 'iradio_polaris3'
        });
        $('input.pol4').iCheck({
            checkboxClass: 'iradio_polaris4'
        });
        $('input.pol5').iCheck({
            checkboxClass: 'iradio_polaris5'
        });
        $('input.pol6').iCheck({
            checkboxClass: 'iradio_polaris6'
        });
        $('input.pol7').iCheck({
            checkboxClass: 'iradio_polaris7'
        });
        $('input.pol8').iCheck({
            checkboxClass: 'iradio_polaris8'
        });
        $('input.pol9').iCheck({
            checkboxClass: 'iradio_polaris9'
        });
        $('input.pol10').iCheck({
            checkboxClass: 'iradio_polaris10'
        });
        $('input.pol11').iCheck({
            checkboxClass: 'iradio_polaris11'
        });
        $('input.pol12').iCheck({
            checkboxClass: 'iradio_polaris12'
        });
        $('input.pol').iCheck({
            checkboxClass: 'iradio_polaris'
        });
    });
</script>
<div id="message" class="text-center texte-blanc">
</div>

<form id="formulaire" method="POST" action="vue/v_manuelB.php">

    <input id="listeMatrices" type="hidden" name="listeMatrices" value=""/>  
    <input id="manuelB" type="hidden" name="manuelB" value="manuelB"/>

    <div class="container-fluid text-center fond-gris-manuel texte-blanc-encyc">
        <div class="row">
            <div class="col-4 text-center titre">
                TYPE
            </div>
            <div class="col-4 text-center titre">
                MUSICALITE
            </div>
            <div class="col-4 text-center titre">
                GEOMETRIE
            </div>
        </div>
        <div class="row">
                <div class="col-3">
                    <div class="row"><div class="col-10 p-0 text-right">1 son</div><div class="col-2"><input value="1" type="checkbox" class="pol1" name="type"></div></div>
                    <div class="row"><div class="col-10 p-0 text-right">2 sons</div><div class="col-2"><input value="2" type="checkbox"  class="pol2"  name="type"></div></div>
                    <div class="row"><div class="col-10 p-0 text-right">3 sons</div><div class="col-2"><input value="3" type="checkbox"  class="pol3" name="type"></div></div>
                    <div class="row"><div class="col-10 p-0 text-right">4 sons</div><div class="col-2"><input value="4" type="checkbox"  class="pol4" name="type"></div></div>
                    <div class="row"><div class="col-10 p-0 text-right">5 sons</div><div class="col-2"><input value="5" type="checkbox"  class="pol5" name="type"></div></div>
                    <div class="row"><div class="col-10 p-0 text-right">6 sons</div><div class="col-2"><input value="6" type="checkbox"  class="pol6" name="type"></div></div>
                    <div class="row"><div class="col-10 p-0 text-right">7 sons</div><div class="col-2"><input value="7" type="checkbox"  class="pol7" name="type"></div></div>
                    <div class="row"><div class="col-10 p-0 text-right">8 sons</div><div class="col-2"><input value="8" type="checkbox"  class="pol8" name="type"></div></div>
                    <div class="row"><div class="col-10 p-0 text-right">9 sons</div><div class="col-2"><input value="9" type="checkbox"  class="pol9" name="type"></div></div>
                    <div class="row"><div class="col-10 p-0 text-right">10 sons</div><div class="col-2"><input value="10" type="checkbox"  class="pol10" name="type"></div></div>
                    <div class="row"><div class="col-10 p-0 text-right">11 sons</div><div class="col-2"><input value="11" type="checkbox"  class="pol11" name="type"></div></div>
                    <div class="row"><div class="col-10 p-0 text-right">12 sons</div><div class="col-2"><input value="12" type="checkbox"  class="pol12" name="type"></div></div>
                </div>
                <div  id="centrage-ruby" class="col-1">
                    <div class="barre-horizontale">
                    </div>
                </div>
                <div class="col-2 text-right">
                    <div class="row"><div id="1" class="col-10 p-0 text-right aide">QUI</div><div class="col-2"><input value="QUI" type="checkbox" class="pol" name="musicalite"></div></div>
                    <div class="row"><div id="2" class="col-10 p-0 text-right aide">TON</div><div class="col-2"><input value="TON" type="checkbox" class="pol" name="musicalite"></div></div>
                    <div class="row"><div id="3" class="col-10 p-0 text-right aide">PSE</div><div class="col-2"><input value="PSE" type="checkbox" class="pol" name="musicalite"></div></div>
                    <div class="row"><div id="4" class="col-10 p-0 text-right aide">HYP</div><div class="col-2"><input value="HYP" type="checkbox" class="pol" name="musicalite"></div></div>
                    <div class="row"><div id="5" class="col-10 p-0 text-right aide">ATO</div><div class="col-2"><input value="ATO" type="checkbox" class="pol" name="musicalite"></div></div>
                    <div class="row"><div id="6" class="col-10 p-0 text-right aide">NEU</div><div class="col-2"><input value="" type="checkbox" class="pol" name="musicalite"></div></div>
                    <div class="row"><div id="7" class="col-10 p-0 text-right aide">CAD</div><div class="col-2"><input value="NEU" type="checkbox" class="pol" name="musicalite"></div></div>
                    <div class="row"><div id="8" class="col-10 p-0 text-right aide">TRP</div><div class="col-2"><input value="TRP" type="checkbox" class="pol" name="musicalite"></div></div>
                    <div class="row"><div id="9" class="col-10 p-0 text-right aide">ATL</div><div class="col-2"><input value="ATL" type="checkbox" class="pol" name="musicalite"></div></div>
                </div>
                <div class="col-2 text-left">
                    <div class="row"><div class="col-2"><input value="PAL" type="checkbox" class="pol" name="musicalite"></div><div id="10" class="col-10 text-left aide">PAL</div></div>
                    <div class="row"><div class="col-2"><input value="IDE" type="checkbox" class="pol" name="musicalite"></div><div id="11" class="col-10 text-left aide">IDE</div></div>
                    <div class="row"><div class="col-2"><input value="ISO" type="checkbox" class="pol" name="musicalite"></div><div id="12" class="col-10 text-left aide">ISO</div></div>
                    <div class="row"><div class="col-2"><input value="BIN" type="checkbox" class="pol" name="musicalite"></div><div id="13" class="col-10 text-left aide">BIN</div></div>
                    <div class="row"><div class="col-2"><input value="HIS" type="checkbox" class="pol" name="musicalite"></div><div id="14" class="col-10 text-left aide">HIS</div></div>
                    <div class="row"><div class="col-2"><input value="ORI" type="checkbox" class="pol" name="musicalite"></div><div id="15" class="col-10 text-left aide">ORI</div></div>
                    <div class="row"><div class="col-2"><input value="ATR" type="checkbox" class="pol" name="musicalite"></div><div id="16" class="col-10 text-left aide">ATR</div></div>
                    <div class="row"><div class="col-2"><input value="ANH" type="checkbox" class="pol" name="musicalite"></div><div id="17" class="col-10 text-left aide">ANH</div></div>
                    <div class="row"><div class="col-2"><input value="OMN" type="checkbox" class="pol" name="musicalite"></div><div id="18" class="col-10 text-left aide">OMN</div></div>
                </div>
                <div id="centrage-ruby" class="col-1">
                    <div class="barre-horizontale">
                    </div>
                </div>
                <div class="col-3 text-left">
                    <div class="row"><div class="col-2"><input value="PAN" type="checkbox" class="pol" name="geometrie"></div><div id="19" class="col-10 p-0 text-left aide">PAN</div></div>
                    <div class="row"><div class="col-2"><input value="TRS" type="checkbox" class="pol" name="geometrie"></div><div id="20" class="col-10 p-0 text-left aide">TRS</div></div>
                    <div class="row"><div class="col-2"><input value="HET" type="checkbox" class="pol" name="geometrie"></div><div id="21" class="col-10 p-0 text-left aide">HET</div></div>
                    <div class="row"><div class="col-2"><input value="ORT" type="checkbox" class="pol" name="geometrie"></div><div id="22" class="col-10 p-0 text-left aide">ORT</div></div>
                    <div class="row">
                        <div class="col-12 p-2">
                            <div class="barre-verticale"></div>
                        </div>
                    </div>
                    <div class="row d-flex flex-wrap align-items-center">
                        <div id="23" class="col-7 aide"><div id="flechasses" name="flechasses"></div></div>
                        <div class="col-5"><div class="ecran-num-matrice" id="numMat"></div></div>
                    </div>
                    <div class="row">
                        <div class="col-12 p-2">
                            <div class="barre-verticale"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="24" class="col-6 aide">
                            <div id="spirale" type="button" class="bouton-encyclopedie bouton_spirale" name="spirale"></div>
                        </div>
                        <div class="col-6">
                            <div class="texte-blanc titre">351</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 p-2">
                            <div class="barre-verticale"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div id="img-centre" class="col-12">
                            <button id="ok" type="button" class="btn bouton-encyclopedie bouton_ency_ok" name="ok"></button>
                        </div>
                    </div>
                    <div class="row">
                        <div id="25" class="col-6 aide">
                            <button id="annuler" type="button" class="btn bouton-encyclopedie bouton_ency_annuler" name="annuler"></button>
                        </div>
                        <div id="26" class="col-6 aide">
                            <div id="retour" type="button" class="btn bouton-encyclopedie bouton_ency_retour" name="retour"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- Fin fond Gris -->
    </div>
    <div class="row">
        <div id="incompatibilite" class="col-8">
        </div>
        <div class="col-4">
        </div>
    </div>
</form>

<?php
        //Attention, laisser uniquement 'r' sans le b de binaire pour Linux
        $fichierMessages = fopen('ressources/messages.csv','rb');
        if (FALSE === $fichierMessages)
        {
            exit("Echec lors de l'ouverture du fichier de messages");
        }
        else
        {
            //Parcours fichier csv des messages pour faire autant de div que de messages.
            while(($donnee = fgetcsv($fichierMessages, 1000, ";")) !== FALSE)
            {
                echo "
                    <div class='".$donnee[0]."' style='display:none'>
                        ".$donnee[1]."
                    </div>
                ";
            }
        }
    ?>
<script>
    $( document ).ready(function() {
        $(".aide").on("mouseover",function() {
            $("#message").html($('.'+$(this).attr('id')).html());
            $("#message").css("background-color", "#3d3b22a4");
        });
        $(".aide").on("mouseout",function() {
            $("#message").html("");
            $("#message").css("background-color", "transparent")
        });
        $("#retour").on("click",function() {
            javascript:window.location.href = "index.php";
        });
        $("#annuler").on("click",function() {
            $('#im').remove();
            /*Pas optimisé ...*/
            $("input[name='type']").each(function() {
                    this.checked=false;
            });
            $("input[name='musicalite']").each(function() {
                    this.checked=false;
            });
            $("input[name='geometrie']").each(function() {
                    this.checked=false;
            });
            javascript:window.location.reload();
        });
        $("#spirale").on("click",function() {
            javascript:window.location.href = "vue/v_spirale_manuel.php";
        });
        /*Gestion des boutons radio*/
        $("input").on('ifChecked', function(event){
            $("#listeMatrices").val("");
            var tabType = []; //Récup les cases cochée dans la colonne type
            $("input[name='type']:checkbox").each(function(){
                if(true == $(this).is(':checked')){
                    tabType.push($(this).val());
                }
            });
            var tabMusi = []; //Récup les cases cochée dans la colonne musicalité
            $("input[name='musicalite']:checkbox").each(function(){
                if(true == $(this).is(':checked')){
                    tabMusi.push($(this).val());
                }
            });
            var tabGeo = []; //Récup les cases cochée dans la colonne géométrie
            $("input[name='geometrie']:checkbox").each(function(){
                if(true == $(this).is(':checked')){
                    tabGeo.push($(this).val());
                }
            });
            var lesCochees = chercheNbMatrices(tabType,tabMusi,tabGeo);

            if(lesCochees!=0)
            {
                $('#im').remove();
                $("#numMat").html(lesCochees);
                console.log("OK");
            }
            else
            {
                console.log("pas OK");
                $("#numMat").html("incompatibles");
                $('#incompatibilite').html('<img id="im" src="images/cadre-incompatibilite.png"/>');
            }
        });
        $("input").on('ifUnchecked', function(event){
            $("#listeMatrices").val("");
            var tabType = []; //Récup les cases cochée dans la colonne type
            $("input[name='type']:checkbox").each(function(){
                if(true == $(this).is(':checked')){
                    tabType.push($(this).val());
                }
            });
            var tabMusi = []; //Récup les cases cochée dans la colonne musicalité
            $("input[name='musicalite']:checkbox").each(function(){
                if(true == $(this).is(':checked')){
                    tabMusi.push($(this).val());
                }
            });
            var tabGeo = []; //Récup les cases cochée dans la colonne géométrie
            $("input[name='geometrie']:checkbox").each(function(){
                if(true == $(this).is(':checked')){
                    tabGeo.push($(this).val());
                }
            });
            var lesCochees = chercheNbMatrices(tabType,tabMusi,tabGeo);
            if(lesCochees!=0)
            {
                $('#im').remove();
                $("#numMat").html(lesCochees);
                console.log("OK");
            }
            else
            {
                console.log("pas OK");
                $("#numMat").html("incompatibles");
                $('#incompatibilite').html('<img id="im" src="images/cadre-incompatibilite.png"/>');
            }
        });
        $('#ok').on('click', function(event){
            $("#formulaire").submit();
        });
        function chercheNbMatrices(type,musi,geo){
            console.log(type+" "+musi+" "+geo);
            <?php
                include_once("Matrice.php");
                include_once("Note.php");
                include_once("vue/matricePHPEnJS.php");
            ?>

            var trouve = false;
            var compteurMat = 0;
            //Pour stocker les rangs déja trouvés : 031-1,031-2 sont une seule matrice
            var dejaVu = []; 

            for(var i=0;i<tabToutesLesMatrices.length;i++)
            {
                //Faire un tableau de musi et de geo (il y a +sieurs musicalités et géométries par matrice, séparés par des ";")
                var tabMusi = tabToutesLesMatrices[i].musicalite.split(";");
                var tabGeo = tabToutesLesMatrices[i].geometrie.split(";");
                var trouveType = false;
                var trouveMusi = false;
                var trouveGeo = false;

                //Comparer la musicalité sélectionnée à toutes les musi de tabMusi, pareil pour geo et type
                if(type.length!=0)
                {
                    if(type.includes(tabToutesLesMatrices[i].nbSons.toString()))
                    {
                        trouveType = true;
                    }
                }
                else
                {
                    trouveType = true;
                }
                if(musi.length!=0)
                {
                    for(var x=0;x<tabMusi.length;x++)
                    {
                        if(musi.includes(tabMusi[x]))
                        {
                            trouveMusi = true;
                        }
                    }
                }
                else
                {
                    trouveMusi = true;
                }
                if(geo.length!=0)
                {
                    for(var y=0;y<tabMusi.length;y++)
                    {
                        if(geo.includes(tabGeo[y]))
                        {
                            trouveGeo = true;
                        }
                    }
                }
                else
                {
                    trouveGeo = true;
                }
                var rangPur;
                var rangTop;
                //On utilise ces trois résultats
                //pour savoir si on a une correspondance parmi les matrices
                if( trouveType && trouveMusi && trouveGeo)
                {
                    rangPur = tabToutesLesMatrices[i].rang.split(";");
                    rangTop = rangPur[0].split("-");

                    if(!dejaVu.includes(rangTop[0]))
                    {
                        if($('#listeMatrices').val() == '') 
                        {
                            $("#listeMatrices").val(tabToutesLesMatrices[i].id.toString());
                        }
                        else
                        {
                            $("#listeMatrices").val($("#listeMatrices").val()+";"+tabToutesLesMatrices[i].id.toString());
                        }
                        trouve=true;
                        compteurMat++;
                    }
                    dejaVu[i]=rangTop[0];
                }
            }
            return compteurMat;
        }
    });
</script>

