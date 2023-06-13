<?php // content="text/plain; charset=utf-8"
require_once ('../../../Classes/lib/jpgraph-4.2.9/src/jpgraph.php');
require_once ('../../../Classes/lib/jpgraph-4.2.9/src/jpgraph_line.php');
// Datos para la posición Y de la gráfica:
$ydata0 = array(0, 1100,300,800,1200,500,1025,972,135,57,700);
$ydata1 = array(0, 3000,170,60,225,1150,250,600,1100,2090,1700);
$ydata2 = array(0, 350,50,710,3050,560,2275,127,750,810,2520);
$ydata3 = array(0, 2400,210,1210,720,1050,3250,1900,600,970,3000);

// Size of the overall graph
$width=850;
$height=650;

// Create the graph and set a scale.
// These two calls are always required
$graph = new Graph($width,$height);
$graph->SetScale("textlin");
$graph->clearTheme();
$theme_class=new VividTheme;
$graph->SetTheme($theme_class);

$graph->img->SetMargin(110,90,60,60);

$graph->xaxis->SetFont(FF_ARIAL,FS_BOLD);
$graph->yaxis->SetFont(FF_ARIAL,FS_BOLD);
$graph->xaxis->title->Set("Mes fiscal");
$graph->yaxis->title->Set("Facturación");


$graph->title->Set("Ejemplo de gráfico multi linear");

// Create the linear plot
$lineplot_1=new LinePlot($ydata0);
$lineplot_1->SetColor("#6495ED");
$lineplot_1->SetLegend('Compras');

$lineplot_2=new LinePlot($ydata1);
$lineplot_2->SetColor("#00FF00");
$lineplot_2->SetLegend('Facturación');

$lineplot_3=new LinePlot($ydata2);
$lineplot_3->SetColor("#AA0000");
$lineplot_3->SetLegend('Gastos directos');

$lineplot_4=new LinePlot($ydata3);
$lineplot_4->SetColor("#0000AA");
$lineplot_4->SetLegend('Gastos indirectos');

// Add the plot to the graph
$graph->Add($lineplot_1);
$graph->Add($lineplot_2);
$graph->Add($lineplot_3);
$graph->Add($lineplot_4);

$graph->legend->SetFrameWeight(1);

// Display the graph
$graph->Stroke();
?>
