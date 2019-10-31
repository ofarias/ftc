<?php
    //require_once('app/mailer/class.phpmailer.php'); // Contiene las funciones para envio de correo
    //require_once('app/mailer/class.smtp.php'); // Envia correos mediante servidores SMTP
    require_once('./app/PHPMailer/PHPMailerAutoload.php');
    require_once('./app/PHPMailer/class.smtp.php');
    //$mail = new PHPMailer(); // Se crea una instancia de la clase phpmailer
    //$mail->IsSMTP(true); // Establece el tipo de mensaje html
    $correo = $_SESSION['user']->USER_EMAIL;
    $info = $_SESSION['info'];
    $mensaje='<p>Le informamos que se han detectado '.count($info).' Documentos Cancelados en el SAT.</p>';
    if(strpos($correo, "@")>1){
    } else {
        echo "No se ha localizado el correo electr&oacute;nico a quien enviar. No se va a enviar el correo.";
        return;
    }

    foreach ($info as $k){
        $mensaje.= "<p>UUID : <font color='blue'>".$k->UUID."</font> con fecha de Emision: <font color='blue'>".$k->FECHA_EMISION."</font> Fecha de Cancelacion :<font color='blue'>".$k->FECHA_CANCELACION."</font> del RFC Emisor <font color='blue'>".$k->RFCE." ".$k->NOMBRE_EMISOR."</font> y RFC Receptor <font color='blue'>".$k->RFCR." ".$k->NOMBRE_RECEPTOR."</font>  </p>";
        ///if($k->){  colocar la informacion de las polizas que ya se tengan registro en el COI
        ///    $mensaje.=""; 
        ///}
        //$mensaje.= "<p> Favor de revisar la informacion en el SAT</b></p>";
    }

    $asunto = "Reporte de Documentos Cancelados.";  
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
        $mail->SetFrom('facturacion@ftcenlinea.com' , "Deteccion de Cancelaciones sat2app"); // Esccribe datos de contacto
        $mail->Subject = 'sat2app le informa las cancelaciones'.date("d-m-Y");
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