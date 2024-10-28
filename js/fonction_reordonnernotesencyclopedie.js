function reOrdonnerNotesEncyclopedie(enonce,tabRotCoord,indiceRot,rang)
{ /*L indice correspond à la note à placer en premier dans tabJSNotes*/

    //Fonction pour ré-ordonner tabJSNotes en fonction du num ordre de la note choisie dans Encyclopédie
    //Accessoirement, on pourrait chercher l'énoncé" dans toutes les matrices pour trouver la nomenclature
    
    var taille = tabJSNotes[0].taille;
    var e=0;
    var trouve=false;

    /*Changement ordre notes et création d'un tabJSNotes Nouveau*/
    
    var i;
    str_enonce = enonce.toString();

    tabJSNotes.length = 0;

    for(i = 0; i < str_enonce.length; i++)
    {
        /*Pour chq bit à 1 de l enonce, on crée une note dans tabJSNotes *****************************
        EN COMMENCANT PAR LA NOTE QUI FIGURE A DROITE APRES ROTATION********************************* */

        if(str_enonce[i]=='1')
        {
            tabJSNotes.push
            ({
                numOrdreNote:tabRotCoord[indiceRot].numOrdre,
                nommidi:tabRotCoord[indiceRot].nommidi,
                frequence:tabRotCoord[indiceRot].frequence,
                nomNote:tabRotCoord[indiceRot].nomD,
                x:parseFloat(tabRotCoord[i].x), /*ATTENTION, les emplacements des points rouges ne bougent pas après rotation*/
                y:parseFloat(tabRotCoord[i].y), /*quand il y a rotation !!! */
                taille:parseFloat(taille)
            });
        }

        if(indiceRot==tabRotCoord.length-1)
        {
            /*Si on est parti du fa#, que l'indiceRot était 6, 
            on va arriver au bout de tabJSNotes Nouveau si on ne remet pas à 0*/
            indiceRot=0; 
        }
        else
        {
            indiceRot++;
        }

    }

    //Recherche du nouvel énoncé dans toutes les matrices et on retroune la nomenclature correspondante.
    reordEncyclopedie(indiceRot,enonce,rang);

}