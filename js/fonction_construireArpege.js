function construireArpege(rotation,tabRotCoord)
{
	//Fonction pour construire l'arpège lu plus tard par le synthé
	var arpege=[];
	for(i=0;i<tabJSNotes.length;i++)
	{
		arpege[i]=tabJSNotes[i].nommidi;
	}

	return arpege;

}