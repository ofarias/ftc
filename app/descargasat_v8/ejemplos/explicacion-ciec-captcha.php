<?php

/*
* Explicación breve sobre el funcionamiento
* del inicio de sesión con CIEC/Captcha.
*/
// Instanciar librería
require dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'DescargaMasivaCfdi.php';
$descargaCfdi = new DescargaMasivaCfdi();
// PASO 1
// a) Obtener datos del captcha que se mostrará al usuario
$imagenBase64 = $descargaCfdi->obtenerCaptcha();
// b) Obtener sesión actual.
//    Es necesario guardarla de alguna forma (ej. base de datos,
//    sesión PHP, enviar/recibir en formulario, etc.)
//    para continuar el proceso más adelante.
$sesionStr = $descargaCfdi->obtenerSesion();
// c) Mostrar imagen al usuario
$imgStr = '<img src="data:image/jpeg;base64,'.$imagenBase64.'" />';
// PASO 2
// a) Recuperar RFC, contraseña y captcha introducidos por el usuario
$rfcStr = $_POST['rfc']; // ejemplo
$contrasenaStr = $_POST['contrasena']; // ejemplo
$captchaStr = $_POST['captcha']; // ejemplo
// b) Restaurar sesión guardada previamente
$descargaCfdi->restaurarSesion($sesionStr);
// c) Iniciar sesión en el SAT
$inicioSesionOk = $descargaCfdi->iniciarSesionCiecCaptcha(
    $rfcStr, $contrasenaStr, $captchaStr
);
// PASO 3

// Continuar con la búsqueda y descarga de forma normal.

