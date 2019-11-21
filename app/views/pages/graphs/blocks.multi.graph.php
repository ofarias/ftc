<?php // content="text/plain; charset=utf-8"
require_once ('../../../Classes/lib/jpgraph-4.2.9/src/jpgraph.php');
require_once ('../../../Classes/lib/jpgraph-4.2.9/src/jpgraph_bar.php');

$data1y=array(47,80,40,116);
$data2y=array(61,30,82,105);
$data3y=array(115,50,70,93);

// Create the graph. These two calls are always required
$graph = new Graph(850,650,'auto');
$graph->SetScale("textlin");

$graph->yaxis->SetTickPositions(array(0,30,60,90,120,150), array(15,45,75,105,135));
$graph->SetBox(false);

$graph->ygrid->SetFill(false);
$graph->xaxis->SetTickLabels(array('Bimestre 1','Bimestre 2','Bimestre 3','Bimestre 4'));
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

// Create the bar plots
$b1plot = new BarPlot($data1y);
$b2plot = new BarPlot($data2y);
$b3plot = new BarPlot($data3y);

// Create the grouped bar plot
$gbplot = new GroupBarPlot(array($b1plot,$b2plot,$b3plot));
// ...and add it to the graPH
$graph->Add($gbplot);


$b1plot->SetColor("white");
$b1plot->SetFillColor("#001111");

$b2plot->SetColor("white");
$b2plot->SetFillColor("#aacc00");

$b3plot->SetColor("white");
$b3plot->SetFillColor("#dddd00");

$graph->title->Set("Gastos ventas por bimestre");

// Display the graph
$graph->Stroke();
?>