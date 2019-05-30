<?php
    require_once('./app/PHPMailer/PHPMailerAutoload.php');
require_once('./app/PHPMailer/class.smtp.php');
    
     //$mail = new PHPMailer(true); // Se crea una instancia de la clase phpmailer
     //$mail->IsSMTP(); // Establece el tipo de mensaje html
 
     
     $exec = $_SESSION['exec'];
     $titulo = $_SESSION['titulo'];
     $mensaje = "<p>";
     $contacto = "";
     foreach ($exec as $data):
 
        $correo = $data->MAIL;
         if (strpos($correo, "@")>1){
             $mensaje = 'Tipo de documento : ' . $data->TIPO;
             $mensaje.= '<br />Documento : ' . $data->DOCUMENTO;
             $mensaje.= '<br />Beneficiario : ' . $data->BENEFICIARIO;
             $contacto = $data->BENEFICIARIO; 
            $mensaje.= '<br />Fecha documento : ' . $data->FECHA_DOC;
             $mensaje.= '<br />Vencimiento : ' . $data->VENCIMIENTO;
             $promesaPago = $data->PROMESA_PAGO;
             $mensaje.= '<br />Fecha Promesa de pago : ' . $data->PROMESA_PAGO;
             $mensaje.= '<br />Monto : ' . number_format($data->MONTO, 2, '.', ',').'</p>';
         } else {
             echo "No se ha localizado el correo electr&oacute;nico a quien enviar. No se va a enviar el correo.";
             return;
         }
     endforeach;
 
     $asunto = "Contrarecibo Ferretera Pegaso.";  
     $mensaje.= "<p>Le informamos que hemos creado una cuenta por pagar a nombre de $contacto con una fecha estiamda de pago del $promesaPago.</p>";
     $mensaje.= "<p>Gracias por su confianza<br />Atentamente Ferretera Pegaso</p>";
     
     try {
         
         $mail = new PHPMailer();
        $mail->isSMTP(true); // telling the class to use SMTP
        $mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
    /*    $mail->smtpConnect(
    array(
        "ssl" => array(
            "verify_peer" => false,
            "verify_peer_name" => false,
            "allow_self_signed" => true
        )
    )
);*/
        $mail->SMTPSecure = 'tls';
        $mail->Host = 'tls://smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username   = "info@ftcenlinea.com";  // Nombre del usuario SMTP
         $mail->Password   = "genseg89+";
         $mail->AddAddress($correo, $contacto);      //Direccion a la que se envia
         $mail->SetFrom('info@ftcenlinea.com' , "Pegaso. Cuentas por pagar"); // Esccribe datos de contacto
         $mail->Subject = $asunto;
         $mail->AltBody = 'Para ver correctamente este mensaje, por favor usa un manejador de correo con compatibilidad HTML !'; // optional - MsgHTML will create an alternate automatically
         $mail->MsgHTML($mensaje);
         $mail->Send();
     } catch (phpmailerException $e) {
        echo $e->errorMessage(); //Pretty error messages from PHPMailer
     } catch (Exception $e) {
        echo $e->getMessage(); //Boring error messages from anything else!
     }
 ?>