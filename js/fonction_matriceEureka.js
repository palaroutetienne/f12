function matriceEureka(r,r2,zoneDessin,ladiv,tabJSMat,tabToutesLesMatrices)
{

    //Déclaration des différentes notes avec leur angleNote correspondant
    //A FAIRE : instancier les notes tout de suite pour récupérer l angle et le nom généré par la classe Note

    var etiquetteNote=[
        "Do",
        "Do#",
        "Ré",
        "Ré#",
        "Mi",
        "Fa",
        "Fa#",
        "Sol",
        "Sol#",
        "La",
        "La#",
        "Si"
    ];

    var angleNote = [
        0,
        Math.PI/6,
        Math.PI/3,
        Math.PI/2,
        2*Math.PI/3,
        5*Math.PI/6,
        Math.PI,
        7*Math.PI/6,
        4*Math.PI/3,
        3*Math.PI/2,
        5*Math.PI/3,
        11*Math.PI/6
    ];
    
    var calqueNoteEtCercle = new Konva.Layer(); //Création d un calque

    // Créer un canevas dans la div Konva
    var canvas = document.createElement("canvas");
    canvas.width = zoneDessin.width();
    canvas.height = zoneDessin.height();

    // Le canevas créé sera inséré dans la div Konva comme un élément "image Konva"
    var image = new Konva.Image({
        image: canvas,
        x : 0,			//Pour faire commencer le canvas en haut à gauche du Konva.
        y : 0
    });

    /* ********************************************************************************* */
    var cercleTournant2 = new Konva.Circle({
        x : 240,	
        y : 240,
        radius: 196,   //Le rayon utilisé pour poser les étiquettes des notes.
        fill: "#00004457",
        name: cercleTournant2
    });

    var cercleTournant = new Konva.Circle({
        x : 240,	/*Pour ajouter la moitié de la taille du texte aux coordonnées du centre du cercle*/
        y : 240,
        radius: 140,	/*Le rayon utilisé par le quadrant de la matrice*/
        stroke: 10,
        fill: "#808080",
        name: cercleTournant
    });

    calqueNoteEtCercle.add(cercleTournant2);

    //***********************************************Important**************************
    
    calqueNoteEtCercle.add(cercleTournant);	//Montrer le cercle de couleur qui définit celle du quadrant
    calqueNoteEtCercle.add(image);			//Montrer le quadrant dans la matrice

    var contexte = canvas.getContext("2d");

    contexte.webkitImageSmoothingEnabled = true;
    contexte.msImageSmoothingEnabled = true;
    contexte.imageSmoothingEnabled = true;
   
    var texte = [];
    var point = [];
    var pointRouge = [];
    var groupEtiq = [];
    
    //le texte de la note, le groupe qu ils composent tous.
    for (var y=0;y<12;y++)
    {
        texte[y] = new Konva.Text({
            fontSize: ladiv.height*46/800,		//Taille police en fonction de celle du canvas et le fait que
            fontFamily: "bauhausregular",						//la taille 46 convienne à la hauteur de div 800px
            text: etiquetteNote[y],
            fill: "white",
            name: "texte"+y,
            align: "center",
            verticalAlign: "middle",
        });
        groupEtiq[y] = new Konva.Group({
            x: (Math.cos(angleNote[y])*r2+ladiv.width/2), 	//Coord du groupe Note à l affichage de la page
            y: (Math.sin(angleNote[y])*r2+ladiv.height/2),			//Ici, calculées par rapport au centre du canvas.
        });
        groupEtiq[y].add(texte[y]);
        //Centrage des étiquettes en paramétrant leur offset
        groupEtiq[y].setOffset({
            x:texte[y].getWidth()/2,
            y:texte[y].getHeight()/2
        });
        
        calqueNoteEtCercle.add(groupEtiq[y]);
    }
    calqueNoteEtCercle.draw();

    //Les 12 ronds noirs autour du cercle 

    for (var j=0;j<12;j++)
    {
        //Ronds pour chq note
        point[j] = new Konva.Circle({
            x: Math.cos(angleNote[j])*r+canvas.width/2, 	//Coord du point
            y: Math.sin(angleNote[j])*r+canvas.height/2,   	//R.Q. : r, le rayon est le même que
            stroke: 1,
            strokeFill: "black",
            height: canvas.height*.015,
            width: canvas.height*.015,          //Pour le cercle contenant la matrice.
            name: "point"+j                     //Ne doit pas tourner, donc pas partie du groupe.
        });
        
        point[j].setFill("white");

        pointRouge[j] = new Konva.Circle({
            x: point[j].getX(), 	//Coord du point
            y: point[j].getY(),   	//R.Q. : r, le rayon est plus grand que le point noir
            stroke: 0,
            strokeFill: "red",
            height: canvas.height*.03,
            width: canvas.height*.03,          //Pour le cercle contenant la matrice.
            name: "pointRouge"+j                     //Ne doit pas tourner, donc pas partie du groupe.
        });

        calqueNoteEtCercle.add(pointRouge[j]);
        
        point[j].on(
            "mouseover",function ()
            {
                var leStage = this.getStage();
                leStage.container().style.cursor = 'pointer';
                //Ronds pour chq note
                var numeroPoint = this.getName().slice(5);
                var pr = this.getLayer().findOne('.pointRouge' + numeroPoint);
                pr.setFill("red");
                pr.show();
                this.getLayer().draw();
            });
        point[j].on(
            "mouseout",function ()
            {
                var leStage = this.getStage();
                leStage.container().style.cursor = 'default';
                //Ronds pour chq note
                var numeroPoint = this.getName().slice(5);
                var pr = this.getLayer().findOne('.pointRouge' + numeroPoint);
                pr.hide();
                this.getLayer().draw();
            });

        point[j].on(
            "click",function()
            {
                surClicPoint(this,calqueNoteEtCercle,canvas,r,r2,zoneDessin,ladiv,tabJSMat,tabToutesLesMatrices);
            });

            calqueNoteEtCercle.add(point[j]);
            point[j].moveToTop();
    }//Fin for des points    
    calqueNoteEtCercle.draw();
    
    //Add the calqueNoteEtCercle to the zoneDessin
    zoneDessin.add(calqueNoteEtCercle);
    calqueNoteEtCercle.moveToTop(); 

}//Fin fonction