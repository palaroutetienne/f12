<?php
//Fichier à inclure dansle window.onload

echo '
var tabToutesLesMatrices = [];
';
$fichierMatrices = fopen('ressources/listeMatrices4_2022_MusiEtGeo.csv','rb');
if (FALSE === $fichierMatrices)
{
        exit("Echec lors de l'ouverture du fichier de matrices");
}
else
{
    $ligne = 0;
    
    while(($donnee = fgetcsv($fichierMatrices, 1000, ",")) !== FALSE)
    {
        $ligne++;
    
        //Création de chaque matrice trouvée dans le fichier
        $uneDesMatrices = new Matrice($donnee[0],400,$donnee[1],$donnee[2],$donnee[3],$donnee[4],$donnee[5],$donnee[6],$donnee[8],$donnee[9],$donnee[7]);
        
        // Remplacer les sauts de lignes indésirables
    
        $caraInvisibles   = array("\r\n", "\n", "\r");
    
        $uneDesMatrices->setRang(str_replace($caraInvisibles, ";", $uneDesMatrices->getRang()));
        $uneDesMatrices->setMusicalite(str_replace($caraInvisibles, ";", $uneDesMatrices->getMusicalite()));
        $uneDesMatrices->setGeometrie(str_replace($caraInvisibles, ";", $uneDesMatrices->getGeometrie()));
        
        //Stoker chaque matrice dans un élément de tableau JS.
        echo '
        tabToutesLesMatrices.push({
            id:"'.$uneDesMatrices->getId().'",
            taille:"'.$uneDesMatrices->getTaille().'",
            nbSons:"'.$uneDesMatrices->getNbSons().'",
            enonce:"'.$uneDesMatrices->getEnonce().'",
            rang:"'.$uneDesMatrices->getRang().'",
            nomenclature:"'.$uneDesMatrices->getNomenclature().'",
            origine:"'.$uneDesMatrices->getOrigine().'",
            origineAnnexe:"'.$uneDesMatrices->getOrigineAnnexe().'",
            rayon:"'.$uneDesMatrices->getRayon().'",
            musicalite:"'.$uneDesMatrices->getMusicalite().'",
            geometrie:"'.$uneDesMatrices->getGeometrie().'",
            couleur:"'.$uneDesMatrices->getCouleur().'"
        });	
    
        ';
        
    }
    unset($uneDesMatrices); //Détruire l'objet PHP inutile
}

?>
