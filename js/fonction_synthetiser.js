function synthetiser()
{
	Nexus.context = Tone.context;
	
	Nexus.colors.accent = "#f00";
	Nexus.colors.fill = "#333";
	Nexus.colors.text = "#fff";

	idMatriceGlobal = tabJSMat[0].numMat; //Variable globale !

	/* Créer l'interface NexusUI */
	var ctl_ecouter = new Nexus.Toggle("#ecouter");
	var ctl_vol = new Nexus.Slider("#vol");

	/* Créer la source sonore */
	volume = new Tone.Volume(-Infinity).toMaster();


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

	monSynthetiser.chain(volume, Tone.Master);

	/* Ecouter les événements de l'interface */
	
	ctl_ecouter.on('change', v => v ? Tone.Transport.start() : Tone.Transport.stop());

	ctl_vol.on('change',function(v) {
		volume.volume.rampTo(v,.1)
	});

	ctl_vol.min = -20;
	ctl_vol.max = 20;
	ctl_vol.value = 0;

	return monSynthetiser;

}