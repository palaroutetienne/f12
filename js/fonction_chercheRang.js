function chercheRang(idMat,tabToutesLesMatrices)
{
    //Recherche un rang matrice d'après un id matrice (pour manuelB.php)
    var f=0;
    var trouve=false;
    while(f<tabToutesLesMatrices.length && trouve==false)
    {
        if(tabToutesLesMatrices[f].id == idMat){
            var rang = tabToutesLesMatrices[f].rang.split(";");
            trouve = true;
        }
        f++;
    }
    if(trouve==true){
        return rang[0];
    }
    else
    {
        return null;
    }
}