<?php
    require_once('./app/PHPMailer/PHPMailerAutoload.php');
    require_once('./app/PHPMailer/class.smtp.php');
     
     $titulo = $_SESSION['titulo'];
     $mensaje = "<p>";
     $contacto = "";
     $docf = $_SESSION['docf'];
     $usuario=$_SESSION['user']->NOMBRE;
     $HOY = date("d-m-Y H:i:s");
     $correo = $_SESSION['correo'];
     $respuesta=$_SESSION['user']->USER_EMAIL;
     $asunto = "Encontrar Caja de Factura $docf .";  
     $mensaje.= "<p>Solicitud para encontrar la caja de la siguiente factura $docf para refacturacion.</p>";
     $mensaje.= "<p>Favor de contestar al correo $respuesta , Usuario Solicita: $usuario </p>";
     $mensaje.= "<p><br/> Atentamente <br/> </p>";
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
        $mail->Username   = "info@ftcenlinea.com";  // Nombre del usuario SMTP
        $mail->Password   = "genseg89+";
         //$mail->AddAddress($correo, $contacto);      //Direccion a la que se envia
         $mail->AddAddress('genseg@hotmail.com');
         $mail->SetFrom('info@ftcenlinea.com' , "Encontrar Caja".$docf); // Esccribe datos de contacto
         $mail->Subject = $asunto;
         $mail->AltBody = 'Para ver correctamente este mensaje, por favor usa un manejador de correo con compatibilidad HTML !'; // optional - MsgHTML will create an alternate automatically
         $mail->MsgHTML($mensaje);
         //$mail->AddAttachment(realpath('C:\xampp\htdocs\PegasoFTC\DEVOLUCION_.'.$docf.'.pdf'),'DEVOLUCION_'.$docf.'.pdf','base64','application/pdf');
         $mail->Send();
     } catch (phpmailerException $e) {
        echo $e->errorMessage(); //Pretty error messages from PHPMailer
     } catch (Exception $e) {
        echo $e->getMessage(); //Boring error messages from anything else!
     }
 ?>
