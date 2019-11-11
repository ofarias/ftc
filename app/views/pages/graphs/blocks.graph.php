<?php // content="text/plain; charset=utf-8"
require_once ('../../../Classes/lib/jpgraph/src/jpgraph.php');
require_once ('../../../Classes/lib/jpgraph/src/jpgraph_bar.php');

$datay=array(62,105,85,50);

// Create the graph. These two calls are always required
$graph = new Graph(850,650,'auto');
$graph->SetScale("textlin");

// set major and minor tick positions manually
$graph->yaxis->SetTickPositions(array(0,30,60,90,120,150), array(15,45,75,105,135));
$graph->SetBox(false);

//$graph->ygrid->SetColor('gray');
$graph->ygrid->SetFill(false);
$graph->xaxis->SetTickLabels(array('Q1','Q2','Q3','Q4'));
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

// Create the bar plots
$b1plot = new BarPlot($datay);

// ...and add it to the graPH
$graph->Add($b1plot);


$b1plot->SetColor("white");
$b1plot->SetFillGradient("#0A0F00","white",GRAD_LEFT_REFLECTION);
$b1plot->SetWidth(65);
$graph->title->Set("Facturación Trimestral (Left reflection)");

// Display the graph
$graph->Stroke();

?>