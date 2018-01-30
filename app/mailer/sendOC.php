<?php
    //require_once('app/mailer/class.phpmailer.php'); // Contiene las funciones para envio de correo
    //require_once('app/mailer/class.smtp.php'); // Envia correos mediante servidores SMTP
    require_once('./app/PHPMailer/PHPMailerAutoload.php');
    require_once('./app/PHPMailer/class.smtp.php');
     //$mail = new PHPMailer(); // Se crea una instancia de la clase phpmailer
     //$mail->IsSMTP(true); // Establece el tipo de mensaje html
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
             $mensaje.= '<br />Documento :'.$data->OC;
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
 
     $asunto = "Orden de Compra Ferretera Pegaso SA de CV.";  
     $mensaje.= "<p>Le informamos que hemos creado una orden de compra a nombre de $contacto con una fecha estimada de recepcion el $promesaPago.</p>";
     $mensaje.= "<p>Gracias por su apoyo.<br />Atentamente Ferretera Pegaso</p> <br/> En breve debera recibir una llamada de nuestro personal para confirmar esta Preorden.<br/>Si en un lapso maximo de 1 dia no recibe la llamada, le pedimos de favor que lo reporte a los telefonos 5220 9799 o a los correos: <font color='red'>elipegaso@hotmail.com, ferreterapegaso@hotmail.com</font>";
     
     try {
         
        /*$mail->Host       = "smtp.gmail.com";// Establece servidor SMTP
        $mail->SMTPDebug  = 0;                    // enables SMTP debug information (for testing)
        $mail->SMTPAuth   = true;                 // enable SMTP authentication
        $mail->SMTPSecure = "tls";                // sets the prefix to the servier
        $mail->Port       = 587;                  // Establece el puerto por defecto del servidor SMTP
        $mail->Username   = "cxpferreterapegaso@gmail.com";  // Nombre del usuario SMTP
        $mail->Password   = "genseg89+";          // Contraseña del servidor SMTP
//      $mail->AddReplyTo("prga0@tsmi.com.mx", ""); //Responder a
        //$mail->AddAddress($correo, $contacto); //Direccion a la que se envia
        //$mail->AddAddress('genseg@hotmail.com', $email);
        $mail->SetFrom('cxcferreterapegaso@gmail.com');

         $mail->Username   = "cxpferreterapegaso@gmail.com";  // Nombre del usuario SMTP
         $mail->Password   = "genseg89+";            // Contraseña del servidor SMTP*/
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
         $mail->Password   = "genseg89+";
        /*$mail->Username = "presupuestosrpluer@gmail.com"; // SMTP username
        $mail->Password = "rpluer1234"; // SMTP password*/
         $mail->AddAddress($correo, $correoUsuario, 'pegasocompras@gmail.com');      //Direccion a la que se envia
         $mail->SetFrom('cxpferreterapegaso@gmail.com' , "Pegaso. Cuentas por pagar"); // Esccribe datos de contacto
         $mail->Subject = 'Orden de compra Ferretera Pegaso SA de CV';
         $mail->AltBody = 'Para ver correctamente este mensaje, por favor usa un manejador de correo con compatibilidad HTML !'; // optional - MsgHTML will create an alternate automatically
         $mail->MsgHTML($mensaje); 
         $mail->AddAttachment(realpath('C:\xampp\htdocs\Ordenes\Orden de Compra Pegaso No.'.$data->OC.'.pdf'),'Orden de Compra Pegaso No.'.$data->OC.'.pdf','base64','application/pdf');
         $mail->Send();
         //die(var_dump($mail));
?>
        <script language = "javascript" type = "text/javascript">
            setTimeout("window.close();", 100);
        </script>
<?php 
     } catch (phpmailerException $e) {
        echo $e->errorMessage(); //Pretty error messages from PHPMailer
     } catch (Exception $e) {
        echo $e->getMessage(); //Boring error messages from anything else!
     }
 ?>