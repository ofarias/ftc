<?php // content="text/plain; charset=utf-8"
require_once ('../../../Classes/lib/jpgraph-4.2.9/src/jpgraph.php');
require_once ('../../../Classes/lib/jpgraph-4.2.9/src/jpgraph_pie.php');
require_once ('../../../Classes/lib/jpgraph-4.2.9/src/jpgraph_pie3d.php');

// Some data
$data = array(40,60,21,33);

// Create the Pie Graph. 
$graph = new PieGraph(850,650);

$theme_class= new VividTheme;
$graph->SetTheme($theme_class);

// Set A title for the plot
$graph->title->Set("Gráfica Pie 3D");

// Create
$p1 = new PiePlot3D($data);
$graph->Add($p1);

$p1->ShowBorder();
$p1->SetColor('black');
$p1->ExplodeSlice(1);
$p1->ExplodeSlice(2);

$p1->SetLegends(array("Q1", "Q2", "Q3", "Q4"));
$p1->SetSize(0.33);
$graph->Stroke();
?>