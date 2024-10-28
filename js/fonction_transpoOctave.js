function transpoOctave(numOctave)
{

    //Rq. : On transpose à l'octave demandée, i.e. on met la première note de l'arpège AVANT AMBITUS à numOctave
    //Rq. : Il peut y avoir plusieurs octaves dans l'arpège, si on est passé par arpegeAscendant avant

    OctaveNoteDepart = arpege[0].substring(arpege[0].length-1,arpege[0].length);
    var note;
    console.log('OctaveNoteDepart '+OctaveNoteDepart);

    for(var n=0;n<arpege.length;n++)
    {
        note = arpege[n].toString();
        nomNote = note.substring(0,note.length-1);
        console.log('nomNote '+nomNote);
        OctaveNote = note.substring(note.length-1,note.length);
        console.log('OctaveNote '+OctaveNote);       
        difference = parseInt(OctaveNote) - parseInt(OctaveNoteDepart);
        console.log('difference '+difference); 
        
        if(n==0)
        {
            note = nomNote+numOctave.toString();
        }
        else
        {
            if(difference!=0)
            {
                note = nomNote+(parseInt(numOctave)+parseInt(difference)).toString();
            }
            else
            {
                note = nomNote+numOctave.toString();
            }
        }
        arpege[n]=note;
        
        console.log('note '+note); 
    }

    console.log("J'ai transposé "+arpege);
} 