<?php
    require_once('./app/PHPMailer/PHPMailerAutoload.php');
    require_once('./app/PHPMailer/class.smtp.php');
     
     $exec = $_SESSION['exec'];
     $titulo = $_SESSION['titulo'];
     $mensaje = "<p>";
     $contacto = "";
     $folio = $_SESSION['folio'];
     $HOY = date("Y-m-d");
     foreach ($exec as $data):
 
        //$correo = $data->MAIL;
        $correo = 'genseg@hotmail.com';
         if (strpos($correo, "@")>1){
             $FACTURA = $data->FACTURA;
             $mensaje = 'Tipo de documento : DEVOLUCION DE MERCANCIA';
             $mensaje.= '<br/> No. de Devolucion: '.$folio;
             $mensaje.= '<br/> Documento : ' . $data->FACTURA;
             $mensaje.= '<br />Cliente : ' . $data->CLIENTE;
             $contacto = $data->VENDEDOR; 
             $mensaje.= '<br />Fecha documento : ' . $data->FECHA_FACTURA;
             $mensaje.= '<br />Fecha Devolucion : ' . $HOY;
             //$promesaPago = $data->PROMESA_PAGO;
             //$mensaje.= '<br />Fecha Promesa de pago : ' . $data->PROMESA_PAGO;
             $mensaje.= '<br /> ' . '</p>';
         } else {
             echo "No se ha localizado el correo electr&oacute;nico a quien enviar. No se va a enviar el correo.";
             return;
         }
     endforeach;
     $asunto = "Contrarecibo Ferretera Pegaso.";  
     $mensaje.= "<p>Le informamos que se ha recibido mercancia por devolucion de la factura $FACTURA.</p>";
     $mensaje.= "<p>Si usted piensa que es un error favor de verificarlo con el cliente<br/> <br/> <br/> Atentamente Bodega <br/><br/> Ferretera Pegaso</p>";
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
    
        $mail->SMTPSecure = 'tls';
        $mail->Host = 'tls://smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->Username   = "cxpferreterapegaso@gmail.com";  // Nombre del usuario SMTP
         $mail->Password   = "genseg89+";
         //$mail->AddAddress($correo, $contacto);      //Direccion a la que se envia
         $mail->AddAddress('genseg@hotmail.com');
         $mail->SetFrom('cxpferreterapegaso@gmail.com' , "Pegaso. Aviso de Devolucion"); // Esccribe datos de contacto
         $mail->Subject = $asunto;
         $mail->AltBody = 'Para ver correctamente este mensaje, por favor usa un manejador de correo con compatibilidad HTML !'; // optional - MsgHTML will create an alternate automatically
         $mail->MsgHTML($mensaje);
         $mail->AddAttachment(realpath('C:\xampp\htdocs\PegasoFTC\DEVOLUCION_.'.$folio.'.pdf'),'DEVOLUCION_'.$folio.'.pdf','base64','application/pdf');
         $mail->Send();
     } catch (phpmailerException $e) {
        echo $e->errorMessage(); //Pretty error messages from PHPMailer
     } catch (Exception $e) {
        echo $e->getMessage(); //Boring error messages from anything else!
     }
 ?>
