<?php

	$midi = new Midi();

	/*
	$instruments = $midi->getInstrumentList();
	$drumset     = $midi->getDrumset();
	$drumkit     = $midi->getDrumkitList();
	$notes       = $midi->getNoteList();
	*/

	$save_dir = __DIR__.'MIDI/';
	srand((double)microtime()*1000000);
	$file = $save_dir.rand();

	//DEFAULTS
	$rep = 1; //repetitions
	$bpm = 90; //BPM

	$midi->open(480); //timebase=480, quarter note=120
	$midi->setBpm($bpm);
		
	//channel
	$ch = 1;

	//$inst = $_POST["inst$k"];
	$inst = 0;

	// pitch
	$pitches = array(50,60,70,60,70,60,70,40);

	// volume
	$v = 127;

	$ticksBetweenEvents = 480; // 120 = quarter note

	$t = 0;
	$ts = 0;
	$tn = $midi->newTrack() - 1;

	$midi->addMsg($tn, "0 PrCh ch=$ch p=$inst");
	foreach ($pitches as $n)
	{
		if ($ts == $t+$ticksBetweenEvents) $midi->addMsg($tn, "$ts Off ch=$ch n=$n v=127");
		$t = $ts;
		$midi->addMsg($tn, "$t On ch=$ch n=$n v=$v");
		$ts += $ticksBetweenEvents;
		if ($ts == $t+$ticksBetweenEvents) $midi->addMsg($tn, "$ts Off ch=$ch n=$n v=127");
	}
	$midi->addMsg($tn, "$ts Meta TrkEnd");

	$midi->saveMidFile($file.'.mid', 0666);
	system('/usr/bin/timidity -Ow --output-mono --verbose=-2 --output-file=- '.$file.'.mid | oggenc -q-1 -o '.$file.'.ogg -');
	//$midi->playMidFile($file,$visible,$autostart,$loop,$player);

?>