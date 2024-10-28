function traceLignes(tabJSMat,tabJSNotes,stage)
{
	console.log("traceLignes");
	
	/*Un calque pour les appeler tous et dans les ténèbres ... (Polygone + lignes)*/
	var calqueLignes = new Konva.Layer();
	calqueLignes.id("calqueLignes");

	if(tabJSNotes.length == 1)	//Matrice à une seule note
	{
		var matUnPoint = new Konva.Circle({
			fill:'#9C2B86',
			x: tabJSMat[0].x,
			y: tabJSMat[0].y,
			radius:tabJSMat[0].rayon
		});
		calqueLignes.add(matUnPoint);
		
	}
	else
	{

		/*Extraire les points qui servent à tracer le polygone*/
		var tableauPolygone1=[];
		var tableauPolygone2=[];
		
		for(nbSons=0;nbSons<tabJSNotes.length;nbSons++)
		{
			tableauPolygone1.push([tabJSNotes[nbSons].x,tabJSNotes[nbSons].y]);
			tableauPolygone2.push(tabJSNotes[nbSons].x,tabJSNotes[nbSons].y);
		}
		
		
		/*Pour les matrices bicolores : on trace un cercle bicolore et on le "clip avec la forme du polygone ci-dessous*/
		if(tabJSMat[0].bicolore)
		{
			var groupePolyg = new Konva.Group({
				clipFunc: function(ctx) {
					ctx.moveTo(0,0);
					ctx.beginPath();
					for(z=0;z<tableauPolygone1.length;z++)
					{
						//Là, c'est du Canvas, pas du Konajs
						//On trace le polygone qui sert à découper (clipper) les demi cercles bleu et rouge
						ctx.lineTo(tableauPolygone1[z][0],tableauPolygone1[z][1]);
					}
					ctx.closePath();
				},
				draggable: false
			});
	
			var demiCercleDroite = new Konva.Arc({
				x: tabJSMat[0].x,
				y: tabJSMat[0].y,
				innerRadius: 0,
				outerRadius: tabJSMat[0].rayon,
				angle: 180,
				rotation: 75,		//A CHANGER pour 90° quand j'aurai rétabli la position de la matrice à + 15°
				fill: '#66ccff'
			});
			groupePolyg.add(demiCercleDroite);
			var demiCercleGauche = new Konva.Arc({
				x: tabJSMat[0].x,
				y: tabJSMat[0].y,
				innerRadius: 0,
				outerRadius: tabJSMat[0].rayon,
				angle: 180,
				rotation: -105,		//A CHANGER pour 90° quand j'aurai rétabli la position de la matrice à + 15°
				fill: '#ff0000'
			});
			
			groupePolyg.add(demiCercleGauche);
			calqueLignes.add(groupePolyg); 
		}
		else //Si c'est unicolore
		{
			polygone = new Konva.Line({
				points: tableauPolygone2,
				closed: true,
				fill: tabJSMat[0].couleur
			});
			console.log(polygone.getFill());
			calqueLignes.add(polygone);
			polygone.moveToTop();
		}
	
		/*Ensuite les lignes traversantes*/
		
		//Cas de la matrice noire
		if(tabJSNotes.length==12){couleurLignes="white";}else{couleurLignes="black";}

		for(indice=0;indice<tabJSNotes.length;indice++)
		{
			var pointDepart=[];
			pointDepart[0] = tabJSNotes[indice].x;
			pointDepart[1] = tabJSNotes[indice].y;
			for(indice1=0;indice1<tabJSNotes.length;indice1++)
			{
				var ligne = new Konva.Line
				({
					points: [tabJSNotes[indice1].x, tabJSNotes[indice1].y,pointDepart[0],pointDepart[1]],
					stroke: couleurLignes,
					strokeWidth: 1
				});
				calqueLignes.add(ligne);
			}
		}
	}

	stage.add(calqueLignes);
	
	//Pour que les points ne soient pas recouverts par le violet
	if(tabJSNotes.length == 1)	//Matrice à une seule note
	{
		calqueLignes.moveToBottom();
	}
	stage.draw();

}