function reOrdonnerNotes(enonce,tabRotCoord,rotation)
{
    //Fonction pour ré-ordonner tabJSNotes en fonction de la rotation avec la nouvelle position des notes
    /*Trouver dans tabJSNotes à quelle note correspond cette rotation grâce à tabRotCoord*/
    var taille = tabJSNotes[0].taille;
    var e=0;
    var trouve=false;

    //Do est répertorié en position 360 degrés, si on a rotation == 0, c'est Do aussi. Donc on change 0 en 360
    
    if(rotation==0)
    {
        rotation=360;
    }

    while(e<tabRotCoord.length && trouve==false)
    {
        if(tabRotCoord[e].rotation==rotation)
        {
            trouve=true;
        }
        e++;
    }  
    indiceRot=e-1; /*L indice correspondant à la note à placer en premier dans tabJSNotes*/

    /*Changement ordre notes et création d'un tabJSNotesNouveau*/
    
    var i;
    str_enonce = enonce.toString();

    tabJSNotes.length = 0;

    for (i = 0; i < str_enonce.length; i++)
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
            on va arriver au bout de tabJSNotesNouveau si on ne remet pas à 0*/
            indiceRot=0; 
        }
        else
        {
            indiceRot++;
        }

    }
    

}