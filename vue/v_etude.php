<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>FORCE 12</title>
		
		<link rel="stylesheet" type="text/css" href="../css/style.css">
		<link rel="stylesheet" href="../js/bootstrap-4.0.0-dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
		
		<link rel="stylesheet" href="../css/piano.css">
		<link rel="stylesheet" type="text/css" href="../css/guitare.css" />
	
		<script src="../js/konva.min.js"></script>
		<script src="../js/ui-master/dist/NexusUI.min.js"></script>
		<script src="../js/Tone.js"></script>
		<script src="../js/jquery-3.3.1.min.js"></script>
		<script src="../js/webcomponentsjs-master/externs/webcomponents.js"></script>
		
		<script src="../js/fonction_creerPatron.js"></script>
		<script src="../js/fonction_couleur_octaves.js"></script>
		<script src="../js/fonction_transpoOctave.js"></script>
		<script src="../js/fonction_choisiAmbitus.js"></script>
		<script src="../js/fonction_traceLignes.js"></script>
		<script src="../js/fonction_reordonnernotes.js"></script>
		<script src="../js/fonction_designNotes.js"></script>
		<script src="../js/fonction_construireArpege.js"></script>
		<script src="../js/fonction_arpegeAscendant.js"></script>
		<script src="../js/fonction_RAZParam.js"></script>
		<script src="../js/piano.js"></script>
		<script src="../js/guitare.js"></script>
		<script src="../js/fonction_chercheEnonceMatrice.js"></script>
		<script src="../js/fonction_arrondirAngle.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/@magenta/music"></script>

		<script type="text/javascript">
			volume = new Tone.Volume(-Infinity).toMaster();
		</script>

	</head>
<body>
	<?php
		include_once("logoF12.html");
	?>
	<center>
		<div class="grille-globale">
			<div class="grille-verticale1-btn">
				<div></div>
				<div class="bouton bouton_tempo"></div>
				<div class="bouton bouton_hauteur"></div>
				<div class="bouton">
					<img id="bouton-piano" src="../images/but_piano.png"/>
					<img id="bouton-guitare" src="../images/but_guitare.png"/>
				</div>
				<div id="btn_ency" class="bouton bouton_encyclopedie"></div>
				<form id="formInvisible" method="POST" action="../index.php">
					<!-- A corriger deux attributs name -->
					<input id="enonceARecup" name="enonceARecup" type="hidden" value="<?php echo $_POST['enonce'];?>"/>
					<input id="encyclopedie" type="hidden" value="1" name="encyclopedie"/>
				</form>
			</div>
			<div id="contenuEtude">
				<div class='fond_hauteur'>
					<form id='formHauteur' class='texte_form'>
						REGISTRE<BR/>
						<input class="bouton_radio" type="radio" name="registre" value=0>
						<label for="reg0">0</label>
						<input class="bouton_radio" type="radio" name="registre" value=1>
						<label for="reg1">1</label>
						<input class="bouton_radio" type="radio" name="registre" value=2>
						<label for="reg2">2</label>
						<input class="bouton_radio" type="radio" name="registre" value=3>
						<label for="reg3">3</label>
						<input class="bouton_radio" type="radio" name="registre" value=4 checked="checked">
						<label for="reg4">4</label>
						<input class="bouton_radio" type="radio" name="registre" value=5>
						<label for="reg5">5</label>
						<input class="bouton_radio" type="radio" name="registre" value=6>
						<label for="reg6">6</label> <BR/>
						AMBITUS<BR/>
						<center>
							<Table>
								<tr>
									<td><label for="amb-48">-48</label></td>
									<td><label for="amb-36">-36</label></td>
									<td><label for="amb-24">-24</label></td>
									<td><label for="amb-12">-12</label></td>
									<td><label for="amb0">0</label></td>
									<td><label for="amb12">12</label></td>
									<td><label for="amb24">24</label></td>
									<td><label for="amb36">36</label></td>
									<td><label for="amb48">48</label></td>
								</tr>
								<tr>
									<td><input class="bouton_radio" type="radio" name="ambitus" value=-4></td>
									<td><input class="bouton_radio" type="radio" name="ambitus" value=-3></td>
									<td><input class="bouton_radio" type="radio" name="ambitus" value=-2></td>
									<td><input class="bouton_radio" type="radio" name="ambitus" value=-1></td>
									<td><input class="bouton_radio" type="radio" name="ambitus" value=0 checked="checked"/></td>
									<td><input class="bouton_radio" type="radio" name="ambitus" value=1></td>
									<td><input class="bouton_radio" type="radio" name="ambitus" value=2></td>
									<td><input class="bouton_radio" type="radio" name="ambitus" value=3></td>
									<td><input class="bouton_radio" type="radio" name="ambitus" value=4></td>
								</tr>
							</Table>
						</center>
						CYCLE<BR/>
						<input class="bouton_radio" type="radio" name="cycle" value="a" checked="checked"/>
						<label for="cyca">Acsendant</label>
						<input class="bouton_radio" type="radio" name="cycle" value="d"/>
						<label for="cycd">Descendant</label> <BR/>
						<input class="bouton_radio" type="radio" name="cycle" value="ad"/>
						<label for="cycad">Ascendant + Descendant</label> <BR/>
						<input class="bouton_radio" type="radio" name="cycle" value="da"/>					
						<label for="cycda">Descendant + Ascendant</label> <BR/>
						<div class='bouton_ok_hauteur'></div>
					</form>
					
				</div>
			</div>
			<div class="grille-verticale3-btn">
				<div></div>
				<div id="ecouter" class="bouton bouton_ecouter fond-gris-btn"></div>
				<div class="grille-horizontale-btn fond-gris-btn">
					<div class="bouton bouton_annuler" id="arreter"></div>
					<div class="bouton bouton_retour" id="retour"></div>
				</div>
			</div>
		</div>

		<div class="grille-une_cellule">
			<div id="vol"></div>
		</div>
		<div class="grille-horizontale-tempo">
			<div id="tempo"></div>
			<div id="texte-tempo">XXX</div>
		</div>

		<div id="conteneur_piano" class="conteneur">
			<div id="marge_piano" class="col-md-12 mx-auto">
				<div id="keyboard">
				</div>
			</div>
		</div>
		<div id="conteneur_guitare">
			<div id="marge_guitare">
				<div id="guitar">
				</div>
			</div>
		</div>
	</center>
		<?php
		//Recherche d'une matrice dans le fichier par son énoncé
		include_once('../Matrice.php');
		include_once('../Note.php');
		
		echo '

		<script type="text/javascript">

		window.onload
		{
			var memoRotation;
		';

		//Attention, laisser uniquement 'r' sans le b de binaire pour LINUX
		$fichierMatrices = fopen('../ressources/listeMatrices4_2022_MusiEtGeo.csv','rb');

		//Dimension de l'écran
		if (!isset($dimension)){$dimension=800;}
		
		/*Attention ..............................$_POST['enonce'] contient en fait un NUMERO de MATRICE, 
		* pas vraiment un énoncé binaire ...*/

		if (FALSE === $fichierMatrices)
		{
			exit("Echec lors de l'ouverture du fichier de matrices");
		}
		else
		{
			$ligne = 0;
			$nbmat=0;

			while(($donnee = fgetcsv($fichierMatrices, 1000, ",")) !== FALSE)
			{	
				
				if(substr($donnee[3],0,3) == $_POST['enonce'])
				{
					
					//Comptage nb matrices trouvées
					$nbmat=$nbmat+1;

					//Création matrice pour chaque ligne du fichier 
					//lu avec chaque champ de chaque ligne comme attribut
					$listeMatrices[$ligne] = new Matrice($donnee[0],$dimension/2,$donnee[1],$donnee[2],$donnee[3],$donnee[4],$donnee[5],$donnee[6],NULL,NULL,$donnee[7]);
					if($nbmat==1)
					{
						$listeMatrices[$ligne]->afficher();
					}
					
					//Pour traiter les matrices ayant plusieurs énoncés
					$caraInvisibles   = array("\r\n", "\n", "\r");
					$rangs = str_replace($caraInvisibles, ";", $listeMatrices[$ligne]->getRang());
					$listeMatrices[$ligne]->setRang($rangs[0]);

				}
				$ligne++;

			}
			include_once('matricePHPEnJSBis.php');
			fclose($fichierMatrices);
			echo '
				var arpege = construireArpege(rotation,tabRotCoord);
				arpegeOriginal = arpege; //Sauvegarde de l arpege du début de l étude
			
				function exportMIDIArp(arpege)
				{
					var notesEnonce = [];
					var duree = -0.5;
					for(e=0;e<arpege.length;e++)
					{
							duree=duree+0.5;
							notesEnonce.push({
								pitch: Tone.Midi(arpege[e]).toMidi(),
								startTime: duree,
								endTime: (duree+0.5),
								velocity: 100});
					}
					const sequence = {totalTime: 8, notes: notesEnonce}
	
					try {          
						const quantizedSequence = mm.sequences.quantizeNoteSequence(sequence, 1)
						var midi_bytes_array = mm.sequenceProtoToMidi(quantizedSequence)
						saveByteArray("F12MIDI.mid", midi_bytes_array);
					
					} catch (error) {
						console.error(error)
					}
	
					function saveByteArray(reportName, byte) {
						var blob = new Blob([byte], {type: "audio/midi"});
						var link = document.createElement("a");
						link.href = window.URL.createObjectURL(blob);
						var fileName = reportName;
						link.download = fileName;
						link.click();
					};
				}
			} //Fin de window.onload
			$( document ).ready(function() {
				$("#list-exporter-list").on("click", function(){
					var arpEnvers = [...arpege]; 	/*On copie l arpège*/
					arpEnvers.reverse();			/*On le retourne*/
					switch ($("input[name=cycle]:checked", "#formHauteur").val()) {
						case "d":
							arpege = arpEnvers;
							break;
						case "da":
							arpege = arpEnvers.concat(arpege);
							break;
						case "ad":
							arpege = arpege.concat(arpEnvers);
							break;
					}
					exportMIDIArp(arpege);
				});
			});

		</script>';
		}

		?>

		<script type="text/javascript">


			//Créer le patron
			
			patron = creerPatron("",arpege,arpegeOriginal);
			
			Nexus.context = Tone.context;
			
			Nexus.colors.accent = "#0000";
			Nexus.colors.fill = "#0000";
			Nexus.colors.text = "#fff";

			idMatriceGlobal = tabJSMat[0].numMat; //Variable globale !
			var calqueNotCer = window['calqueNoteEtCercle'+idMatriceGlobal];

			//Boutons de gauche
			$(".grille-horizontale-tempo").hide();

			$(".bouton_tempo").click(function(){
				$(".grille-horizontale-tempo").toggle();
			});

			$("#conteneur_piano").hide();
			$("#conteneur_guitare").hide();
			
			$( document ).ready(function() {
				$("#bouton-piano").click(function(){
					if($("#keyboard").children().length == 0) //Si rien dans la div keyboard
					{
						piano();
						$("#guitar").empty();
					}
					var source = $(this).attr("src");
					if(source == "../images/but_piano.png")
					{
						$(this).attr("src","../images/but_piano_rouge.png");
						$("#bouton-guitare").attr("src","../images/but_guitare.png");
					}
					else
					{
						$("#keyboard").empty();
						$("#conteneur_piano").hide();
						$(this).attr("src","../images/but_piano.png");
					}
  				});
				$("#bouton-guitare").click(function(){
					if($("#guitar").children().length == 0) //Si rien dans la div guitar
					{
						guitare();
						$("#keyboard").empty();
					}
					var source = $(this).attr("src");
					if(source == "../images/but_guitare.png")
					{
						$(this).attr("src","../images/but_guitare_rouge.png");
						$("#bouton-piano").attr("src","../images/but_piano.png");
					}
					else
					{
						$("#guitar").empty();
						$("#conteneur_guitare").hide();
						$(this).attr("src","../images/but_guitare.png");
					}
  				});
			});
			$(".bouton_hauteur").click(function(){
				$( "#zone"+idMatriceGlobal ).hide();
				var tailleMatrice = window["zoneDessin"+idMatriceGlobal].getHeight().toString();
				$( "#contenuEtude" ).css({
					"height": tailleMatrice,
					"width":  tailleMatrice
				});
				$( ".fond_hauteur" ).show();
			});

			/*
			$(".bouton_encyclopedie").click(function(){
				//Sauvegarder le stage dans une chaîne json
				var monJason = window["zoneDessin"+idMatriceGlobal].toJSON();
				var tailleMatrice = window["zoneDessin"+idMatriceGlobal].getHeight().toString();
				var tailleMatrice2 = tailleMatrice*2;
				$( "#zone"+idMatriceGlobal ).hide();
				$( "#contenuEtude" ).css({
					"height": tailleMatrice,
					"width":  tailleMatrice2
				});
				
				var stage = Konva.Node.create(monJason, 'matEncy');
				$( '.canvas' ).height(10);
				$( '.canvas' ).width(10);
				$( '.fond-blanc-ency' ).css('background-size', 'contain');

				$( ".fond_encyclopedie" ).show();

				
			});
			*/

			//Bouton de droite
			$("#arreter").on("click",function() {
				if(Tone.Transport.state == "started")
				{
					$("#ecouter").css( "background-image", "url(../images/but_etud_entendre.png)");
					patron.stop();
					Tone.Transport.stop();
				}
			});
			$("#retour").on("click",function() {
				javascript:window.location.href = "../index.php";;
			});
			$("#btn_ency").on("click",function() {
				$("#formInvisible").submit();
			});
			//Bouton du formulaire Hauteur
			$(".bouton_ok_hauteur").on("click",function() {
				
				$( ".fond_hauteur" ).hide();
				
				/*Attention à redonner la bonne taille à contenuEtude, ici*/
				$( "#zone"+idMatriceGlobal ).show();
				

				var valReg = $('input[name=registre]:checked', '#formHauteur').val();
				var valAmb = $('input[name=ambitus]:checked', '#formHauteur').val();
				var valCyc = $('input[name=cycle]:checked', '#formHauteur').val();
				
				
				arpege=[];
				for(i=0;i<tabJSNotes.length;i++)
				{
					arpege[i]=tabJSNotes[i].nommidi;
				}
				arpegeAscendant(arpege,memoRotation);
				console.log('RESET d arpege. Je copie à nouveau le contenu de tabJSNotes dans arpege : '+arpege); 

				// ATTENTION ici, on repart de l'arpege de tout début et non de celui qui s'affiche ----------------

				transpoOctave(valReg);

				arpege = choisiAmbitus(valAmb,arpege);

				console.log('arpege ambitus après transposition : '+arpege);
				
				patron.dispose();
				patron = creerPatron("",arpege,arpegeOriginal); 
				
				switch (valCyc) {
					case "d":
						patron.pattern = "down";
						break;
					case "a":
						patron.pattern = "up";
						break;
					case "da":
						patron.pattern = "downUp";
						break;
					case "ad":
						patron.pattern = "upDown";
						break;
					default:
						patron.pattern = "upDown";
				}
			});

			/* Créer l'interface NexusUI */
			
			var ctl_vol = new Nexus.Slider("#vol");
			ctl_vol.knob.setAttribute("fill", "#ff6f");
			ctl_vol.bar.setAttribute("fill", "#ff68");
			ctl_vol.fillbar.setAttribute("fill", "#ff6B");
			ctl_vol.mode = "absolute"; //Saute directement à la position cliquée

			var ctl_tempo = new Nexus.Slider("#tempo",{
				'size': [330,20],
				'min': 0,
				'max': 1,
				'step': 0,
				'value': 0,
				'x': 10,
				'y': 10
			 });
			//ctl_tempo.knob.className = "knob";
			ctl_tempo.knob.setAttribute("fill", "#ff6f");
			ctl_tempo.fillbar.setAttribute("fill", "#555a");
			ctl_tempo.mode = "absolute";

			/* Créer la source sonore */
			/*volume = new Tone.Volume(-Infinity).toMaster();
			Déplacé dans le script du haut*/


			/* Exemple : jouer un DO4 pendant la durée d'1/8 de note : monSynthetiser.triggerAttackRelease('C4', '8n') */
			var monSynthetiser = new Tone.FMSynth({
				"harmonicity": 8,
				"modulationIndex": 2,
				"oscillator": {
					"type": "sine"
				},
				"envelope": {
					"attack": 0.001,
					"decay": 2,
					"sustain": 0.1,
					"release": 2
				},
				"modulation": {
					"type": "square"
				},
				"modulationEnvelope": {
					"attack": 0.002,
					"decay": 0.2,
					"sustain": 0,
					"release": 0.2
				}
			});

			/*connect the UI with the components*/
			monSynthetiser.chain(volume, Tone.Master);


			/* Ecouter les événements de l'interface */
			
			$("#ecouter").on("click",function() {

				if(Tone.Transport.state == "started")
				{
					$("#ecouter").css( "background-image", "url(../images/but_etud_entendre.png)");
					patron.stop();
					Tone.Transport.stop();
				}
				else
				{
					
					patron.dispose();
					var sens;
					switch ($('input[name=cycle]:checked', '#formHauteur').val()) {
						case "d":
							sens = "down";
							break;
						case "a":
							sens = "up";
							break;
						case "da":
							sens = "downUp";
							break;
						case "ad":
							sens = "upDown";
							break;
						default:
						sens = "upDown";
					}
					patron = creerPatron(sens,arpege,arpegeOriginal);

					$("#ecouter").css( "background-image", "url(../images/but_etud_arreter.png)");
					/*Permet de lancer la fonction qui dessine 0.5 (unités ?) avant le temps, pour régler la latence avec 0.6, ça bugue*/
					Tone.Transport.lookAhead = 0;
					Tone.Transport.start();

					patron.interval = "4n"; //Vitesse de lecture arpèges
					patron.start();
				}

			});

			ctl_vol.on('change',function(v) {
				volume.volume.rampTo(v,.1)
			});
			ctl_vol.min = -20;
			ctl_vol.max = 40;
			ctl_vol.value = 0;

			ctl_tempo.on('change',function(v) {
				Tone.Transport.bpm.rampTo(v,1);
				document.getElementById("texte-tempo").innerHTML = Math.round(v);
			});
			ctl_tempo.min = 10;
			ctl_tempo.max = 240;
			ctl_tempo.value = 90;

		</script>

		<script src="../js/bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>		
	</body>
</html>