function designNotes(texteNotes,rot,enonce,tabRotCoord)
{
    //var tabDesignNotes = [];
    //Do est répertorié en position 360 degrés, si on a rotation == 0, c'est Do aussi. Donc on change 0 en 360
    
    if(rot==0)
    {
        rot=360;
    }

    //La rotation me donne la note de départ
    //var indexNoteDepart = tabRotCoord.findIndex((rotation) => rotation == rot);
    var y = 0;
    var trouve = false;
    var indexNoteDepart = -1;

    while(y<tabRotCoord.length && trouve==false)
    {
        if(parseInt(tabRotCoord[y].rotation)==parseInt(rot))
        {
            trouve = true;
            indexNoteDepart = y;
        }  
        y++;
    }

    var str_enonce = enonce.toString();
    var i;
    //L'énoncé me donne les suivantes à mettre en forme
    if(trouve)
    {
        for(i=0;i<str_enonce.length;i++)
        {
            if(parseInt(indexNoteDepart)==tabRotCoord.length)
            {
                indexNoteDepart=0;
            }
            if(str_enonce[i]=="1")
            {
                texteNotes[indexNoteDepart].setFill("white");
                //tabDesignNotes.push(tabRotCoord[indexNoteDepart].nommidi);
            }
            else
            {
                texteNotes[indexNoteDepart].setFill("black");
            }
            indexNoteDepart++;
        }
    }
}