<?php
    require_once('./app/PHPMailer/PHPMailerAutoload.php');
    require_once('./app/PHPMailer/class.smtp.php');
     
     $titulo = 'Ticket de Servicio FTC';
     $mensaje = "<p>";
     $contacto = "";
     $info = $_SESSION['info'];
     $HOY = date("d-m-Y H:i:s");
     $correo_tecnico = $info->CORREO_TEC;
     $correo_usuario = $info->CORREO_USU;
     $correo_rep = $info->CORREO_REP;
     $respuesta=$_SESSION['user']->USER_EMAIL;
     $asunto = "Registro de ticket de servicio ".$info->ID.'';  
     $mensaje.= "<p>Solicitud se servicio.</p>";
     $mensaje.= "<p>Se registro una ".$info->TIPO." el dia ".$info->FECHA_REPORTE." </p>";
     $mensaje.= "<p>Por el usuario: <font color='blue'>".$info->REPORTA."</font> </p>";
     $mensaje.= "<p>Para el equipo: ".$info->EQUIPO." </p>";
     $mensaje.= "<p>Del usuario: ".$info->USUARIO." </p>";
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
        $mail->Username   = "soporte@ftcenlinea.com";  // Nombre del usuario SMTP
        $mail->Password   = "genseg2020+";
        $mail->AddAddress($correo_tecnico);
        //!empty($correo_usuario)?  $mail->AddAddress($correo_usuario):'';
        //if(!empty($correo_usuario)){
        //    $correo_rep == $correo_usuario?   '':$mail->AddAddress($correo_usuario);
        //} 
        
        $mail->SetFrom('info@ftcenlinea.com' , "Ticket No.".$info->ID); // Esccribe datos de contacto
        $mail->Subject = $asunto;
        $mail->AltBody = 'Para ver correctamente este mensaje, por favor usa un manejador de correo con compatibilidad HTML !'; 
        $mail->MsgHTML($mensaje);
        $mail->Send();
     } catch (phpmailerException $e) {
        echo $e->errorMessage(); //Pretty error messages from PHPMailer
     } catch (Exception $e) {
        echo $e->getMessage(); //Boring error messages from anything else!
     }
 ?>
