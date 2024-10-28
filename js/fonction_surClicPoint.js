function surClicPoint(point,calqueNoteEtCercle,canvas,r,r2,zoneDessin,ladiv,tabJSMat,tabToutesLesMatrices)
{
    
    var numeroPoint = point.getName().slice(5);	
    
    if(point.getFill() == 'white')
    {
        
        point.setHeight(canvas.height*.023); //0.023 parce que 0.03 cache le point rouge en survole
        point.setWidth(canvas.height*.023);
        point.setFill("black");
        point.fillStroke="black";
        
        //Trouver les infos sur la note dans tabRotCoord en fonction des coord et LES PLACER DANS tabJSNotes
        
        tabJSNotes.push({
            numOrdreNote:tabRotCoord[numeroPoint].numOrdre, /*Peut servir à réinit la matrice après rotation*/
            nommidi:tabRotCoord[numeroPoint].nommidi,
            frequence:tabRotCoord[numeroPoint].frequence,
            nomNote:tabRotCoord[numeroPoint].nomD,
            x:tabRotCoord[numeroPoint].x,
            y:tabRotCoord[numeroPoint].y,
            taille:canvas.height*.05
        });
   
    }
    else
    {
        point.setHeight(canvas.height*.015);
        point.setWidth(canvas.height*.015);
        point.setFill("white");
        point.fillStroke="black";
        
        //Trouver les infos sur la note dans tabJSNotes en fonction des coord et les SUPPRIMER DANS tabJSNotes
        index = tabJSNotes.findIndex(x => x.numOrdreNote === tabRotCoord[numeroPoint].numOrdre);
        tabJSNotes.splice(index,1);

    }
    
    //Trier tabJSNotes pour qu'il soit dans l'ordre des numOrdreNote
    if(tabJSNotes.length>0) //Seulement trier si plusieurs notes dans tabJSNotes
    {       
        var temporaire = [];
        
        for(var i=0;i<tabJSNotes.length;i++)
        {
            for(var j=i+1;j<tabJSNotes.length;j++)
            {
                if(parseInt(tabJSNotes[j].numOrdreNote)<parseInt(tabJSNotes[i].numOrdreNote))
                {
                    temporaire = tabJSNotes[i];
                    tabJSNotes[i]=tabJSNotes[j];
                    tabJSNotes[j]=temporaire;
                }   
            }   
            
        }
    }

    //Créer un énoncé binaire à partir tabJSNotes
    var enonceConstruit = ["0","0","0","0","0","0","0","0","0","0","0","0"];
    for(var h=0;h<tabJSNotes.length;h++)
    {
        enonceConstruit[tabJSNotes[h].numOrdreNote.toString()] = "1";
    }
    var enonceString = enonceConstruit.toString().replaceAll(',','');

    //Si ça ne commence pas pr 1
    if(enonceConstruit[0]!="1")
    {
        if(enonceString!="000000000000")
        {
            //Recherche de tous les possibles
            var tabEnonce = [];
            tabEnonce = enonceString.split("");

            //Tester l'élément de fin puis l'avant dernier, etc. jusqu'à ce que ce soit un "1"
            var t = tabEnonce.length-1;
            while(tabEnonce[t] != "1")
            {
                t--;
            }
            console.log("tabEnonce et t "+tabEnonce+" "+t);
            
            var tabOter = [];
            if(t!=0)
            {
                for(var w=t;w < tabEnonce.length;w++)
                {
                    tabOter[w-t] = tabEnonce[w];
                }
                console.log("tabOter "+tabOter);
                
                //Placer le 1 en première position et les suivants éventuels
                tabEnonce.splice(t,tabEnonce.length-t);
                tabEnonce.unshift(tabOter.toString());
                
                //Pour pouvoir comparer avec l'énoncé de toutesLesMatrices
                var enonceString = tabEnonce.toString().replaceAll(',','');

            }

        }

    }//Fin if commence pas par 1
    var g = afficherMatriceEureka(calqueNoteEtCercle,point,enonceString,r,zoneDessin,ladiv,tabJSMat,tabToutesLesMatrices);

    //Récup le rang de la matrice genre 001 et pas 001-1
    var tabRang = tabToutesLesMatrices[g].rang.toString().split(";");
    var joliRang = tabRang[0].split("-");
    document.getElementById("enonce").value = joliRang[0];
    document.getElementById("enonceSaisi").value = joliRang[0];
    document.getElementById("nb_sons").value = tabToutesLesMatrices[g].nbSons;

    //Recherche toutes les nomenclatures et ORIGINES
    //correspondantes au rang (ex. : celles de 001-1, 001-2 ...)
    var rangPur = [];
    var rangTop = [];
    rangPur = tabToutesLesMatrices[g].rang.split(";");
    rangTop = rangPur[0].split("-");
    var nomenclatures = chercheNomenclatureEureka(rangTop[0],tabToutesLesMatrices);
    document.getElementById("nomenclature").innerHTML = nomenclatures;
    console.log("bing !"+tabToutesLesMatrices[g].enonce);

}//Fin fonction