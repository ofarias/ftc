<?php
    require_once('./app/PHPMailer/PHPMailerAutoload.php');
require_once('./app/PHPMailer/class.smtp.php');
    
     //$mail = new PHPMailer(true); // Se crea una instancia de la clase phpmailer
     //$mail->IsSMTP(); // Establece el tipo de mensaje html
     $folio = $_SESSION['folio'];
     $titulo = $_SESSION['titulo'];
     $mensaje = "<p>";
     $contacto = "";

     //var_dump($folio);
     //break;
     foreach ($folio as $data):
        $tipo = 'Desconocido';

                if(!empty($data['STATUS1'])){
                    if($data['STATUS1'] == 5){
                        $tipo = 'Rechazado en la Operacion';
                    }elseif($data['STATUS1'] == 1){
                        $tipo = 'Creado';
                    }elseif ($data['STATUS1']==3){
                        $tipo = 'Cancelado por el usuario';
                    }elseif($data['STATUS1']== 6){
                        $tipo= 'Operado';
                    }elseif ($data['STATUS1'] == 8) {
                        $tipo = 'Rechazado en la operacion';
                }
            $correo = 'genseg@hotmail.com';
            if (strpos($correo, "@")>1){
                 $mensaje = 'Tipo de documento <b>: ' . $tipo.'<b/>';
                 $mensaje.= '<br />Documento : ' . $data['OC'];
                 $mensaje.= '<br />Beneficiario : ' . $data['PROVEEDOR'];
                 $contacto = $data['PROVEEDOR']; 
                 $mensaje.= '<br />Fecha de pago : ' . $data['FECHAPAGO'];
                 $mensaje.= '<br />No. Transferencia: BBVA'.$data['FOLIOBBVA'];
                 $mensaje.= '<br/> ';
                 $fechapago = $data['FECHAPAGO'];
                 //$mensaje.= '<br />Vencimiento : ' . $data->VENCIMIENTO;
                 //$promesaPago = $data->PROMESA_PAGO;
                 //$mensaje.= '<br />Fecha Promesa de pago : ' . $data->PROMESA_PAGO;
                 $mensaje.= '<br />Monto : ' . number_format($data['IMPORTE'], 2, '.', ',').'</p>';
                 $mensaje.= "<p>Le informamos que hemos realizado una transferencia electronica a nombre de $contacto el dia $fechapago.</p>";
                 $mensaje.= "<p>Gracias por su confianza<br />Atentamente </p>";
             } else {
                 echo "No se ha localizado el correo electr&oacute;nico a quien enviar. No se va a enviar el correo.";
                 return;
             }
        
                 $asunto = "Comprobante de Pago.";  
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
             $mail->AddAddress($correo);      //Direccion a la que se envia, separados por comas.
             $mail->SetFrom('info@ftcenlinea.com' , "Cuentas por pagar"); // Esccribe datos de contacto
             $mail->Subject = $asunto;
             $mail->AltBody = 'Para ver correctamente este mensaje, por favor usa un manejador de correo con compatibilidad HTML !'; // optional - MsgHTML will create an alternate automatically
             $mail->MsgHTML($mensaje);
             $mail->Send();
         } catch (phpmailerException $e) {
            echo $e->errorMessage(); //Pretty error messages from PHPMailer
         } catch (Exception $e) {
            echo $e->getMessage(); //Boring error messages from anything else!
         }

     }

    endforeach;
     
 ?>