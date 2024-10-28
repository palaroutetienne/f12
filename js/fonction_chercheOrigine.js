function chercheOrigine(type,tabToutesLesMatrices)
{
    //Recherche toutes les NOMENCLATURES de matrices correspondant
    //à un type (origine annexe) pour bouton A-Z de siprale.php

    var a=0;
    var trouve=false;
    var idMat = [];
    
    while(a<tabToutesLesMatrices.length && trouve==false)
    {

        if(tabToutesLesMatrices[a].origineAnnexe==type)
        {
            trouveMatrice = true;
            while(tabToutesLesMatrices[a].origineAnnexe==type && a<tabToutesLesMatrices.length)
            {
                idMat.push(a);
                a++;
            }
        }
        a++;
    }

    var rangPur = [];
    var rangTop = [];
    //Tri du tableau tabToutesLesMatrices par nomenclatures ASC
    tabToutesLesMatrices.sort((a, b) => {
        if (a.nomenclature < b.nomenclature)
            return -1;
        if (a.nomenclature > b.nomenclature)
            return 1;
        return 0;
    });

    $('body').append("<div id='sous-menu'></div>");
    var nomenc = tabToutesLesMatrices[0].nomenclature;
    var divMenu = $('#sous-menu');
    divMenu.html();

    for(var c=0;c<idMat.length;c++)
    {
        rangPur = tabToutesLesMatrices[idMat[c]].rang.split(";");
        rangTop = rangPur[0].split('-');
        
        if(c==0)
        {
            divMenu.html("<div class='row menu-opt'><div id='"+rangTop[0]+"' class='col-12' onclick='soumettreChoixMenu(this.id)'>"+tabToutesLesMatrices[idMat[c]].nomenclature+"</div></div>"); 
            console.log(divMenu.html());
        }
        else
        {
            if(tabToutesLesMatrices[idMat[c]].nomenclature != nomenc)
            {
                divMenu.html(divMenu.html()+"<div class='row menu-opt'><div id='"+rangTop[0]+"' class='col-12' onclick='soumettreChoixMenu(this.id)'>"+tabToutesLesMatrices[idMat[c]].nomenclature+"</div></div>");
                console.log(divMenu.html());
            }
        }
        nomenc=tabToutesLesMatrices[idMat[c]].nomenclature;
    }
    divMenu.innerHTML = "</div>";
}