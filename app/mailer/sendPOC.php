<?php
   require_once('./app/PHPMailer/PHPMailerAutoload.php');
require_once('./app/PHPMailer/class.smtp.php');
    
     //$mail = new PHPMailer(true); // Se crea una instancia de la clase phpmailer
     //$mail->IsSMTP(); // Establece el tipo de mensaje html
     $email = $_SESSION['correos'];
     $exec = $_SESSION['exec'];
     $titulo = $_SESSION['titulo'];
     $mensaje = "<p>";
     $contacto = "";
     foreach ($exec as $data):
 
        $correo = $email;
         if (strpos($correo, "@")>1){
             $correoUsuario = $data->CORREOUSUARIO;
             $mensaje = 'Tipo de documento : PreOrden de Compra';
             $mensaje.= '<br />Documento :'.$idpoc;
             $mensaje.= '<br />Beneficiario :'.$data->NOMBRE;
             $contacto = '<br/> '.$data->NOMBRE; 
             $mensaje.= '<br />Fecha documento: '.$data->FECHA_ELAB;
             $mensaje.= '<br />Usuario para confirmacion Pegaso: '.$data->USUARIO;
             $promesaPago = $data->FECHA_DOC;
             $mensaje.= '<br />Monto : $ '.number_format($data->COSTO_TOTAL,2);
         } else {
             echo "No se ha localizado el correo electr&oacute;nico a quien enviar. No se va a enviar el correo.";
             return;
         }
     endforeach;
 
     $asunto = "Pre Orden de Compra Ferretera Pegaso.";  
     $mensaje.= "<p>Le informamos que hemos creado una preorden de compra a nombre de $contacto con una fecha estimada de recepcion el $promesaPago.</p>";
     $mensaje.= "<p>Gracias por su apoyo.<br />Atentamente Ferretera Pegaso</p> <br/> En breve debera recibir una llamada de nuestro personal para confirmar esta Preorden.<br/>Si en un lapso maximo de 1 dia no recibe la llamada, le pedimos de favor que lo reporte a los telefonos 5220 9799 o a los correos: <font color='red'>elipegaso@hotmail.com, ferreterapegaso@hotmail.com</font>";
     
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
        $mail->Username   = "cxpferreterapegaso@gmail.com";  // Nombre del usuario SMTP
         $mail->Password   = "genseg89+";          // Contraseña del servidor SMTP
         $mail->AddAddress($correo, $correoUsuario, 'pegasocompras@gmail.com');      //Direccion a la que se envia
         $mail->SetFrom('cxpferreterapegaso@gmail.com' , "Pegaso. Cuentas por pagar"); // Esccribe datos de contacto
         $mail->Subject = 'Pre orden de compra Ferretera Pegaso SA de CV';
         $mail->AltBody = 'Para ver correctamente este mensaje, por favor usa un manejador de correo con compatibilidad HTML !'; // optional - MsgHTML will create an alternate automatically
         $mail->MsgHTML($mensaje); 
         $mail->AddAttachment(realpath('C:\xampp\htdocs\Preordenes\Pre_Orden_de_Compra_Pegaso_No.'.$idpoc.'.pdf'),'Pre_Orden_de_Compra_Pegaso_No.'.$idpoc.'_.pdf','base64','application/pdf');
         $mail->Send();
?>
        <script language = "javascript" type = "text/javascript">
            <!--
            setTimeout("window.close();", 100);
            -->
        </script>
<?php 
     } catch (phpmailerException $e) {
        echo $e->errorMessage(); //Pretty error messages from PHPMailer
     } catch (Exception $e) {
        echo $e->getMessage(); //Boring error messages from anything else!
     }
 ?>