<?php
    require_once('./app/PHPMailer/PHPMailerAutoload.php');
    require_once('./app/PHPMailer/class.smtp.php');
     
    $usuario =$_SESSION['user']->NOMBRE;
    $exec = $_SESSION['exec'];
    $titulo = $_SESSION['titulo'];
    $mensaje = "<p>";
    $contacto = "Ferretera Pegaso CxC";
    $folio = '';
    $HOY = date("Y-m-d");
    $correo = $_SESSION['correos'];
    $m='';
    if(strpos($correo, "@")>1){
        $val= 'ok';
    }
    if(strpos($correo, ",")>0){
        $m = 'S';
        $correo= explode(",", $correo);    
    }
    $total=0;
    $mensaje.= "<p>Estimado cliente le enviamos la relacion de facturas que estan pendientes de pago y la fecha de su vencimiento:.</p>";
    foreach ($exec as $data):
        if ($val=='ok'){
            $FACTURA= $data->CVE_DOC;
            $saldo = $data->SALDOFINAL;
            $importe = $data->IMPORTE;
            $clave = $data->CVE_CLPV;
            $total = $total + $saldo;
            $oc =$data->OC;
            $pp = $data->PEDIDO;
            $mensaje.= '<br/>Tipo de documento : Factura';
            $mensaje.= '<br/>Documento: <b>'.$data->CVE_DOC.'</b>';
            $mensaje.= '<br/>Orden de compra: <b>'.$oc.'</b>';
            $mensaje.= '<br/>Pedido Pegaso: <b>'.$pp.'</b>';
            $mensaje.= '<br/><font color="blue"><b>Cliente: ' . $data->NOMBRE.'( '.$clave.' )</b></font>';
            $mensaje.= '<br/><b>Importe: $ '.number_format($importe,2).'</b>'; 
            $mensaje.= '<br/><font color="red">Saldo: $ '.number_format($saldo,2).'</font>';
            $mensaje.= '<br/>Fecha Documento : ' . $data->FECHAELAB;
            $mensaje.= '<br/>Fecha Vencimiento : <b>' . $HOY.'</b>';
            $mensaje.= '<br/> ' . '</p>';
         }else{
            echo "No se ha localizado el correo electr&oacute;nico a quien enviar. No se va a enviar el correo.";
            return;
         }
    endforeach;
     $total = '$ '.number_format($total,2);
     $docs = count($exec);
     $asunto = "Relacion de Facturas pendientes de pago.";
     $mensaje.= "<p>Total de Documentos Vencidos:<b>$docs</b>.</p>";
     $mensaje.= "<p>Saldo Total vencido:<font color='red'><b> $total</b></font>.</p>";
     $mensaje.= "<p>Agradecemos su atencion.</p>";
     $mensaje.= "<p>Si usted piensa que es un error favor de verificarlo con el area de Cuentas x Cobrar con <b>$usuario</b><br/> al correo  o al telefono   <br/> <br/> Atentamente Cuentas Por Cobrar <br/><br/> </p>";
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
        if($m == 'S'){
            for ($i=0; $i < count($correo); $i++) { 
                $mail->AddAddress($correo[$i], '');
            }
        }else{
            $mail->AddAddress($correo, '');//Direccion a la que se envia
        }
         //$mail->AddAddress('genseg@hotmail.com', 'aperla@ferreterapegaso.com');
         $mail->SetFrom('info@ftcenlinea.com' , "Relacion de Facturas pendientes de Pago"); // Esccribe datos de contacto
         $mail->Subject = $asunto;
         $mail->AltBody = 'Para ver correctamente este mensaje, por favor usa un manejador de correo con compatibilidad HTML !'; // optional - MsgHTML will create an alternate automatically
         $mail->MsgHTML($mensaje);
         $mail->AddAttachment(realpath('C:\xampp\htdocs\EdoCtaCorreo\Relacion de Documentos '.date('d-m-Y').'.pdf'),'Relacion de Documentos '.date('d-m-Y').'.pdf','base64','application/pdf');
         $mail->Send();
     } catch (phpmailerException $e) {
        echo $e->errorMessage(); //Pretty error messages from PHPMailer
     } catch (Exception $e) {
        echo $e->getMessage(); //Boring error messages from anything else!
     }
 ?>
