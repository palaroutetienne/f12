<?php

class Note 			
{
	//Attributs

	private $xOrigine;			//Coordonnées du CENTRE du point de la note
	private $yOrigine;
	private $xOrigEtiq;			//Coordonnées du CENTRE de l etiquette de la note
	private $yOrigEtiq;
	private $tailleEtiq;		//Un étiquette à la même longueur et largeur. On garde la taille d un côté. 50 pour 1 canevas de 500
	private $taillePoint;
	private $etiquetteAbs; 		//Etiquette de la note avec #
	private $etiquetteBemol; 	//Etiquette de la note avec bémols
	private $nomMIDI; 			//Nom MIDI sur l'octave 4
	private $numOrdre; 
	private $etat; 
	private $angle;
	private $rayonMatrice;
	private $tailleCanevas;
	private $frequence;

	//Operations
	
	public function __construct($ordre,$x0,$y0,$r,$tailleCanevas)
		{

			$this->numOrdre = $ordre;
			
			//Définir nom de la note en fonction de la position du 1 dans l'énoncé
			switch($this->numOrdre)
			{
				case 0: $this->etiquetteAbs =  "Do";
						$this->etiquetteBemol = "Do";
						$this->nomMIDI = "C4";
						$this->angle = 0;
						$this->frequence = 262;
						break;
				case 1: $this->etiquetteAbs =  "Do#";
						$this->etiquetteBemol = "Réb";
						$this->nomMIDI = "C#4";
						$this->angle = pi()/6;
						$this->frequence = 277;
						break;
				case 2: $this->etiquetteAbs =  "Ré";
						$this->etiquetteBemol = "Ré";
						$this->nomMIDI = "D4";
						$this->angle = pi()/3;
						$this->frequence = 294;
						break;
				case 3: $this->etiquetteAbs =  "Ré#";
						$this->etiquetteBemol = "Mib";
						$this->nomMIDI = "D#4";
						$this->angle = pi()/2;
						$this->frequence = 311;
						break;
				case 4: $this->etiquetteAbs =  "Mi";
						$this->etiquetteBemol = "Mi";
						$this->nomMIDI = "E4";
						$this->angle = 2*pi()/3;
						$this->frequence = 330;
						break;
				case 5: $this->etiquetteAbs =  "Fa";
						$this->etiquetteBemol = "Fa";
						$this->nomMIDI = "F4";
						$this->angle = 5*pi()/6;
						$this->frequence = 349;
						break;
				case 6: $this->etiquetteAbs =  "Fa#";
						$this->etiquetteBemol = "Solb";
						$this->nomMIDI = "F#4";
						$this->angle = pi();
						$this->frequence = 370;
						break;
				case 7:$this->etiquetteAbs =  "Sol";
						$this->etiquetteBemol = "Sol";
						$this->nomMIDI = "G4";
						$this->angle = 7*pi()/6;
						$this->frequence = 392;
						break;
				case 8:$this->etiquetteAbs =  "Sol#";
						$this->etiquetteBemol = "Lab";
						$this->nomMIDI = "G#4";
						$this->angle = 4*pi()/3;
						$this->frequence = 415;
						break;
				case 9: $this->etiquetteAbs = "La";
						$this->etiquetteBemol = "La";
						$this->nomMIDI = "A4";
						$this->angle = 3*pi()/2;
						$this->frequence = 440;
						break;
				case 10: $this->etiquetteAbs =  "La#";
						$this->etiquetteBemol = "Sib";
						$this->nomMIDI = "A#4";
						$this->angle = 5*pi()/3;
						$this->frequence = 466;
						break;
				case 11: $this->etiquetteAbs =  "Si";
						$this->etiquetteBemol = "Si";
						$this->nomMIDI = "B4";
						$this->angle = 11*pi()/6;
						$this->frequence = 494;
						break;
			}
			
			$this->setTailles($tailleCanevas);				//Définir la taille des points en fonction de celle du canevas
			$this->setOrigine($x0,$y0,$r,$tailleCanevas);	//Trouver les coordonnées du centre pour le point + l étiquette
			$this->rayonMatrice = $r;
			$this->tailleCanevas = $tailleCanevas;
		}
 
	public function getXOrigine()
		{
			
			return $this->xOrigine;
		}
		
	public function getYOrigine()
		{
			
			return $this->yOrigine;
		}
		
	public function getXOrigEtiq()
		{
			
			return $this->xOrigEtiq;
		}
		
	public function getYOrigEtiq()
		{
			
			return $this->yOrigEtiq;
		}
		
	public function getTaillEtiq()
		{
			
			return $this->largeurEtiq;
		}
	public function getTaillePoint()
		{
			
			return $this->taillePoint;
		}
	
	public function getEtiquetteAbs()
		{
			
			return $this->etiquetteAbs;
		}	 
	public function getNomMIDI()
		{
		
		return $this->nomMIDI;
		}		
	public function getNumOrdre()
		{
			
			return $this->numOrdre;
		}
	public function getEtat()
		{
			
			return $this->etat;
		}
	public function getAngle()
		{
			
			return $this->angle;
		}
		
	public function getEtiquetteBemol()
		{
			
			return $this->etiquetteBemol;
		}

	public function getFrequence()
		{
			return $this->frequence;
		}
		
	public function setXOrigine($x = 0)
		{
			$this->xOrigine = $x;
		}
		
	public function setYOrigine($y = 0)
		{
			$this->yOrigine = $y;
		}

	public function setXOrigEtiq($x = 0)
		{	
			$this->xOrigEtiq = $x;
		}
		
	public function setYOrigEtiq($y = 0)
		{
			$this->yOrigEtiq = $y;
		}

	public function setEtiquetteAbs($EtiquetteAbs)
		{
			
			$this->etiquetteAbs = $EtiquetteAbs;
		}	 
	
	public function setNumOrdre($numOrdre)
		{
			
			$this->numOrdre = $numOrdre;
		}
	public function setEtat($etat)
		{
			
			$this->etat = $etat;
		}
	public function setNomMIDI($nomMIDI)
		{
			
			$this->nomMIDI = $nomMIDI;
		}
	public function setEtiquetteBemol($etiquetteBemol)
		{
			
			$this->etiquetteBemol = $etiquetteBemol;
		}

	public function setTailles($tailleCanevas)
	{//A revoir pour ne pas le faire pour tous les points d'une même matrice.**************************************************
	
		//Définir taille des points (8% de la taille du canevas)
		$this->taillePoint = $tailleCanevas*0.03;
		
		//Définir taille des étiquettes  (15% de la taille du canevas)
		$this->tailleEtiq = $tailleCanevas*0.06;
	}
		
	public function setOrigine($x0,$y0,$r,$tailleCanevas)
		{
			
			$this->setXOrigEtiq($x0 + $tailleCanevas/2 * 0.9 * cos($this->angle));
			$this->setYOrigEtiq($y0 + $tailleCanevas/2 * 0.9 * sin($this->angle));

			$this->setXOrigine($x0 + $r * cos($this->angle));
			$this->setYOrigine($y0 + $r * sin($this->angle));			
			
		}

	public function faireTournerNote($sens,$degres)
		{
			if($sens == "horaire")
			{
				$this->angle -= $degres * pi() / 180;
			}
			else
			{
                $this->angle += $degres * pi() / 180;
			}
		}
} // End Class Note

?>

