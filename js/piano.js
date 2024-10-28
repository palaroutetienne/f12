function piano()
{

	$("#conteneur_guitare").hide();
	$("#guitar").empty();
	$("#keyboard").load( "v_piano.html" );
  $("#conteneur_piano").show();

  console.log("visibilité conteneur_piano "+$("#conteneur_piano").is(":visible"));

  if(typeof guitaresynth !== "undefined"){
    guitaresynth.dispose();
  }
  /* Exemple : jouer un C4 pendant la durée d'1/8 de note : monSynthetiser.triggerAttackRelease('C4', '8n') */
  const synth = new Tone.FMSynth({
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

  synth.connect(volume);

  const piano = document.getElementById("keyboard");

  piano.addEventListener("mousedown", e => {
    synth.triggerAttack(e.target.dataset.note); /*Récupère la valeur de l'attribut data-note et la joue*/
  });
  piano.addEventListener("mouseup", e => {
    synth.triggerRelease();
  });

  /*La suite du code sert à jouer les notes en appuyant sur les lettres du clavier d'ordinateur */

  document.addEventListener("keydown", e => {
    switch (e.key) {
      case "d":
        return synth.triggerAttack("C4");
      case "r":
        return synth.triggerAttack("C#4");
      case "f":
        return synth.triggerAttack("D4");
      case "t":
        return synth.triggerAttack("D#4");
      case "g":
        return synth.triggerAttack("E4");
      case "h":
        return synth.triggerAttack("F4");
      case "u":
        return synth.triggerAttack("F#4");
      case "j":
        return synth.triggerAttack("G4");
      case "i":
        return synth.triggerAttack("G#4");
      case "k":
        return synth.triggerAttack("A4");
      case "o":
        return synth.triggerAttack("A#4");
      case "l":
        return synth.triggerAttack("B4");
      default:
        return;
    }
  });

  document.addEventListener("keyup", e => {
    switch (e.key) {
      case "d":
      case "r":
      case "f":
      case "t":
      case "g":
      case "h":
      case "u":
      case "j":
      case "i":
      case "k":
      case "o":
      case "l":
        synth.triggerRelease(); 
    }
  });
  //Rendre le piano interactif
  $( document ).ready(function() {
    couleur_octaves();
  });
}