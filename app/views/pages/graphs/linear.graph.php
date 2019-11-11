<?php // content="text/plain; charset=utf-8"
require_once ('../../../Classes/lib/jpgraph-4.2.9/src/jpgraph.php');
require_once ('../../../Classes/lib/jpgraph-4.2.9/src/jpgraph_line.php');

// Datos para la posición Y de la gráfica:
$ydata = array(0, 1100,300,800,1200,500,125,972,135,57,72);

// Size of the overall graph
$width=850;
$height=650;

// Create the graph and set a scale.
// These two calls are always required
$graph = new Graph($width,$height);
$graph->SetScale('intlin');
$graph->clearTheme();

$graph->img->SetMargin(90,90,60,60);

$graph->xaxis->SetFont(FF_VERDANA,FS_BOLD);
$graph->yaxis->SetFont(FF_VERDANA,FS_BOLD);
$graph->xaxis->title->Set("Años transcurridos");
$graph->yaxis->title->Set("Facturación");


$graph->title->Set("Ejemplo de gráfico linear");

// Create the linear plot
$lineplot=new LinePlot($ydata);

// Add the plot to the graph
$graph->Add($lineplot);

// Display the graph
$graph->Stroke();
?>
