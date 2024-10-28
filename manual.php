<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>
<head>
	<title> f12 </title>
	<meta charset="UTF-8">
    <script src="js/konva.min.js"></script>
	    <style>
        body
        {
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #F0F0F0;
        }

    </style>
</head>
<body>
	<?php

		include_once('Matrice.php');
		include_once('Note.php');

		$maMat = new Matrice(
			600,
			"",
			"111011011010",
			"",
			null,
			null,
			null,
			null);
		$maMat->afficher();

		
	?>
</body>
</html>
