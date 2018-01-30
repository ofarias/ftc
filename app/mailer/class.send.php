<?php
    require_once('class.phpmailer.php'); // Contiene las funciones para envio de correo
    require_once('class.smtp.php'); // Envia correos mediante servidores SMTP
    //$mail = new PHPMailer(true); // Se crea una instancia de la clase phpmailer
    //$mail->IsSMTP(); // Establece el tipo de mensaje html
	$asunto = "Contrarecibo Ferretera Pegaso.";
    $beneficiario ='Oscar Farias';
    $promesaPago = 'Hoy';
    $teste = $test;
    echo $teste;
    break; 
	$mensaje = "<p>Le informamos que hemos creado una cuenta por pagar a nombre de $beneficiario con una fecha estiamda de pago del $promesaPago.</p>";
	$mensaje.= "<p>Gracias por su confianza<br />Att Ferretera Pegaso</p>";
    try {
        /*$mail->Host       = "smtp.googlemail.com";// Establece servidor SMTP
        $mail->SMTPDebug  = 0;                    // enables SMTP debug information (for testing)
        $mail->SMTPAuth   = true;                 // enable SMTP authentication
        $mail->SMTPSecure = "tls";                // sets the prefix to the servier
        $mail->Port       = 587;                  // Establece el puerto por defecto del servidor SMTP
        $mail->Username   = "cxpferreterapegaso@gmail.com";  // Nombre del usuario SMTP
        $mail->Password   = "genseg89+";          // Contraseña del servidor SMTP
//        $mail->AddReplyTo("prga0@tsmi.com.mx", ""); //Responder a
        //$mail->AddAddress($correo, $contacto); //Direccion a la que se envia
        $mail->AddAddress('genseg@hotmail.com', 'ofarias0424@gmail.com');
        $mail->SetFrom('cxcferreterapegaso@gmail.com');
        //$mail->SetFrom('cxpferreterapegaso@gmail.com' , $pseudofrom); // Esccribe datos de contacto
        $mail->Subject = $asunto;
        $mail->AltBody = 'Para ver correctamente este mensaje, por favor usa un manejador de correo con compatibilidad HTML !'; // optional - MsgHTML will create an alternate automatically
        $mail->MsgHTML($mensaje);
        $mail->AddAttachment(realpath('./app/tmp/uploads/comprobantes_cajas/attachment.pdf'),'attachment.pdf','base64','application/pdf');
        $mail->Send();*/
        #####NUEVO####
        $mail = new PHPMailer();
        $mail->isSMTP(true);
        $mail->SMTPDebug = 3;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
                )
        );
        $mail->SMTPSecure = 'tls';
        $mail->Host = 'tls://smtp.gmail.com';
        $mail->
         $mail = new PHPMailer();
        $mail->isSMTP(true); // telling the class to use SMTP
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->SMTPSecure = 'tls';
        $mail->Host = 'tls://smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username   = "cxpferreterapegaso@gmail.com";  // Nombre del usuario SMTP
        $mail->Password   = "genseg89+"; 
        $mail->AddAddress('genseg@hotmail.com', 'ofarias0424@gmail.com');
        $mail->SetFrom('cxcferreterapegaso@gmail.com');
        $mail->Subject = $asunto;
        $mail->AltBody = 'Para ver correctamente este mensaje, por favor usa un manejador de correo con compatibilidad HTML !'; // optional - MsgHTML will create an alternate automatically
        $mail->MsgHTML($mensaje);
        //$mail->AddAttachment(realpath('./app/tmp/uploads/comprobantes_cajas/attachment.pdf'),'attachment.pdf','base64','application/pdf');

        $mail->Send();
?>
        <script language = "javascript" type = "text/javascript">
            <!--
            setTimeout("window.close();", 100);
            -->
        </script>
<?php
    }
    catch (phpmailerException $e) {
       echo $e->errorMessage(); //Pretty error messages from PHPMailer
    }
    catch (Exception $e) {
       echo $e->getMessage(); //Boring error messages from anything else!
    }
?>