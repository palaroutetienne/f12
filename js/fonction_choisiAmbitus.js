function choisiAmbitus(ambitus,arpege)
{
    console.log("arpege debut ambitus "+arpege);

    if ($('input[name=registre]:checked', '#formHauteur') != null)
    {
        var OCTAVE_MILIEU = parseInt($('input[name=registre]:checked', '#formHauteur').val());
    }
    else
    {
        var OCTAVE_MILIEU = 4;
    }

    var extensionArpege=[];
    var note;
    var arpOri = arpege;
    var longArpOri = arpege.length;
    
    //PROBLEME : Si arpege est entre deux octaves, on n'en tient pas encore compte pour l'ambitus
    //Donc, j'utilise paramètre arpege pour savoir si et quand il y a rupture dans num octave.
    //Je note indice de arpege où est la rupture et je crée une variable rupture le contenant.
    var rupture=longArpOri; //Comme ça, on ne passera pas dans le si de rupture si il contient la valeur par défaut.
    
    for(var n=0;n<longArpOri-1;n++)
    {
        oc1 = arpege[n].substring(arpege[n].length-1,arpege[n].length);
        oc2 = arpege[n+1].substring(arpege[n+1].length-1,arpege[n+1].length);
        console.log("oc1 "+oc1+" oc2 "+oc2);

        if(oc1 != oc2)
        {
            rupture = n+1;
            console.log("rupture "+rupture);
            break;
        }
    }

    console.log("ambitus "+ambitus);
 
    if(ambitus!=0)
    {
        var i = 0;
        while(i<Math.abs(ambitus))
        {
            console.log("tour n°"+i);

            for(var n=0;n<longArpOri;n++)
            {
                var iBis = i;
                var iTer = i;
                //Gestion rupture d'octave dans l'arpège
                if(n>=rupture)
                {
                    iBis++;
                    iTer--;
                }
                
                //J'extrais la partie textuelle de la note et j'ajoute le numéro d'octave voulue
                note = arpege[n].toString();

                if(ambitus<0)
                {
                    console.log("ambitus<0");
                    note = (note.substring(0,note.length-1)).toString()+(OCTAVE_MILIEU-iTer-1).toString(); 
                }
                else
                {
                    console.log("ambitus>0");
                    note = (note.substring(0,note.length-1)).toString()+(OCTAVE_MILIEU+iBis+1).toString(); 
                }
                console.log("note "+note);

                extensionArpege[n]=note;

                //Gestion rupture d'octave dans l'arpège
            }

            if(ambitus<0)
            {
                arpege = extensionArpege.concat(arpege);
            }
            else
            {
                arpege = arpege.concat(extensionArpege);
            }

            i++;
        }

        return arpege;
    }
    else
    {
        return arpOri;
    }

}
