function creerPatron(sensArpege,arp,arpegeOri)
{
    var dimArpegeOri=arpegeOri.length;
    
    if(sensArpege == "")
    {
        sensArpege = "up";
    }
    
    var tabJSNotesBis = [];
    tabJSNotesTer = [];
    tabJSNotesBis = tabJSNotes;

    if(dimArpegeOri<arp.length)
    {
        //Transformation temporaire de tabJSNote pour que le patron et le Draw se passent bien pour qu'il soit aussi long qu'arp.
        
        var indice=0;

        for (i=0;i<arp.length;i++)
        {
            if(indice==dimArpegeOri)
            {
                indice=0;
            }
            tabJSNotesTer.push({
                nommidi:tabJSNotesBis[indice].nommidi,
                frequence:"",
                nomNote:"",
                x:tabJSNotesBis[indice].x,
                y:tabJSNotesBis[indice].y,
                taille:tabJSNotesBis[indice].taille
            });
            indice++; 
        }
    }
    else
    {
        tabJSNotesTer = tabJSNotes;
    }


    var index=0;

    var patron = new Tone.Pattern(
        function(time, note)
        { 
            // Draw.schedule takes a callback and a time to invoke the callback
            Tone.Draw.schedule(
                function()
                {
                    monSynthetiser.triggerAttackRelease(note, "4n", time);

                    /*Pour afficher les points rouges à chaque note jouée*/
                    index = arp.indexOf(note);
                    
                    var pointRouge = new Konva.Circle({
                        x: tabJSNotesTer[index].x, 	//Coord du point
                        y: tabJSNotesTer[index].y,   	//R.Q. : r, le rayon est le même que
                        fill: "#F90000FF",
                        stroke: 0,
                        /*blurRadius: 1,*/
                        height:tabJSNotesTer[0].taille, //Tous les points rouges ont la même taille
                        width: tabJSNotesTer[0].taille,
                        name: "pointRouge"+idMatriceGlobal
                    });

                    /*Instructions nécessaires pour que le blurRadius fonctionne*/
                    /*pointRouge.cache();
                    pointRouge.filters([Konva.Filters.Blur]);*/
                    
                    calqueNotCer.add(pointRouge);
                    calqueNotCer.draw();
                    
                    /*Pour enfoncer les notes sur le piano*/
                    if (document.querySelector('#' + note.replace("#", "diese")) != null)
                    {
                        var couleurOriginale = document.querySelector('#' + note.replace("#", "diese")).style.background;
                        document.querySelector('#' + note.replace("#", "diese")).style.background="#ff6200  ";
                        
                    }
                    setTimeout(() => {
                        pointRouge.destroy();
                        calqueNotCer.draw();
                        if (document.querySelector('#' + note.replace("#", "diese")) != null)
                        {
                            document.querySelector('#' + note.replace("#", "diese")).style.background=couleurOriginale;
                        }
                    }, 100);
                }, time);
        }, arp,sensArpege).start();

        return patron;
        
}