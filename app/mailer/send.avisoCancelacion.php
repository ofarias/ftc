<?php
    require_once('./app/PHPMailer/PHPMailerAutoload.php');
    require_once('./app/PHPMailer/class.smtp.php');
     
     $exec = $_SESSION['exec'];
     $titulo = $_SESSION['titulo'];
     $mensaje = "<p>";
     $contacto = "";
     $docf = $_SESSION['docf'];
     $usuario=$_SESSION['user']->NOMBRE;
     $HOY = date("d-m-Y H:i:s");
     $correo = $_SESSION['correo'];
     foreach ($exec as $data):
         if (strpos($correo, "@")>1){
             $FACTURA = $data->CVE_DOC;
             $mensaje = 'Tipo de documento :<font color="red"> Cancelacion de factura</font>';
             $mensaje.= '<br/> No. de Cancelacion: '.$docf;
             $mensaje.= '<br/> Documento Cancelado: ' . $data->CVE_DOC;
             $mensaje.= '<br />Cliente : ' . $data->NOMBRE;
             $contacto = $data->VENDEDOR; 
             $mensaje.= '<br />Fecha documento : ' . $data->FECHA_DOC;
             $mensaje.= '<br />Fecha Devolucion : ' . $HOY;
             //$promesaPago = $data->PROMESA_PAGO;
             //$mensaje.= '<br />Fecha Promesa de pago : ' . $data->PROMESA_PAGO;
             $mensaje.= '<br /> ' . '</p>';
         } else {
             echo "No se ha localizado el correo electr&oacute;nico a quien enviar. No se va a enviar el correo.";
             return;
         }
     endforeach;
     $asunto = "Cancelacion de Factura $docf .";  
     $mensaje.= "<p>Le informamos que se ha cancelado la factura $FACTURA.</p>";
     $mensaje.= "<p>Si usted piensa que es un error favor de verificarlo con el usuario $usuario <br/> <br/> <br/> Atentamente Cuentas x Cobrar <br/><br/> </p>";
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
         $mail->SetFrom('info@ftcenlinea.com' , "Aviso de Cancelacion de Factura".$docf); // Esccribe datos de contacto
         $mail->Subject = $asunto;
         $mail->AltBody = 'Para ver correctamente este mensaje, por favor usa un manejador de correo con compatibilidad HTML !'; // optional - MsgHTML will create an alternate automatically
         $mail->MsgHTML($mensaje);
         $mail->AddAttachment(realpath('C:\xampp\htdocs\PegasoFTC\DEVOLUCION_.'.$docf.'.pdf'),'DEVOLUCION_'.$docf.'.pdf','base64','application/pdf');
         $mail->Send();
     } catch (phpmailerException $e) {
        echo $e->errorMessage(); //Pretty error messages from PHPMailer
     } catch (Exception $e) {
        echo $e->getMessage(); //Boring error messages from anything else!
     }
 ?>
