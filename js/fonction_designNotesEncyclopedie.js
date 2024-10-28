function designNotesEncyclopedie(points,texteNotes,rot,enonce,tabRotCoord)
{

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
                texteNotes[indexNoteDepart].setFill("black");
                points[indexNoteDepart].setFill("black");
                points[indexNoteDepart].strokeWidth(10);
                //tabDesignNotes.push(tabRotCoord[indexNoteDepart].nommidi);
            }
            else
            {
                texteNotes[indexNoteDepart].setFill("transparent");
                points[indexNoteDepart].setFill("white");
                points[indexNoteDepart].setStroke("black");
            }
            indexNoteDepart++;
        }
    }
}