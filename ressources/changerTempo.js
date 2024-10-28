var synth = new Tone.Synth();
synth.oscillator.type = 'sine';
synth.envelope.attack = 0.001;
synth.envelope.sustain = 0.5;

var gain  = new Tone.Gain(0.7);
synth.connect(gain);
gain.toMaster();

var isPlaying = false
var noteEl = document.getElementById('note')


var pattern = new Tone.Pattern((t,n) => {
  noteEl.innerHTML = n
	synth.triggerAttackRelease(n, "8n", t)
}, ["C4", "E4", "G4", "B4"], "upDown")


Tone.Transport.bpm.value = 200
pattern.start();


document.getElementById('play').addEventListener('click', () => {
  isPlaying = !isPlaying
  if(isPlaying) {
    Tone.Transport.start();
  } else {
    Tone.Transport.pause();
  }
})

document.getElementById('bpm').addEventListener('input', e => {
  Tone.Transport.bpm.value = +e.target.value
})