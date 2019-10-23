<?php

require '../Classes/pos/autoload.php';
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
/*
	Este ejemplo imprime un hola mundo en una impresora de tickets
	en Windows.
	La impresora debe estar instalada como genérica y debe estar
	compartida
*/
/*
	Conectamos con la impresora
*/
 
/*
	Aquí, en lugar de "POS-58" (que es el nombre de mi impresora)
	escribe el nombre de la tuya. Recuerda que debes compartirla
	desde el panel de control
*/
$nombre_impresora = "TM-T88V"; 
$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);
 
/*
	Imprimimos un mensaje. Podemos usar
	el salto de línea o llamar muchas
	veces a $printer->text()
*/
# Vamos a alinear al centro lo próximo que imprimamos
$printer->setJustification(Printer::JUSTIFY_CENTER);

$printer->text("Hola mundo\nParzibyte.me");
 
/*
	Hacemos que el papel salga. Es como 
	dejar muchos saltos de línea sin escribir nada
*/
$printer->feed();
 
/*
	Intentaremos cargar e imprimir
	el logo
*/
try{
	$logo = EscposImage::load("logo.png", false);
    $printer->bitImage($logo);
}catch(Exception $e){/*No hacemos nada si hay error*/}
 
/*
	Ahora vamos a imprimir un encabezado
*/
 
$printer->text("Yo voy en el encabezado" . "\n");
$printer->text("Otra linea" . "\n");
#La fecha también
$printer->text(date("Y-m-d H:i:s") . "\n");
 
 
/*Alinear a la izquierda para la cantidad y el nombre*/
$printer->setJustification(Printer::JUSTIFY_LEFT);

/*
	Ahora vamos a imprimir los
	productos
*/

/*Y a la derecha para el importe*/
$printer->setJustification(Printer::JUSTIFY_RIGHT);
 

/*
	Cortamos el papel. Si nuestra impresora
	no tiene soporte para ello, no generará
	ningún error
*/
$printer->cut();
 
/*
Por medio de la impresora mandamos un pulso.
	Esto es útil cuando la tenemos conectada
	por ejemplo a un cajón
*/
$printer->pulse();
 


/*
	Para imprimir realmente, tenemos que "cerrar"
	la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
*/

$printer->close();
