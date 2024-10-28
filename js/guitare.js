
/* Exemple : jouer un C4 pendant la durée d'1/8 de note : monsynthguitareetiser.triggerAttackRelease('C4', '8n') */
function guitare()
{

	$("#conteneur_piano").hide();
	$("#keyboard").empty();
	$("#guitar").load( "v_guitare.html" );
	$("#conteneur_guitare").show();

	if(typeof synth !== "undefined"){
		synth.dispose();
	}
	const synthguitare = new Tone.FMSynth({
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

	synthguitare.connect(volume);

	$("#guitar").on("mousedown",function() {
		synthguitare.triggerAttack(e.target.dataset.note); /*Récupère la valeur de l'attribut data-note et la joue*/
	});
	$("#guitar").on("mouseup",function() {
		synthguitare.triggerRelease();
	});

	//Rendre guitare interactive
	$( document ).ready(function() {
		couleur_octaves();
	});
}
