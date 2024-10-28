/*Changement ordre notes et création d'un tabJSNotesNouveau*/
    
var tabJSNotesNouveau = [];
console.log(enonce);
var tabEnonce = Array.from(enonce);

for(q=0;q<tabEnonce.lenght;q++)
{
    /*Pour chq bit de l enonce, on crée une note dans tabJSNotesNouveau *****************************
    EN COMMENCANT PAR LA NOTE QUI FIGURE A DROITE APRES ROTATION********************************* */

    if(tabEnonce[q]==1)
    {
        /*PAS BON. IL FAUT PRENDRE UNIQUEMENT LES NOTES à 1 dans l énoncé !!! */
        tabJSNotesNouveau.push
        ({
            numOrdreNote:tabRotCoord[indiceRot].numOrdre,
            nommidi:tabRotCoord[indiceRot].nommidi,
            frequence:tabRotCoord[indiceRot].frequence,
            nomNote:tabRotCoord[indiceRot].nomD,
            x:tabRotCoord[indiceRot].x,
            y:tabRotCoord[indiceRot].y,
            taille:tabRotCoord[indiceRot]
        });

        if(indiceRot==tabRotCoord.length-1)
        {
            /*Si on est parti du fa#, indiceRot été 6, 
            donc, on va arriver au bout de tabJSNotesNouveau si on ne remet pas à 0*/
            indiceRot=0; 
        }
        else
        {
            indiceRot++;
        }
    }
    console.log("tabJSNotesNouveau "+tabJSNotesNouveau);

    return tabJSNotesNouveau;
}
