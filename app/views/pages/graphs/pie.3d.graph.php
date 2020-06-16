<?php // content="text/plain; charset=utf-8"
require_once ('../../../Classes/lib/jpgraph/jpgraph.php');
require_once ('../../../Classes/lib/jpgraph/jpgraph_pie.php');
require_once ('../../../Classes/lib/jpgraph/jpgraph_pie3d.php');

$datos = $_GET['datos'];
$anio =$_GET['anio'];
//echo $datos;
$datos = explode("|", str_replace('"', "",$datos));
$x = array(); // Clientes;
$y = array(); //
$t = array(); // Montos;
foreach ($datos as $key => $value){
	$a = explode(":",$value);
	array_push($t, $a[1]);
	array_push($x, $a[0]);
	//echo 'Cliente: '.$a[0].' valor:'.$a[1].'<br/>';
}
//print_r($t);
//die;
// Some data
//$data = array(10,25,25,25,25,10); /// Calcula el promedio.
$data = $t; /// Calcula el promedio.
// Create the Pie Graph. 
$graph = new PieGraph(1150,650);
$theme_class= new VividTheme;
$graph->SetTheme($theme_class);
// Set A title for the plot
$graph->title->Set("Facturas del ejercicio ".$anio);
// Create
$p1 = new PiePlot3D($data);
$graph->Add($p1);
$p1->ShowBorder();
$p1->SetColor('black');
$p1->ExplodeSlice(1);
$p1->ExplodeSlice(2);

//$p1->SetLegends(array("Q1", "Q2", "Q3", "Q4", "Q5", "Q6"));
$p1->SetLegends($x);
$p1->SetSize(0.33);
//die;
$graph->Stroke();
?>