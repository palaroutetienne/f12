function reordEncyclopedie(indiceRot,enonce,rang)
{
    //Créer un énoncé binaire à partir l'énoncé et de l'indice du chiffre binaire à mettre en premier
    var enonceConstruit = ["0","0","0","0","0","0","0","0","0","0","0","0"];
    var enonceStr = enonce.toString();
    var indiceRotInt = parseInt(indiceRot);
    var indiceDepart = indiceRotInt;

    for(var h=0;h<enonceStr.length;h++)
    {
        if((indiceDepart+h)==enonceStr.length)
        {
            indiceRotInt=0;
        }

        enonceConstruit[h] = enonceStr[indiceRotInt];
        indiceRotInt++;
    }
    var enonceString = enonceConstruit.toString().replaceAll(',','');   
    
    var b=0;
    var trouveMatrice = false;
    var idMat=[];
    //Recherche de l énoncé dans tabToutesLesMatrice
    while(trouveMatrice == false && b<tabToutesLesMatrices.length)
    {
        console.log(tabToutesLesMatrices[b].rang);
        //Quand je trouve l'énoncé, comme il y a plusieurs matrices
        //avec le même énoncé, je les mémorise toutes pour afficher
        //toutes les nomenclatures à droite de l'écran ency
        if(tabToutesLesMatrices[b].enonce==enonceString)
        {
            trouveMatrice = true;
            while(tabToutesLesMatrices[b].enonce==enonceString && b<tabToutesLesMatrices.length)
            {
                console.log("Trouvé ! "+tabToutesLesMatrices[b].rang+" b "+b);
                idMat.push(b);
                b++;
            }
        }
        b++;
    }

    //Récup le rang de la matrice genre 001 et pas 001-1
    var tabRang = rang.toString().split(";");
    var joliRang = tabRang[0].split("-");
    document.getElementById("enonce-binaire").value = tabToutesLesMatrices[idMat[0]].enonce;
    document.getElementById("enonceSaisi").value = joliRang[0];
    document.getElementById("nb_sons").value = tabToutesLesMatrices[idMat[0]].nbSons;
    
    if(trouveMatrice == true)
    {
        for(var u=0;u<idMat.length;u++)
        {
            if(u==0)
            {
                document.getElementById("nomenclature").innerHTML = "<p>"+tabToutesLesMatrices[idMat[u]].nomenclature+
                "</p><p class=texte-gris>"+tabToutesLesMatrices[idMat[u]].origine+"</p>"+
                "</p><p class=texte-gris>"+tabToutesLesMatrices[idMat[u]].origineAnnexe+"</p>";
            }
            else
            {
                document.getElementById("nomenclature").innerHTML += "<p>"+tabToutesLesMatrices[idMat[u]].nomenclature+
                "</p><p class=texte-gris>"+tabToutesLesMatrices[idMat[u]].origine+"</p>"+
                "</p><p class=texte-gris>"+tabToutesLesMatrices[idMat[u]].origineAnnexe+"</p>";
            }
        }
    }
    else
    {
        document.getElementById("nomenclature").innerHTML = 
        "<p>Aucune de description trouvée.</p>";
    }

}//Fin fonction