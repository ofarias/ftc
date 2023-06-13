<?php // content="text/plain; charset=utf-8"
require_once ('../../../Classes/lib/jpgraph-4.2.9/src/jpgraph.php');
require_once ('../../../Classes/lib/jpgraph-4.2.9/src/jpgraph_pie.php');
// Some data
$data = array(40,21,17,14,23);

// Create the Pie Graph. 
$graph = new PieGraph(650,350);

// Set A title for the plot
$graph->title->Set("Gráfico de Pie");
$graph->SetBox(true);

// Create
$p1 = new PiePlot($data);
$graph->Add($p1);

$p1->ShowBorder();
$p1->SetColor('black');
$p1->SetSliceColors(array('#1E90FF','#2E8B57','#ADFF2F','#DC143C','#BA55D3'));
$graph->Stroke();
?>