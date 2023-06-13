<?php
    //require_once('app/mailer/class.phpmailer.php'); // Contiene las funciones para envio de correo
    //require_once('app/mailer/class.smtp.php'); // Envia correos mediante servidores SMTP
    require_once('./app/PHPMailer/PHPMailerAutoload.php');
    require_once('./app/PHPMailer/class.smtp.php');
    //$mail = new PHPMailer(); // Se crea una instancia de la clase phpmailer
    //$mail->IsSMTP(true); // Establece el tipo de mensaje html
    $correo = $_SESSION['user']->USER_EMAIL;
    $info = $_SESSION['info'];
    $mensaje='<p>Se han realizado '.count($info).' poliza(s) automaticamente.</p>';
    if(strpos($correo, "@")>1){
    } else {
        echo "No se ha localizado el correo electr&oacute;nico a quien enviar. No se va a enviar el correo.";
        return;
    }


    foreach ($info as $k){
        $mensaje.= "<p>UUID origen: <font color='blue'>".$k['uuid']."</font> con fecha del: <font color='blue'>".$k['fecha']."</font> </p>";
        $mensaje.= "<p>".$k['info']['mensaje']." <b>".$k['info']['poliza']."</b> del periodo <b>".$k['info']['periodo']."</b> del ejercicio <b>".$k['info']['ejercicio']."</b> RFC: <b>".$k['rfc']."</b> del <b>".$k['tipo'].": ".$k['nombre']."</b></p>";
    }

    $asunto = "Reporte de polizas automaticas.";  
    $mensaje.= "<p>Gracias por su apoyo.<br />Atentamente </p> Equipo sat2app.mx <br/> <br/>Si usted no es el interesado de este correo le pedimos de favor que lo borre inmediatamente.
     <font color='red'>".$correo."</font>";
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
        $mail->Username   = "facturacion@ftcenlinea.com";  // Nombre del usuario SMTP
        $mail->Password   = "elPaso35+";
        if(strpos($correo,",")>0){
            $co=explode(",", $correo);
            for($i=0; $i<count($co);$i++){
                $mail->AddAddress($co[$i]);//Direccion a la que se envia
            }
        }else{
                $mail->AddAddress($correo);//Direccion a la que se envia
        }
        $mail->SetFrom('facturacion@ftcenlinea.com' , "Polizas Automaticas sat2app"); // Esccribe datos de contacto
        $mail->Subject = 'Emision de polizas automaticas sat2app '.date("d-m-Y");
        $mail->AltBody = 'Para ver correctamente este mensaje, por favor usa un manejador de correo con compatibilidad HTML !'; // optional - MsgHTML will create an alternate automatically
        $mail->MsgHTML($mensaje); 
        //$mail->AddAttachment(realpath('C:\\xampp\\htdocs\\Facturas\\facturaPegaso\\'.$docf.'.pdf'),$docf.'.pdf','base64','application/pdf');
        //$mail->AddAttachment(realpath('C:\\xampp\\htdocs\\Facturas\\facturaPegaso\\'.$docf.'.xml'),$docf.'.xml');
        $mail->Send();
        //die(var_dump($mail));
        return;
?>

<?php 
     } catch (phpmailerException $e) {
        echo $e->errorMessage(); //Pretty error messages from PHPMailer
     } catch (Exception $e) {
        echo $e->getMessage(); //Boring error messages from anything else!
     }
 ?>