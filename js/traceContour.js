function traceContour(tabJSNotes,stage)
{
    var calqueLignes = new Konva.Layer();

    for(indice=0;indice<tabJSNotes.length-1;indice++)
    {
        var redLine = new Konva.Line
        ({
            points: [tabJSNotes[indice].x, tabJSNotes[indice].y,tabJSNotes[indice+1].x,tabJSNotes[indice+1].y],
            stroke: 'red',
            strokeWidth: 10
        });
        calqueLignes.add(redLine);
        stage.add(calqueLignes);
        stage.draw();

    }
    var redLine = new Konva.Line
        ({
            points: [tabJSNotes[tabJSNotes.length-1].x, tabJSNotes[tabJSNotes.length-1].y,tabJSNotes[0].x,tabJSNotes[0].y],
            stroke: 'red',
            strokeWidth: 10
        });
        calqueLignes.add(redLine);
        stage.add(calqueLignes);
        stage.draw();
}