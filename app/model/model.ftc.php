<?php

require_once 'app/model/ftc.php';
/* Clase para hacer uso de database */
class ftc extends ftcws {
    
    function valUsr($usr){
        $data=array();
        $this->query="SELECT * FROM ftc_usuarios where usuario = '$usr'";
        $res=$this->EjecutaQuerySimple();
        while ($tsArray= mysqli_fetch_array($res)){
            $data[]=$tsArray;
        }
        return $data;
    }

    function intUser($usuario, $contra, $email, $rol, $letra, $nomcom, $letras, $paterno, $materno){
        $c= md5($contra);
        $this->query="INSERT INTO ftc_usuarios (id, usuario, nombre, apellido_p, apellido_m, segundo_nombre, contrasenia, fecha_alta, status) values (null, '$usuario','$nomcom', '$paterno','$materno','','$c',current_timestamp, 'Activo')";
        $this->grabaBD();
        $ide = $_SESSION['empresa'][0];
        $idu = $_SESSION['user']->USER_LOGIN;
        $this->query="INSERT INTO ftc_empresas_usuarios (idu, ide, status, fecha_alta, usuario_alta) values ( (SELECT max(ID) FROM ftc_usuarios), $ide, 1, current_timestamp, (SELECT ID FROM ftc_usuarios WHERE usuario = '$idu'))";
        //echo $this->query;
        $this->grabaBD();
        return;
    }

    function loginMysql($user, $password){
        $data=array();
        $contra = $password;
        $this->query="SELECT * FROM ftc_usuarios where usuario = '$user' and contrasenia = '$contra' and status= 'Activo'";
        $res=$this->EjecutaQuerySimple();
        while ($tsArray=mysqli_fetch_array($res)){
            $data[]=$tsArray;
        }
        $ln = 0;
        $_SESSION['user']=$data;
        foreach ($data as $key) {
            $usuario = $key['usuario'];
            $ln++;
            $idu = $key['id'];
            $_SESSION['iduFTC']= $idu;
        }
        $equipo=php_uname();
        $ip= $_SERVER['REMOTE_ADDR'];
        $p=session_id();
        $pn=$_SERVER['HTTP_USER_AGENT'];
        if(isset($idu)){
            $empresas = $this->traeEmpresasUsuario($idu);
            $this->query="INSERT INTO FTC_LOGIN (id, USUARIO, IP, FECHA, EXITO, PHP_SESSION, CIERRE_SESSION,  EQUIPO, NAVEGADOR, SISTEMA) 
                                               VALUES (null, '$user', '$ip', current_timestamp, 'Si', '$p','No', '$equipo', '$pn', 'conta')";
            $this->EjecutaQuerySimple();
            return $empresas;    
        }else{
            $this->query="INSERT INTO FTC_LOGIN (USUARIO, IP, FECHA, EXITO, PHP_SESSION, CIERRE_SESSION, FECHA_CIERRE, EQUIPO, NAVEGADOR, SISTEMA) 
                                               VALUES ('$user', '$ip', current_timestamp, 'No', '$p','Si',current_timestamp, '$equipo', '$pn', 'conta')";
            $this->EjecutaQuerySimple();
            exit('No se encontro el usuario, favor de revisar la información');
        }
        return;
    }

    function traeEmpresasUsuario($idu){
        $data=array();
        $this->query="SELECT u.*, e.*, (SELECT concat(NOMBRE,' ', APELLIDO_P, ' ', APELLIDO_M)  FROM ftc_usuarios fu where fu.id = $idu) AS usuario 
            FROM ftc_empresas_usuarios u 
            left join ftc_empresas e on u.ide=e.ide  
            WHERE u.idu = $idu and u.status = 1 and e.fecha_baja is null";
        $res=$this->EjecutaQuerySimple();
        while ($tsArray=mysqli_fetch_array($res)) {
            $data[]=$tsArray;
        }
        return $data;
    }

    function traeEmpresas(){
        $this->query="SELECT * FROM ftc_empresas where fecha_baja is null";
        $res=$this->EjecutaQuerySimple();
        while ($tsArray = mysqli_fetch_array($res)){
            $data[]=$tsArray;
        }
    }

    function traeBD(){
        $empresa=$_SESSION['empresa'];
        $ide=explode(":", $empresa);
        $ide=$ide[0];
        $this->query="SELECT * FROM ftc_empresas where ide = $ide";
        $res=$this->EjecutaQuerySimple();
        while ($tsArray = mysqli_fetch_array($res)){
            $data=$tsArray;
        }
        $_SESSION['bd']=$data['ruta_bd'];
        $_SESSION['rfc']=$data['rfc'];
        $_SESSION['r_coi']=$data['ruta_coi'];
        $_SESSION['empresa']=$data;
        $_SESSION['servidor']=$data['servidor'];
        $_SESSION['db_new']=$data['db_new'];
        return $data['ruta_bd'];
    }

    function cambioSenia($nuevaSenia, $usuario){
        $nuevaSenia = md5($nuevaSenia);
        $data=array();
        $x = array("status"=>'s',"empresas"=>$data);
        $this->query="UPDATE ftc_usuarios SET contrasenia = '$nuevaSenia' where usuario = '$usuario'";
        $this->queryActualiza();
        $this->query="SELECT feu.*, (SELECT ruta_bd FROM ftc_empresas fe where feu.ide = fe.ide) as rutaBD FROM ftc_empresas_usuarios feu WHERE idu = (select id from ftc_usuarios where usuario='$usuario')";
        $res=$this->EjecutaQuerySimple();
        while($tsArray=mysqli_fetch_array($res)){
            $data[]=$tsArray;
        }
        if(count($data) > 1){
            /// si tiene mas de una empresa asignada, tenemos que cambiarle la contraseña a todas. 
            $x=array("status"=>'m',"empresas"=>$data);
        }
        return $x;
    }

    

}      
?>
