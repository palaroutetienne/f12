function extractNotesEnonce(){
    
    console.log("extractNotesEnonce");

    var tabRotCoord = [];
    var rotation=360;
    //Lire l'énoncé dans tabToutesLesMatrices et créer les notes
    for (var s=0;s<12;s++)
    {
        //Création d un tableau JS pour contenir LES 12 NOTES, leur nom midi, rotation et coord
        tabRotCoord.push({
            nomD:etiquetteNote[s],
            nomB:"",
            nommidi:"",
            rotation:rotation-s*30,
            x:,
            y:,
            xetiq:,
            yetiq:,
            frequence:,
            numOrdre:s
        });
    }

    return tabRotCoord;
}