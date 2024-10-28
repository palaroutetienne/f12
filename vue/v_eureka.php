<script src="js/konva.min.js"></script>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@magenta/music"></script>
<script src="js/fonction_traceLignes.js"></script>
<script src="js/fonction_designNotes.js"></script>
<script src="js/fonction_matriceEureka.js"></script>
<script src="js/fonction_surClicPoint.js"></script>
<script src="js/fonction_afficherMatriceEureka.js"></script>
<script src="js/fonction_chercheEnonceMatrice.js"></script>
<script src="js/fonction_chercheNomenclatureEureka.js"></script>
<center>
	
	<div class="container-fluid fond-gris">
		<div class="row">
			<div class="col-md-12 text-center">
				Dessinez le quadrant de la Matrice que vous souhaitez étudier en cliquant successivement sur les points / notes du cercle.
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 text-center">

				<label class="texte-blanc" for="enonceSaisi">EUREKA&nbsp;&nbsp; 
					<sup>.</sup>
					&nbsp;&nbsp;Matrice propos&eacute;e&nbsp; 
					<img src="images/fleches_blanches.png"/>&nbsp; 
					N°&nbsp;
				</label>
				<input type="text" class="form-control" id="enonceSaisi" value=""/>
					&nbsp;&nbsp;de&nbsp;&nbsp;<input type="text" class="texte form-control" id="nb_sons" value="07"/>&nbsp;&nbsp;sons

			</div> <!-- fin col-md-12 -->
		</div> <!-- fin row -->

		<div class="row no-gutters">
		
			<div id="contenuEtude" class="col-md-5">

				<!-- METTRE LA MATRICE ICI --------------------------------------------------------- -->
			
			</div>
			
			<div class="col-md-7" id="fond-blanc" >
				<div id="nomenclature" class="jumbotron texte-ency"> 

				
				</div> <!-- fin texte -->    
			</div> <!-- fin fond-blanc -->

		</div> <!-- fin row -->

		<div class="row align-items-bottom">
			<div class="btn-group">
					<!-- Ici, l'énoncé est un num matrice, plutôt -->
					<div class="col-md-5">
						<form action='vue/v_etude.php' method='POST'>
							<button class="btn bouton-image bouton_etudier"></button>
							<input id="enonce" name="enonce" type="hidden"/>
						</form>
					</div>
					<div class="col-md-5">
						<form action='index.php' method='POST'>
							<button class="btn bouton-image bouton_effacer" id="eureka" name="eureka" type="submit" value="v_eureka"></button>
						</form>
					</div>
					<div class="col-md-2 my-auto">
						<form id="form-retour" action='index.php' method='POST'>
							<img id="bouton_retour" src="images/but_retour.png" onclick="document.getElementById('form-retour').submit()"/>
						</form>
					</div>	
			</div>
		</div>
	</div>

	</center>
	<?php

	echo'
	<script type="text/javascript">
	
	$( document ).ready(function() {
		$("#list-exporter-list").on("click", function(){
			exportMIDI($("#enonceSaisi").val());
		});
	});

	window.onload
	{

		var tabJSNotes = [];
		var rotation=360;
		var ladiv = document.getElementById("contenuEtude");
		ladiv.height = 480; //ladiv est plus grande 
		ladiv.width = 480;
	';
		include_once('Matrice.php');
		include_once('Note.php');
		//En PHP, on crée un tableau JS à partir du fichier matrices.
		include_once('vue/matricePHPEnJS.php');
		$mamatrice = new Matrice("0",400,"0","000000000000","000","Silence","élément esthétique indispensable !","— —",NULL,NULL,"#808080");
		echo 
		'var r = '.$mamatrice->getRayon().';
		var r2 = r*1.2;';

		$mamatrice->extracNotesEnonce();

		//On écrit les infos de la matrice de départ.
		echo 
		'

		var zoneDessin = new Konva.Stage({
			container: ladiv, //Pour mettre le canevas dans la div qu on lui a réservée
			height: '.$mamatrice->getTaille().'*1.2,
			width: '.$mamatrice->getTaille().'*1.2
		});
		
		
		//Création tableau JS pour stocker l objet JS Matrice
		var tabJSMat = []; 
		/*Mémoriser les infos sur la matrice active*/

		tabJSMat.push({
			nomStage: "zoneDessin",
			enonce:"'.$mamatrice->getEnonce().'",
			x:'.$mamatrice->getXOrigine().',
			y:'.$mamatrice->getYOrigine().',
			rayon: '.$mamatrice->getRayon().',
			numMat:'.$mamatrice->getId().',
			couleur:"'.$mamatrice->getCouleur().'",
			bicolore:'.(($mamatrice->getBicolore()==0)?"false":"true").',
			rang:'.$mamatrice->getRang().'
			});

		matriceEureka(r,r2,zoneDessin,ladiv,tabJSMat,tabToutesLesMatrices);	

		document.getElementById("nomenclature").innerHTML = "<p>'.$mamatrice->getNomenclature().'</p><p class=texte-gris>'.$mamatrice->getOrigine().'</p>";
		document.getElementById("enonce").value = "'.$mamatrice->getId().'";
		document.getElementById("nb_sons").value = "0";
		document.getElementById("enonceSaisi").value = "'.$mamatrice->getRang().'";

		function exportMIDI(rang)
				{
					var enonce = chercheEnonceMatrice(rang,tabToutesLesMatrices);
					var freqChqNote = [];
					var freq = 60;
					for(var e=0;e<12;e++)
					{
						freqChqNote[e] = freq;
						freq++;
					}
					var notesEnonce = [];
					var duree = -0.5;
					for(e=0;e<enonce.length;e++)
					{
						if(enonce[e]=="1")
						{
							duree=duree+0.5;
							notesEnonce.push({
								pitch: freqChqNote[e],
								startTime: duree,
								endTime: (duree+0.5),
								velocity: 100});
						}
					}
					console.log("notesEnonce "+notesEnonce);
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

	}
	</script>';
	unset($mamatrice); //Détruire l'objet PHP inutile.
?>