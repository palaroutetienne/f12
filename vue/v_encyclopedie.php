<script src="js/konva.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@magenta/music"></script>
<script src="js/jquery-3.3.1.min.js"></script>

<script src="js/fonction_traceLignes.js"></script>
<script src="js/fonction_designNotesEncyclopedie.js"></script>
<script src="js/fonction_reordonnernotesencyclopedie.js"></script>
<script src="js/fonction_reordEncyclopedie.js"></script>
<script src="js/fonction_chercheEnonceMatrice.js"></script>

<center>
	<div class="row">
		<div class="col-md-12 text-center texte-blanc">
			Encyclop&eacute;die --- Descriptif complet des caract&eacute;ristiques de la pr&eacute;sente matrice à l'étude.
		</div>
	</div>
	<div class="container fond-gris-bordure">

		<div class="row">
			<div class="col-md-12 text-center">

				<div class="titre">ENCYCLOPEDIE</div>

				<div class="col-md-12 text-center">
					Cliquez sur le nom des notes pour afficher la description correspondante.
				</div>

				<label class="texte-blanc" for="enonceSaisi">
					&nbsp;&nbsp;Matrice en cours d'&eacute;tude 
					<img src="images/fleches_blanches.png"/>&nbsp; 
					N°&nbsp;
				</label>

				<input type="text" class="form-control" readonly id="enonceSaisi" value=""/>
				&nbsp;&nbsp;de&nbsp;&nbsp;
				<input type="text" class="texte form-control" readonly id="nb_sons" value=""/>
				&nbsp;&nbsp;sons
				
			</div> <!-- fin col-md-12 -->
		</div> <!-- fin row -->
		<div class="row">
			<div class="col-md-6 text-center">
				Mode / Degr&eacute; s&eacute;lectionn&eacute; (&eacute;nonc&eacute; binaire)
			</div>
			<div class="col-md-6 text-center">
				<input type="text" class="form-control-spe" size="100" readonly id="enonce-binaire" value=""/>
			</div>
		</div>

		<div class="row" id="row-marge">
			<div class="col-md-6">
				<div id="contenuEtudeEncyclopedie">

					<!-- METTRE LA MATRICE ICI --------------------------------------------------------- -->
				
				</div>
			</div>
			<div id="fond-blanc" class="col-md-6">
				<div id="nomenclature" class="jumbotron texte-ency"> 

				
				</div> <!-- fin texte -->    
			</div> <!-- fin fond-blanc -->

		</div> <!-- fin row -->

		<div class="row">
			<div class="btn-group">
				<div class="row">
					<div class="col-md-6">
						<button class="btn bouton-image bouton_effacer" id="encyclopedie" name="encyclopedie" onclick="location.reload();"></button>
					</div>
					<div class="col-md-6">
						<form action='vue/v_etude.php' method='POST'>
							<button class="btn bouton-image bouton_retour" id="" name="" type="submit" value="" style="background-size: 20% !important;background-position : center right !important;"></button>
							<input id="enonce" name="enonce" type="hidden"/>
						</form>
					</div>	
				</div>
			</div>
		</div>
	</div> <!-- Fin container Fond gris -->

	</center>
	
	<?php

include_once('Matrice.php');
include_once('Note.php');
echo '

<script type="text/javascript">

$( document ).ready(function() {
	$("#list-exporter-list").on("click", function(){
		exportMIDI($("#enonceSaisi").val());
	});
});

window.onload
{
		var memoRotation;
		';
		include_once('vue/matricePHPEnJS.php');

		//Attention, laisser uniquement 'r' sans le b de binaire pour LINUX
		$fichierMatrices = fopen('ressources/listeMatrices4_2022_MusiEtGeo.csv','rb');
	
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
			$trouve=false;
			while(($donnee = fgetcsv($fichierMatrices, 1000, ",")) !== FALSE && $trouve == false)
			{	
				if(substr($donnee[3],0,3) == $_POST['enonceARecup'])
				{
					$trouve=true;

					//Création matrice la première ligne du fichier 
					//lu avec chaque champ de chaque ligne comme attribut
					$listeMatrices[$ligne] = new Matrice($donnee[0],$dimension/2,$donnee[1],$donnee[2],$donnee[3],$donnee[4],$donnee[5],$donnee[6],NULL,NULL,$donnee[7]);
					$listeMatrices[$ligne]->afficherEncyclopedie();

					echo '

					document.getElementById("nomenclature").innerHTML = "<p>'.$listeMatrices[$ligne]->getNomenclature().'</p><p class=texte-gris>'.$listeMatrices[$ligne]->getOrigine().'</p>";
					document.getElementById("enonce").value = "'.$_POST['enonceARecup'].'";
					document.getElementById("enonce-binaire").value = "'.$listeMatrices[$ligne]->getEnonce().'";
					document.getElementById("nb_sons").value = "'.$listeMatrices[$ligne]->getNbSons().'";
					document.getElementById("enonceSaisi").value = "'.$_POST['enonceARecup'].'";
					';
				}
				$ligne++;
			}

			if($trouve == false)
			{
				echo "Matrice non trouv&eacute;e";
			}

			echo '
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
			} /* Fin Window.onload( ) */
			</script>';

			fclose($fichierMatrices);
		}
		
	unset($$listeMatrices[$ligne]); //Détruire l'objet PHP inutile.
?>