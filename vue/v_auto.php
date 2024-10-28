<script>
    $(document).ready(function(){
        $('#list-exporter-list').remove();
    });
</script>
<?php
$matrice = random_int(0,351);

echo '<div class="container-fluid fond-gris">
    <div class="row">
        <div class="col-md-12 text-center">

                <label for="enonceSaisi">AUTO&nbsp;&nbsp; 
                <sup>.</sup>
                &nbsp;&nbsp;Matrice propos&eacute;e&nbsp; 
                <img src="images/fleches_blanches.png"/>&nbsp; 
                N°&nbsp;
                </label>
                <input type="text" class="form-control" readonly id="enonceSaisi" value="'.sprintf("%03d",$matrice).'"/>';

include_once('Matrice.php');
include_once('Note.php');

//Attention, laisser uniquement 'r' sans le b de binaire pour Linux
$fichierMatrices = fopen('ressources/listeMatrices3_2020.csv','rb');
if (FALSE === $fichierMatrices)
{
    exit("Echec lors de l'ouverture du fichier de matrices");
}
else
{
    $ligne = 0;
    $trouve = FALSE; //Initialisation à "matrice pas encore trouvée"
    while(($donnee = fgetcsv($fichierMatrices, 1000, ",")) !== FALSE AND $trouve !== TRUE )
    {
        $ligne++;	
        $rang = explode("-",$donnee[3]);
        $premierematricetrouvee=$rang[0]; //Pour garder une trace du num de matrice avant de lire les enregistrements suivants
        if(sprintf("%03d",$rang[0]) == sprintf("%03d",$matrice))
        {
            $trouve = TRUE;
            $continue = TRUE;
            //Création première matrice trouvée dans le fichier
            $listeMatrices[$ligne] = new Matrice($donnee[0],100,$donnee[1],$donnee[2],$donnee[3],$donnee[4],$donnee[5],$donnee[6],NULL,NULL,$donnee[7]);
            
            //Stoker id matrice pour récup dans étude.
            echo '<input id="idMatrice" value="'.$donnee[0].'" type="hidden"/>';

            //On parcours toutes les "sous-matrices" ayant même début de numéro (rang)
            while(($donnee = fgetcsv($fichierMatrices, 1000, ",")) !== FALSE AND $continue == TRUE)
            {

                $rang = explode("-",$donnee[3]);
                if(sprintf("%03d",$rang[0]) !== sprintf("%03d",$matrice))
                {//Si on change de num matrice on arrête

                    $continue = FALSE;
                }
                else
                {//Sinon on crée la matrice suivante et on continue

                    //Création matrice pour la ligne du fichier correspondant à la matrice choisie
                    //ATTENTION CETTE MATRICE VA SE LOGER DANS QUELLE DIV ?
                    $ligne++;
                    $listeMatrices[$ligne] = new Matrice($donnee[0],100,$donnee[1],$donnee[2],$donnee[3],$donnee[4],$donnee[5],$donnee[6],NULL,NULL,$donnee[7]);
                }
            }
        }
    }
    fclose($fichierMatrices);
 
    echo ' 
                    &nbsp;&nbsp;de&nbsp;&nbsp;<input type="text" class="texte form-control" readonly id="nb_sons" value="'.sprintf("%02d",$listeMatrices[$ligne]->getNbSons()).'"/>&nbsp;&nbsp;sons

            </div> <!-- fin col-md-12 -->
        </div> <!-- fin row -->
        
        <div class="row no-gutters">
            
                <div class="col-md-5" id="fond_blanc_carre">
                    <img class="mx-auto" src="images/matrices/'.$premierematricetrouvee.'_matrice.png"/>
                </div>
                <div class="col-md-7" id="fond-blanc" >
                    <div id="nomenclature-auto" class="jumbotron texte">';
    if($trouve == TRUE)
    {
       foreach($listeMatrices as $matriceLue)
       {
            echo ' 
                        <p>'.$matriceLue->getNomenclature().'</p>
                        <p class="texte-gris">'.$matriceLue->getOrigine().'</p>';
        }
    }
    else
    {
        echo '<p>aucune matrice correspondante</p>';
    }
    echo 
                    '</div> <!-- fin texte -->    
                </div> <!-- fin fond-blanc -->

            </div> <!-- fin row -->';
}

?>

<div class="row">
    <div class="col-md-12 text-center">
            <div class='btn-group'>
                <form action='vue/v_etude.php' method='POST'>
                    <button class='btn bouton-image bouton_etudier' name="action" onclick='document.getElementById("enonce").value=document.getElementById("enonceSaisi").value;document.getElementById("idMatriceEnvoye").value=document.getElementById("idMatrice").value;' type='submit' value='v_etude'></button>
                    <input id='enonce' name='enonce' type='hidden'/>
                    <input id='idMatriceEnvoye' name='idMatriceEnvoye' type='hidden'/>
                </form>
<!-- Les boutons nont pas la même longueur mais ont la même hauteur. Ils sont mis automatiquement à la même longueur
Donc la largeur de Re-calculer est augmentée par rapport à Ok . Etudier  => PB de charte graphique Pour le régler : style='background-size: 86% ci-dessous -->
                <form action='index.php' method='POST'>
                    <button class='btn bouton-image bouton_recalculer' id="auto" name="auto" type='submit' value='v_auto' style='background-size: 86% !important;'></button>
                </form>
                <form action='index.php' method='POST'>
                    <button class='btn bouton-image bouton_retour' id="auto" name="retour" type='submit' style="background-size: 20% !important;background-position : center right !important;"></button>
                </form>
            </div>
    </div>
</div>
