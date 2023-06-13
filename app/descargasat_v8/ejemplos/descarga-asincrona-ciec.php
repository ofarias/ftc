<?php
// Des-comentar para mostrar errores
// error_reporting(1);
// ini_set('display_errors', 1);

require dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'DescargaMasivaCfdi.php';

// Obtener configuracion
$config = require 'config.php';

// Preparar variables
$ciecRfc = 'SAOA890320M87';
$ciecPwd = 'adrian89';
$rutaDescarga = $config['rutaDescarga'];
$maxDescargasSimultaneas = $config['maxDescargasSimultaneas'];

// Instanciar clase principal
$descargaCfdi = new DescargaMasivaCfdi();

// Preparar datos para busqueda de recibidos
$busqueda = new BusquedaRecibidos();
$busqueda->establecerFecha(2017, 10); // $anio, $mes, $dia=null
// $busqueda->establecerHoraInicial($hora=0, $minuto=0, $segundo=0);
// $busqueda->establecerHoraFinal($hora='23', $minuto='59', $segundo='59');
// $busqueda->establecerRfcEmisor($rfc);
// $busqueda->establecerEstado($estado); // Ejemplo: BusquedaRecibidos::ESTADO_VIGENTE
// $busqueda->establecerFolioFiscal($uuid);

// Preparar datos para busqueda de emitidos
// $busqueda = new BusquedaEmitidos();
// $busqueda->establecerFechaInicial(2017, 10, 1); // $anio, $mes, $dia
// $busqueda->establecerFechaFinal(2017, 10, 15); // $anio, $mes, $dia
// $busqueda->establecerHoraInicial($hora='0', $minuto='0', $segundo='0');
// $busqueda->establecerHoraFinal($hora='0', $minuto='0', $segundo='0');
// $busqueda->establecerRfcReceptor($rfc);
// $busqueda->establecerEstado($estado); // Ejemplo: BusquedaEmitidos::ESTADO_VIGENTE
// $busqueda->establecerFolioFiscal($uuid);

// Iniciar sesion en el SAT
$ok = $descargaCfdi->iniciarSesionCiec($ciecRfc, $ciecPwd);

// Si hay una sesion previa, se puede restaurar en lugar de iniciar sesión
// nuevamente con RFC y contraseña. Esto acelera el proceso.
// $ok = $descargaCfdi->restaurarSesion($sess);

if($ok){

    // Mostrar la sesion recien iniciada. Puede guardar este dato para restaurarlo
    // y utilizarlo en busquedas posteriores sin necesidad de volver a iniciar sesion.
    // var_dump($descargaCfdi->obtenerSesion()); // sesion como String

    // Obtener los datos de los CFDIs encontrados
    $xmlInfoArr = $descargaCfdi->buscar($busqueda);
    if($xmlInfoArr){

        // Preparar herramienta para descarga asincrona
        $descarga = new DescargaAsincrona($maxDescargasSimultaneas);

        // Recorrer array de resultados
        foreach ($xmlInfoArr as $xmlInfo) {

            // Mostrar datos del comprobante
            print_r($xmlInfo);

            // Agregar XML a la cola de descarga
            $descarga->agregarXml(
                $xmlInfo->urlDescargaXml,
                $rutaDescarga,
                $xmlInfo->folioFiscal
            );

            // Agregar Acuse a la cola de descarga (si aplica)
            if($xmlInfo->urlDescargaAcuse) {
                $descarga->agregarAcuse(
                    $xmlInfo->urlDescargaAcuse,
                    $rutaDescarga,
                    $xmlInfo->folioFiscal
                );
            }
        }

        // Iniciar proceso de descarga
        $descarga->procesar();

        // Mostra totales de la descarga
        $totalDescargados = $descarga->totalDescargados();
        $totalErrores = $descarga->totalErrores();
        $segundosTranscurridos = $descarga->segundosTranscurridos();
        echo "Descargados: $totalDescargados.\n";
        echo "Errores: $totalErrores.\n";
        echo "Duración: $segundosTranscurridos segundos.\n";

        // Mostrar detalle de la descarga
        print_r($descarga->resultado());
        echo "\n";

    }else{
        echo "No se han encontrado CFDIS.\n";
    }
}else{
    echo "Error al iniciar sesión en el SAT.\n";
}
