<?php

class Matrice 			
{
	//Attributs dans l'ordre du document de Derek

	private $id;					//Identifiant de la matrice
	private $nbSons; 
	private $enonce; 
	private $rang; 
	private $nomenclature;
	private $origine;				//Origine musicale
	private $origineAnnexe;			//Origine musicale annexe
	private $musicalite; 
	private $geometrie; 
	private $noteDepartCourante;	//Défaut à 1
	private $taille;				//Le canevas est carré. On garde donc la dimension d'un côté
	private $rayon;					//défini par setRayon()
	private $xOrigine;				//Coordonnées du CENTRE de la matrice, définies par setXOrigine()
	private $yOrigine;
	private $listeNotes = array();
	private $listeToutesNotes = array();
	private $couleur;
	private $bicolore;
	
	//Operations
	
		public function __construct
		(
			$id,
			$taille,
			$nbSons,
			$enonce,
			$rang,
			$nomenclature,
			$origine,
			$origineAnnexe,
			$musicalite,
			$geometrie,
			$couleur
		)
		{

			$this->id = $id;
			$this->taille = $taille;
			$this->nbSons=$nbSons;
			$this->enonce = $enonce;
			$this->rang = $rang;
			$this->nomenclature=$nomenclature;
			$this->origine=$origine;
			$this->origineAnnexe=$origineAnnexe;
			$this->musicalite=$musicalite;
			$this->geometrie=$geometrie;			
			$this->noteDepartCourante=1;
			$this->couleur=$couleur;
			if($couleur == "bicolore")
			{
				$this->bicolore = true;
			}
			else
			{
				$this->bicolore = false;
			}
			
			$this->setOrigMatrice(); //Définit les coord de l'origine (CENTRE) de la matrice.
			
			$this->setRayon();	//Pour créer/dimensionner la matrice, il faut savoir la taille du canevas
		}

		public function afficher()
		{
			//Créer un canevas contenant la matrice telle qu'instanciée.
			$this->extracNotesEnonce();
			$this->traceMatrice();
		}
		public function afficherEncyclopedie()
		{
			//Créer un canevas contenant la matrice telle qu'instanciée.
			$this->extracNotesEnonce();
			$this->traceMatriceEncyclopedie();
		}

		public function extracNotesEnonce()
		{
			//Extraction des notes de l'énoncé
			//include_once('Note.php');
			$enon = str_split($this->enonce);
			//Création notes de la matrice

			echo'
			var tabRotCoord = [];
			var rotation=360;
			';

			for ($i=0;$i<count($enon);$i++)
			{

				if($enon[$i] == 1)
				{
					$this->listeNotes[count($this->listeNotes)] = new Note($i,$this->xOrigine,$this->yOrigine,$this->rayon,$this->taille);
				}
				$this->listeToutesNotes[count($this->listeToutesNotes)] = new Note($i,$this->xOrigine,$this->yOrigine,$this->rayon,$this->taille);
				
				//Création d un tableau JS pour contenir LES 12 NOTES, leur nom midi, rotation et coord
				echo '

				//A FAIRE : ajouter nomDUs et nomBUs pour notation US des notes ou EXTRAIRE depuis nommidi
				tabRotCoord.push({
					nomD:"'.$this->listeToutesNotes[$i]->getEtiquetteAbs().'",
					nomB:"'.$this->listeToutesNotes[$i]->getEtiquetteBemol().'",
					nommidi:"'.$this->listeToutesNotes[$i]->getNomMIDI().'",
					rotation:rotation-'.$i.'*30,
					x:"'.$this->listeToutesNotes[$i]->getXOrigine().'",
					y:"'.$this->listeToutesNotes[$i]->getYOrigine().'",
					xetiq:"'.$this->listeToutesNotes[$i]->getXOrigEtiq().'",
					yetiq:"'.$this->listeToutesNotes[$i]->getYOrigEtiq().'",
					frequence:"'.$this->listeToutesNotes[$i]->getFrequence().'",
					numOrdre:"'.$this->listeToutesNotes[$i]->getNumOrdre().'"
				});
				';
			}
		}
		
		public function traceMatrice()
		{//Les paramètres ne passent pas quand appelée par afficher()
			
			echo '
			var divMatrice'.$this->id.' = document.createElement("div");
			divMatrice'.$this->id.'.setAttribute("id", "zone'.$this->id.'");
			
			divMatrice'.$this->id.'.width='.$this->taille.';
			divMatrice'.$this->id.'.height='.$this->taille.';
			
			document.getElementById("contenuEtude").appendChild(divMatrice'.$this->id.');

        		var width'.$this->id.' =  '.$this->taille.'*1.2; /* multiplié par 1.2 pour que la poignée de rotation apparaisse*/
        		var height'.$this->id.' = '.$this->taille.'*1.2;

				//Déclaration des différentes notes avec leur angleNote correspondant
				//A FAIRE : instancier les notes tout de suite pour récupérer l angle et le nom généré par la classe Note
		
				var etiquetteNote'.$this->id.'=[
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
				var angleNote'.$this->id.' = [
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

				//On tente avec une rotation mais en
				//faisant tourner le texte de chaque note en tps réel pour le garder droit

				var zoneDessin'.$this->id.' = new Konva.Stage({
					container: "zone'.$this->id.'", //Pour mettre le canevas dans la div qu on lui a réservée
					width: width'.$this->id.',
					height: height'.$this->id.'
				});
				
				var calqueNoteEtCercle'.$this->id.' = new Konva.Layer(); //Création d un calque
		
				// Créer un canevas dans la div Konva
				var canvas'.$this->id.' = document.createElement("canvas");
				canvas'.$this->id.'.width = zoneDessin'.$this->id.'.width();
				canvas'.$this->id.'.height = zoneDessin'.$this->id.'.height();
		
				// Le canevas créé sera inséré dans la div Konva comme un élément "image Konva"
				var image'.$this->id.' = new Konva.Image({
					image: canvas'.$this->id.',
					x : 0,			//Pour faire commencer le canvas en haut à gauche du Konva.
					y : 0
				});
				
				/* ********************************************************************************* */
				var cercleTournant'.$this->id.'2 = new Konva.Circle({
					x : '.$this->xOrigine.',	
					y : '.$this->yOrigine.',
					radius: '.$this->rayon*1.4 .',   //Le rayon utilisé pour poser les étiquettes des notes.
					fill: "#00004457",
					name: cercleTournant'.$this->id.'2
				});
		
				var cercleTournant'.$this->id.' = new Konva.Circle({
					x : '.$this->xOrigine.',	/*Pour ajouter la moitié de la taille du texte aux coordonnées du centre du cercle*/
					y : '.$this->yOrigine.',
					radius: '.$this->rayon.',	/*Le rayon utilisé par le quadrant de la matrice*/
					stroke: 10,
					name: cercleTournant'.$this->id.'
				});

				calqueNoteEtCercle'.$this->id.'.add(cercleTournant'.$this->id.'2);
			
				//***********************************************Important**************************
				
				calqueNoteEtCercle'.$this->id.'.add(cercleTournant'.$this->id.');	//Montrer le cercle de couleur qui définit celle du quadrant
				calqueNoteEtCercle'.$this->id.'.add(image'.$this->id.');			//Montrer le quadrant dans la matrice

				var contexte'.$this->id.' = canvas'.$this->id.'.getContext("2d");

				//Empêcher la pixelisation des images quand zoom
				//contexte'.$this->id.'.mozImageSmoothingEnabled = true; ------ dépreciée

				contexte'.$this->id.'.webkitImageSmoothingEnabled = true;
				contexte'.$this->id.'.msImageSmoothingEnabled = true;
				contexte'.$this->id.'.imageSmoothingEnabled = true;
                ';
				$caraInvisibles   = array("\r\n", "\n", "\r");

				// Processes \r\n's first so they aren't converted twice.
				$this->setRang(str_replace($caraInvisibles, ";", $this->rang));
				//Création tableau JS pour stocker l'objet JS Matrice
				echo 'var tabJSMat = []; 
					/*Mémoriser les infos sur la matrice avant de passer à l étude*/
					
					tabJSMat.push({
						nomStage: "zoneDessin'.$this->id.'",
						enonce:'.$this->enonce.',
						x:'.$this->xOrigine.',
						y:'.$this->yOrigine.',
						rayon: '.$this->rayon.',	/*Le rayon utilisé par le quadrant de la matrice*/
						numMat:'.$this->id.',
						couleur:"'.$this->couleur.'",
						bicolore:'.(($this->bicolore==0)?"false":"true").',
						rang:"'.$this->rang.'"
						});
				';
				//Création tableau JS pour stocker tous les objets JS Note
				echo 'var tabJSNotes = []; ';

				//Gestion des CORDES reliant les points *********************************************

                $angle1=0;		//Les angles des deux points à relier par une corde sur le cercle
                $angle2=0;

                switch(count($this->listeNotes))
                {
                    case 2:
                        $angle1 = $this->listeNotes[0]->getAngle();
                        $angle2 = $this->listeNotes[1]->getAngle();

                        echo 'contexte'.$this->id.'.beginPath();
                            contexte'.$this->id.'.arc('.$this->xOrigine.','.$this->yOrigine.','.$this->rayon.','.$angle1.','.$angle2.',true);
							contexte'.$this->id.'.fillStyle = "#07b1ea";
							contexte'.$this->id.'.fill();
							contexte'.$this->id.'.moveTo('.$this->listeNotes[0]->getXOrigine().','.$this->listeNotes[0]->getYOrigine().');
							contexte'.$this->id.'.lineTo('.$this->listeNotes[1]->getXOrigine().','.$this->listeNotes[1]->getYOrigine().');
							contexte'.$this->id.'.strokeStyle = "black";
							contexte'.$this->id.'.stroke();
							contexte'.$this->id.'.closePath();
                            zoneDessin'.$this->id.'.add(calqueNoteEtCercle'.$this->id.');
							zoneDessin'.$this->id.'.draw();';
 
							//Mémoriser les notes, leur hauteur, leur position, leur nom Konva, leur num matrice et leur ordre
							for ($i=0;$i<count($this->listeNotes);$i++)
							{
								echo '
								tabJSNotes.push({
									numOrdreNote:'.$i.', /*Peut servir à réinit la matrice après rotation*/
									nommidi:"'.$this->listeNotes[$i]->getNomMIDI().'",
									frequence:'.$this->listeNotes[$i]->getFrequence().',
									nomNote:"'.$this->listeNotes[$i]->getEtiquetteAbs().'",
									x:'.$this->listeNotes[$i]->getXOrigine().',
									y:'.$this->listeNotes[$i]->getYOrigine().',
									taille:  canvas'.$this->id.'.height*.05
									});
								';
							}

                        break;
                    default:

                        for ($i=0;$i<count($this->listeNotes);$i++)
                        {
                            if($i==count($this->listeNotes)-1) //Pour la dernière note
                            {
                                $angle1 = $this->listeNotes[$i]->getAngle();
                                $angle2 = $this->listeNotes[0]->getAngle();
                            }
                            else
                            {
                                $angle1 = $this->listeNotes[$i]->getAngle();
                                $angle2 = $this->listeNotes[$i+1]->getAngle();
                            }

                            echo '
								//Corde
								
                                contexte'.$this->id.'.beginPath();
                                contexte'.$this->id.'.arc('
                                .$this->xOrigine.', '.$this->yOrigine.', '.$this->rayon.','.$angle1.','.$angle2.',true);
                                contexte'.$this->id.'.fillStyle = "grey";
                                contexte'.$this->id.'.fill();
								contexte'.$this->id.'.closePath();
    
                                //Ajouter layer au stage
                                zoneDessin'.$this->id.'.add(calqueNoteEtCercle'.$this->id.');
								zoneDessin'.$this->id.'.draw();
								
								//Mémoriser les notes, leur hauteur, leur position, leur nom Konva, leur num matrice et leur ordre
								
								tabJSNotes.push({
									numOrdreNote:'.$i.', /*Peut servir à réinit la matrice après rotation*/
									nommidi:"'.$this->listeNotes[$i]->getNomMIDI().'",
									frequence:'.$this->listeNotes[$i]->getFrequence().',
									nomNote:"'.$this->listeNotes[$i]->getEtiquetteAbs().'",
									x:'.$this->listeNotes[$i]->getXOrigine().',
									y:'.$this->listeNotes[$i]->getYOrigine().',
									taille:  canvas'.$this->id.'.height*.05
								  });
								
								';
							
                        }//Fin for
                        break;

                }//Fin switch';

				//Récup code traçant les ETIQUETTES *****************************************************
				
				echo $this->traceEtiq();

				//Appel fonction traçant les lignes

				echo '
				traceLignes(tabJSMat,tabJSNotes,zoneDessin'.$this->id.');
				';

		}	//Fin méthode traceMatrice()

        public function traceEtiq()
        {

            return '
		
				var r'.$this->id.' = '.$this->rayon.';    //Rayon du cercle des notes
				var r2'.$this->id.' = '.$this->rayon*1.2 .';    //Rayon (pas DIAMETRE) du cercle des points = 50% de la hauteur de la fenêtre

                //On tente avec une rotation globale mais en
                //faisant tourner le texte de chaque note en tps réel pour le garder droit
        
				/*
				* create a group which will be used to combine
				* multiple simple shapes.  Transforming the group will
				* transform all of the simple shapes together as
				* one unit
				*************************************************************************************************/
				var group'.$this->id.' = new Konva.Group({
					x: width'.$this->id.'/2,
					y: height'.$this->id.'/2,
					offsetX: width'.$this->id.'/2,
					offsetY: height'.$this->id.'/2
				});
		
				var groupe'.$this->id.' = [];
				var noteCercle'.$this->id.' = [];
				var texte'.$this->id.' = [];
				var point'.$this->id.' = [];

				//le texte de la note, le groupe qu ils composent tous.
				for (var y=0;y<12;y++)
				{

					texte'.$this->id.'[y] = new Konva.Text({
						fontSize: height'.$this->id.'*46/800,		//Taille police en fonction de celle du canvas et le fait que
						fontFamily: "bauhausregular",						//la taille 46 convienne à la hauteur de div 800px
						text: etiquetteNote'.$this->id.'[y],
						fill: "white",
						name: "texte'.$this->id.'"+y,
						align: "center",
						verticalAlign: "middle"
					});


					groupe'.$this->id.'[y] = new Konva.Group    // in a function we use "this";
					({
						x: Math.cos(angleNote'.$this->id.'[y])*r2'.$this->id.'+width'.$this->id.'/2, 	//Coord du groupe Note à l affichage de la page
						y: Math.sin(angleNote'.$this->id.'[y])*r2'.$this->id.'+height'.$this->id.'/2,			//Ici, calculées par rapport au centre du canvas.
						name: "groupe'.$this->id.'"+y
					});
					//Centrage des étiquettes en paramétrant leur offset
					groupe'.$this->id.'[y].setOffset({
						x:texte'.$this->id.'[y].getWidth()/2,
						y:texte'.$this->id.'[y].getHeight()/2
					});

					groupe'.$this->id.'[y].add(texte'.$this->id.'[y]);

					group'.$this->id.'.add(groupe'.$this->id.'[y]);

				}

				calqueNoteEtCercle'.$this->id.'.add(group'.$this->id.');

				//Les 12 ronds noirs autour du cercle 
				
				for (var j=0;j<12;j++)
				{
					//Ronds pour chq note
					point'.$this->id.'[j] = new Konva.Circle({
						x: Math.cos(angleNote'.$this->id.'[j])*r'.$this->id.'+canvas'.$this->id.'.width/2, 	//Coord du point
						y: Math.sin(angleNote'.$this->id.'[j])*r'.$this->id.'+canvas'.$this->id.'.height/2, //R.Q. : r, le rayon est le même que
						stroke: 1,
						strokeFill: "black",
						height: canvas'.$this->id.'.height*.015,
						width: canvas'.$this->id.'.height*.015,   //Pour le cercle contenant la matrice.
						name: "point'.$this->id.'"+j              //Ne doit pas tourner, donc pas partie du groupe.
					});

					point'.$this->id.'[j].setFill("white");

					point'.$this->id.'[j].on(
						"mouseover",function ()
						{				
							var numeroMatriceActive = this.getName().slice(5); 
							/*Le nom du point contient le num matrice et l indice*/
							var pointRouge = this.getLayer().findOne(\'.pointRouge\' + numeroMatriceActive);
							pointRouge.setFill("red");
							this.getLayer().draw();
						});
					point'.$this->id.'[j].on(
						"mouseout",function ()
						{				
							var numeroMatriceActive = this.getName().slice(5);
							var pointRouge = this.getLayer().findOne(\'.pointRouge\' + numeroMatriceActive);
							pointRouge.setFill("#AAAAAAFF");
							this.getLayer().draw();
						});
					point'.$this->id.'[j].on(
						"click",function ()
						{				
							var numeroMatriceActive = this.getName().slice(5);
							this.setHeight(canvas'.$this->id.'.height*.03);
							this.setWidth(canvas'.$this->id.'.height*.03);
							this.setFill("#00000000");
							this.fillStroke="black";
							this.getLayer().draw();
							console.log("point sélectionné :"+ this.getX() + this.getY() + this.getName());
						});
					calqueNoteEtCercle'.$this->id.'.add(point'.$this->id.'[j]);

				}

				var tr1'.$this->id.' = new Konva.Transformer({
					node: group'.$this->id.',
					rotationSnaps: [0, 30, 60, 90, 120, 150, 180, 210, 240, 270, 300, 330],
					resizeEnabled: false,
					anchorStroke: "#00000000",
					anchorFill: "#00000000",
					anchorSize: cercleTournant'.$this->id.'.getWidth()*1.4,
					borderEnabled: false,
					anchorCornerRadius: cercleTournant'.$this->id.'.getWidth()*1.4
				});

				tr1'.$this->id.'.rotateAnchorOffset(-height'.$this->id.'/2+50);
				
				calqueNoteEtCercle'.$this->id.'.add(tr1'.$this->id.');

				tr1'.$this->id.'.attachTo(group'.$this->id.');
				calqueNoteEtCercle'.$this->id.'.draw();
		
				// add the calqueNoteEtCercle to the zoneDessin
				zoneDessin'.$this->id.'.add(calqueNoteEtCercle'.$this->id.');

			
				group'.$this->id.'.on("transformstart",
				function surTransDeb() 
				{
					cercleTournant'.$this->id.'2.setStrokeWidth(1);
					cercleTournant'.$this->id.'2.setStroke("#57ffed");
					for (var v=0;v<12;v++)
					{
						groupe'.$this->id.'[v].opacity(0.5);
					}
				});
				group'.$this->id.'.on(
				"transformend",
				function surTransFin()
				{
					
					cercleTournant'.$this->id.'2.setStrokeWidth(0);
					cercleTournant'.$this->id.'2.setStroke("#00000000");
					
					/*Arrondir à la trentaine sup ou inf*/
					var arrondiAngle = arrondirAngle(group'.$this->id.'.rotation());
					
					group'.$this->id.'.rotation(0);

					group'.$this->id.'.rotate(arrondiAngle);

					for (var j=0;j<12;j++)
					{	/*Faire tourner tous les points dans le sens inverse de la rotation pour compenser*/
						var listeNotesDesign;
						designNotes(texte'.$this->id.',arrondiAngle,'.$this->enonce.',tabRotCoord);

						groupe'.$this->id.'[j].opacity(1);
						groupe'.$this->id.'[j].rotation(0);
						groupe'.$this->id.'[j].rotate(-group'.$this->id.'.rotation());
					}

					group'.$this->id.'.getLayer().draw();

					/*Tout ce qui importe vraiment, ici, c est de retenir la variation d angle liée à la rotation
					et d impacter en conséquence le tabJSNotes i.e. Changer l ordre des notes qu il contient.*/
					
					console.log("Je ré-ordonne tabJSNote avec les nouv coord des notes");

					reOrdonnerNotes(tabJSMat[0].enonce,tabRotCoord,arrondiAngle);
					
					arpege = [];

					//Je copie les notes de tabJSNotes dans l arpege
					for(i=0;i<tabJSNotes.length;i++)
					{
						arpege[i]=tabJSNotes[i].nommidi;
					}
					console.log("Je copie les notes de tabJSNotes dans l arpege");

					//Je corrige les erreurs d octave pour avoir un arpege ascendant
					arpege = arpegeAscendant(arpege,arrondiAngle);
					console.log("arpegeAscendant "+arpege);

					//Je mémorise l arpège ainsi créé pour usage dans creerPatron

					//Mémo de la rotation.
					memoRotation = arrondiAngle;

					//Remise à zéro des paramètres de la fenêtre Hauteurs
					RAZParam();
					
				});

				group'.$this->id.'.on(
				"transform",
				function surTrans()
				{
					/*Arrondir à la trentaine sup ou inf*/
					var arrondiAngle = arrondirAngle(group'.$this->id.'.rotation());

					group'.$this->id.'.setAbsolutePosition({
						x: width'.$this->id.'/2,
						y: height'.$this->id.'/2
					});

					for (var s=0;s<12;s++)
					{
						var listeNotesDesign;
						designNotes(texte'.$this->id.',arrondiAngle,'.$this->enonce.',tabRotCoord);
						
						groupe'.$this->id.'[s].rotation(0);
						groupe'.$this->id.'[s].rotate(-group'.$this->id.'.rotation());
					}

				});
				designNotes(texte'.$this->id.',360,'.$this->enonce.',tabRotCoord);
            ';
        }

		public function traceMatriceEncyclopedie()
		{//Les paramètres ne passent pas quand appelée par afficherEncyclopedie()
			
			echo '
			var divMatrice'.$this->id.' = document.createElement("div");
			divMatrice'.$this->id.'.setAttribute("id", "zone'.$this->id.'");
			
			divMatrice'.$this->id.'.width='.$this->taille.';
			divMatrice'.$this->id.'.height='.$this->taille.';
			
			document.getElementById("contenuEtudeEncyclopedie").appendChild(divMatrice'.$this->id.');

        		var width'.$this->id.' =  '.$this->taille.'*1.2; /* multiplié par 1.2 pour que la poignée de rotation apparaisse*/
        		var height'.$this->id.' = '.$this->taille.'*1.2;

				//Déclaration des différentes notes avec leur angleNote correspondant
				//A FAIRE : instancier les notes tout de suite pour récupérer l angle et le nom généré par la classe Note
		
				var etiquetteNote'.$this->id.'=[
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
				var angleNote'.$this->id.' = [
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

				var zoneDessin'.$this->id.' = new Konva.Stage({
					container: "zone'.$this->id.'", //Pour mettre le canevas dans la div qu on lui a réservée
					width: width'.$this->id.',
					height: height'.$this->id.'
				});
				
				var calqueNoteEtCercle'.$this->id.' = new Konva.Layer(); //Création d un calque
		
				// Créer un canevas dans la div Konva
				var canvas'.$this->id.' = document.createElement("canvas");
				canvas'.$this->id.'.width = zoneDessin'.$this->id.'.width();
				canvas'.$this->id.'.height = zoneDessin'.$this->id.'.height();
		
				// Le canevas créé sera inséré dans la div Konva comme un élément "image Konva"
				var image'.$this->id.' = new Konva.Image({
					image: canvas'.$this->id.',
					x : 0,			//Pour faire commencer le canvas en haut à gauche du Konva.
					y : 0
				});

				var cercleTournant'.$this->id.' = new Konva.Circle({
					x : '.$this->xOrigine.',	/*Pour ajouter la moitié de la taille du texte aux coordonnées du centre du cercle*/
					y : '.$this->yOrigine.',
					radius: '.$this->rayon.',	/*Le rayon utilisé par le quadrant de la matrice*/
					stroke: 10,
					name: cercleTournant'.$this->id.'
				});

			
				//***********************************************Important**************************
				
				calqueNoteEtCercle'.$this->id.'.add(cercleTournant'.$this->id.');	//Montrer le cercle de couleur qui définit celle du quadrant
				calqueNoteEtCercle'.$this->id.'.add(image'.$this->id.');			//Montrer le quadrant dans la matrice

				var contexte'.$this->id.' = canvas'.$this->id.'.getContext("2d");

				//Empêcher la pixelisation des images quand zoom
				//contexte'.$this->id.'.mozImageSmoothingEnabled = true; ------ dépreciée

				contexte'.$this->id.'.webkitImageSmoothingEnabled = true;
				contexte'.$this->id.'.msImageSmoothingEnabled = true;
				contexte'.$this->id.'.imageSmoothingEnabled = true;
                ';
				$caraInvisibles   = array("\r\n", "\n", "\r");

				// Processes \r\n's first so they aren't converted twice.
				$this->setRang(str_replace($caraInvisibles, ";", $this->rang));
				//Création tableau JS pour stocker l'objet JS Matrice
				echo 'var tabJSMat = []; 
					/*Mémoriser les infos sur la matrice avant de passer à l étude*/
					
					tabJSMat.push({
						nomStage: "zoneDessin'.$this->id.'",
						enonce:'.$this->enonce.',
						x:'.$this->xOrigine.',
						y:'.$this->yOrigine.',
						rayon: '.$this->rayon.',	/*Le rayon utilisé par le quadrant de la matrice*/
						numMat:'.$this->id.',
						couleur:"'.$this->couleur.'",
						bicolore:'.(($this->bicolore==0)?"false":"true").',
						rang:"'.$this->rang.'"
						});
				';
				//Création tableau JS pour stocker tous les objets JS Note
				echo 'var tabJSNotes = []; ';

				//Gestion des CORDES reliant les points *********************************************

                $angle1=0;		//Les angles des deux points à relier par une corde sur le cercle
                $angle2=0;

                switch(count($this->listeNotes))
                {
                    case 2:
                        $angle1 = $this->listeNotes[0]->getAngle();
                        $angle2 = $this->listeNotes[1]->getAngle();

                        echo 'contexte'.$this->id.'.beginPath();
                            contexte'.$this->id.'.arc('.$this->xOrigine.','.$this->yOrigine.','.$this->rayon.','.$angle1.','.$angle2.',true);
							contexte'.$this->id.'.fillStyle = "#07b1ea";
							contexte'.$this->id.'.fill();
							contexte'.$this->id.'.moveTo('.$this->listeNotes[0]->getXOrigine().','.$this->listeNotes[0]->getYOrigine().');
							contexte'.$this->id.'.lineTo('.$this->listeNotes[1]->getXOrigine().','.$this->listeNotes[1]->getYOrigine().');
							contexte'.$this->id.'.strokeStyle = "black";
							contexte'.$this->id.'.stroke();
							contexte'.$this->id.'.closePath();
                            zoneDessin'.$this->id.'.add(calqueNoteEtCercle'.$this->id.');
							zoneDessin'.$this->id.'.draw();';
 
							//Mémoriser les notes, leur hauteur, leur position, leur nom Konva, leur num matrice et leur ordre
							for ($i=0;$i<count($this->listeNotes);$i++)
							{
								echo '
								tabJSNotes.push({
									numOrdreNote:'.$i.', /*Peut servir à réinit la matrice après rotation*/
									nommidi:"'.$this->listeNotes[$i]->getNomMIDI().'",
									frequence:'.$this->listeNotes[$i]->getFrequence().',
									nomNote:"'.$this->listeNotes[$i]->getEtiquetteAbs().'",
									x:'.$this->listeNotes[$i]->getXOrigine().',
									y:'.$this->listeNotes[$i]->getYOrigine().',
									taille:  canvas'.$this->id.'.height*.05
									});
								';
							}

                        break;
                    default:

                        for ($i=0;$i<count($this->listeNotes);$i++)
                        {
                            if($i==count($this->listeNotes)-1) //Pour la dernière note
                            {
                                $angle1 = $this->listeNotes[$i]->getAngle();
                                $angle2 = $this->listeNotes[0]->getAngle();
                            }
                            else
                            {
                                $angle1 = $this->listeNotes[$i]->getAngle();
                                $angle2 = $this->listeNotes[$i+1]->getAngle();
                            }

                            echo '
								//Corde
								
                                contexte'.$this->id.'.beginPath();
                                contexte'.$this->id.'.arc('
                                .$this->xOrigine.', '.$this->yOrigine.', '.$this->rayon.','.$angle1.','.$angle2.',true);
                                contexte'.$this->id.'.fillStyle = "grey";
                                contexte'.$this->id.'.fill();
								contexte'.$this->id.'.closePath();
    
                                //Ajouter layer au stage
                                zoneDessin'.$this->id.'.add(calqueNoteEtCercle'.$this->id.');
								zoneDessin'.$this->id.'.draw();
								
								//Mémoriser les notes, leur hauteur, leur position, leur nom Konva, leur num matrice et leur ordre
								
								tabJSNotes.push({
									numOrdreNote:'.$i.', /*Peut servir à réinit la matrice après rotation*/
									nommidi:"'.$this->listeNotes[$i]->getNomMIDI().'",
									frequence:'.$this->listeNotes[$i]->getFrequence().',
									nomNote:"'.$this->listeNotes[$i]->getEtiquetteAbs().'",
									x:'.$this->listeNotes[$i]->getXOrigine().',
									y:'.$this->listeNotes[$i]->getYOrigine().',
									taille:  canvas'.$this->id.'.height*.05
								  });
								
								';
							
                        }//Fin for
                        break;

                }//Fin switch';

				//Récup code traçant les ETIQUETTES *****************************************************
				
				echo $this->traceEtiqEncyclopedie();

				//Appel fonction traçant les lignes

				echo '
				traceLignes(tabJSMat,tabJSNotes,zoneDessin'.$this->id.');
				';

		}	//Fin méthode traceMatriceEncyclopedie()


		public function traceEtiqEncyclopedie()
        {

            return '
		
				var r'.$this->id.' = '.$this->rayon.';    //Rayon du cercle des notes
				var r2'.$this->id.' = '.$this->rayon*1.2 .';    //Rayon (pas DIAMETRE) du cercle des points = 50% de la hauteur de la fenêtre

                //On tente avec une rotation globale mais en
                //faisant tourner le texte de chaque note en tps réel pour le garder droit
        
				/*
				* create a group which will be used to combine
				* multiple simple shapes.  Transforming the group will
				* transform all of the simple shapes together as
				* one unit
				*************************************************************************************************/
				var group'.$this->id.' = new Konva.Group({
					x: width'.$this->id.'/2,
					y: height'.$this->id.'/2,
					offsetX: width'.$this->id.'/2,
					offsetY: height'.$this->id.'/2
				});
		
				var groupe'.$this->id.' = [];
				var noteCercle'.$this->id.' = [];
				var texte'.$this->id.' = [];
				var point'.$this->id.' = [];
				var demiCercleVert'.$this->id.' = [];
				var demiCercleRouge'.$this->id.' = [];

				//Les 12 ronds noirs autour du cercle 
				
				for (var j=0;j<12;j++)
				{
					//Ronds pour chq note
					point'.$this->id.'[j] = new Konva.Circle({
						x: Math.cos(angleNote'.$this->id.'[j])*r'.$this->id.'+canvas'.$this->id.'.width/2, 	//Coord du point
						y: Math.sin(angleNote'.$this->id.'[j])*r'.$this->id.'+canvas'.$this->id.'.height/2, //R.Q. : r, le rayon est le même que
						stroke: 1,
						strokeFill: "black",
						height: canvas'.$this->id.'.height*.015,
						width: canvas'.$this->id.'.height*.015,
						name: "point'.$this->id.'"+j
					});
					
					point'.$this->id.'[j].setFill("white");

					calqueNoteEtCercle'.$this->id.'.add(point'.$this->id.'[j]);

				}

				//le texte de la note, le groupe qu ils composent tous.
				for (var y=0;y<12;y++)
				{
					texte'.$this->id.'[y] = new Konva.Text({
						fontSize: height'.$this->id.'*46/800,		//Taille police en fonction de celle du canvas et le fait que
						fontFamily: "bauhausregular",						//la taille 46 convienne à la hauteur de div 800px
						text: etiquetteNote'.$this->id.'[y],
						fill: "white",
						align: "center",
						verticalAlign: "middle",
						name: "texte"+'.$this->id.'+y,
						id:tabRotCoord[y].numOrdre
					});
		
					groupe'.$this->id.'[y] = new Konva.Group    // in a function we use "this";
					({
						x: Math.cos(angleNote'.$this->id.'[y])*r2'.$this->id.'+width'.$this->id.'/2, 	//Coord du groupe Note à l affichage de la page
						y: Math.sin(angleNote'.$this->id.'[y])*r2'.$this->id.'+height'.$this->id.'/2,			//Ici, calculées par rapport au centre du canvas.
						name: "groupe'.$this->id.'"+y
					});
					//Centrage des étiquettes en paramétrant leur offset
					groupe'.$this->id.'[y].setOffset({
						x:texte'.$this->id.'[y].getWidth()/2,
						y:texte'.$this->id.'[y].getHeight()/2
					});

					demiCercleVert'.$this->id.'[y] = new Konva.Arc({					
						name: "demiCercleVert'.$this->id.'"+y,
						x: groupe'.$this->id.'[y].getOffsetX(),
						y: groupe'.$this->id.'[y].getOffsetY(),
						fill: "transparent",
						innerRadius: canvas'.$this->id.'.height*.15*.6,
						outerRadius: canvas'.$this->id.'.height*.15*.5,
						strokeWidth: 1,
						stroke: "transparent",
						angle: 180,
						rotation: -90,
						name: "demiCercleVert"+'.$this->id.'+y
					});
				
					demiCercleRouge'.$this->id.'[y] = new Konva.Arc({					
						name: "demiCercleRouge'.$this->id.'"+y,
						x: groupe'.$this->id.'[y].getOffsetX(),
						y: groupe'.$this->id.'[y].getOffsetY(),
						fill: "transparent",
						innerRadius: canvas'.$this->id.'.height*.15*.6,
						outerRadius: canvas'.$this->id.'.height*.15*.5,
						strokeWidth: 1,
						stroke: "transparent",
						angle: 180,
						rotation: 90,
						name: "demiCercleRouge"+'.$this->id.'+y
					});
					
					texte'.$this->id.'[y].on("click", function () {
						
						var numNote = this.getId();

						/*Le nom du texte contient le num matrice et l indice*/
						var numeroMatriceEtIndice = this.getName().slice(5);
						console.log("clic sur "+numeroMatriceEtIndice);
						var demiCercleVert = this.getLayer().findOne(\'.demiCercleVert\' + numeroMatriceEtIndice);
						var demiCercleRouge = this.getLayer().findOne(\'.demiCercleRouge\' + numeroMatriceEtIndice);
						var punto = this.getLayer().findOne(\'.point\' + numeroMatriceEtIndice);
						
						var dejaClique = demiCercleVert.fill();
						var tousLesDemi =  this.getLayer().find(\'Arc\');
						
						if(this.fill() != "transparent" && dejaClique != "#14b16b")
						{
							/* Comprends pô çô ...
							demiCercleVert.zIndex(2);
							demiCercleRouge.zIndex(2);
							console.log(demiCercleVert.getParent().children.indexOf(demiCercleVert));
							console.log(demiCercleRouge.getParent().children.indexOf(demiCercleRouge));
							*/

							//Faire disparaître tous les Arcs
							tousLesDemi.forEach(function (demi) {
								demi.stroke("#00000000");
								demi.fill("#00000000");	
							});
							demiCercleVert.fill("#14b16b");
							demiCercleRouge.fill("#d60527");

							/*MEF point noir sur clic*/
							
							if(typeof punto2 !== "undefined"){
								punto2.destroy();
								punto3.destroy();
							}
							
							/*Clonage du point avec surcharge des attributs pour le faire de taille différente.*/
							punto2 = punto.clone({
								fill: "white",
								stroke: "black",
								strokeWidth: 1,
								radius:punto.radius()*2
							});
							
							punto3 = punto.clone({
								fill: "black",
								stroke: "black",
								strokeWidth: 1,
								radius:punto.radius()*.8
							});

							//Récup du num ordre de la note + enonce binaire pour retrouver la nomenclature
							reOrdonnerNotesEncyclopedie('.$this->enonce.',tabRotCoord,numNote,'.$_POST['enonceARecup'].');

							calqueNoteEtCercle'.$this->id.'.add(punto2);
							calqueNoteEtCercle'.$this->id.'.add(punto3);

							this.getLayer().draw();
						}
					});	

					groupe'.$this->id.'[y].add(demiCercleVert'.$this->id.'[y]);
					groupe'.$this->id.'[y].add(demiCercleRouge'.$this->id.'[y]);
					groupe'.$this->id.'[y].add(texte'.$this->id.'[y]);

					group'.$this->id.'.add(groupe'.$this->id.'[y]);

				}

				calqueNoteEtCercle'.$this->id.'.add(group'.$this->id.');

				designNotesEncyclopedie(point'.$this->id.',texte'.$this->id.',360,'.$this->enonce.',tabRotCoord);
            ';
        }
		public function getId()
		{
			return $this->id;
		}

		public function getNomenclature()
		{
			return $this->nomenclature;
		}
		
		public function getEnonce()
		{
			return $this->enonce;
		} 	
		public function getTaille()
		{
			return $this->taille;
		} 
		public function getRang()
		{
			return $this->rang;
		} 	
		public function getNbSons()
		{
			return $this->nbSons;
		} 	
		public function getOrigine()	//Originie musicale
		{
			return $this->origine;
		} 
		public function getOrigineAnnexe()	//Originie musicale annexe
		{
			return $this->origineAnnexe;
		} 	
		public function getMusicalite()
		{
			return $this->musicalite;
		} 	
		public function getGeometrie()
		{
			return $this->geometrie;
		} 	
		public function getNoteDepartCourante()
		{
			return $this->noteDepartCourante;
		}
		public function getLargCanevas()
		{
			return $this->largCanevas;
		}
		public function getHautCanevas()
		{
			return $this->hautCanevas;
		}
		public function getListeNotes()
		{
			return $this->listeNotes;
		}
		public function getXOrigine()
		{
			return $this->xOrigine;
		}
		public function getYOrigine()
		{
			return $this->yOrigine;
		}
		public function getRayon()
		{
			return $this->rayon;
		}
		public function getCouleur()
		{
			return $this->couleur;
		}
		public function getBicolore()
		{
			return $this->bicolore;
		}
		
		public function setNomenclature($nomenclature)
		{
			$this->nomenclature=$nomenclature;
		} 	
		public function setOrigMatrice()
		{
			
			//On définit les x0 et y0 pour pouvoir calculer la position des notes par rapport au canevas.
			$this->xOrigine = $this->taille*1.2/2; //*1.2 pour que la poignée de rotation apparaisse
			$this->yOrigine = $this->taille*1.2/2;
			
		}
		
		//A la création d une matrice, on définit le rayon en fonction de la taille du canevas.
		public function setRayon()
		{
			//La matrice représente 70% de la taille du canevas. Le rayon, c'est la moitié du résultat
			$this->rayon = $this->taille/2*0.7; 
		}

		public function setEnonce($enonce)
		{
			$this->enonce=$enonce;
		} 	
	 	
		public function setRang($rang)
		{
			$this->rang=$rang;
		} 	
		public function setNbSons($nbSons)
		{
			$this->nbSons=$nbSons;
		}
		public function setMusicalite($musicalite)
		{
			$this->musicalite=$musicalite;
		} 	
		public function setGeometrie($geometrie)
		{
			$this->geometrie=$geometrie;
		} 	
		public function setNoteDepartCourante($noteDepartCourante)
		{
			$this->noteDepartCourante=$noteDepartCourante;
		}
		
		public function setListeNotes($listeNotes)
		{
			$this->listeNotes=$listeNotes;
		}
		
		public function setListeToutesNotes($listeToutesNotes)
		{
			$this->listeToutesNotes=$listeToutesNotes;
		}
		
		public function setOrigine($origine)
		{
			$this->$origine=$origine; //Origine MUSICALE
		}
		
		public function setOrigineAnnexe($origineAnnexe)
		{
			$this->$origineAnnexe=$origineAnnexe; //Origine MUSICALE annexe
		}

} // End Class Matrice


?>

