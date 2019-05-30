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
        echo $this->query;
        $this->grabaBD();
        return;
    }

    function loginMysql($user, $password){
        $data=array();
        //$contra=md5($password);
        $contra = $password;
        $this->query="SELECT * FROM ftc_usuarios where usuario = '$user' and contrasenia = '$contra' and status= 'Activo'";
        $res=$this->EjecutaQuerySimple();
        while ($tsArray=mysqli_fetch_array($res)){
            $data[]=$tsArray;
        }
        $ln = 0;
        foreach ($data as $key) {
            $usuario = $key['usuario'];
            $ln++;
            $idu = $key['id'];
        }
        if(isset($idu)){
            $empresas = $this->traeEmpresasUsuario($idu);
            return $empresas;    
        }else{
            exit('No se encontro el usuario');
        }
        
    }

    function traeEmpresasUsuario($idu){
        $data=array();
        $this->query="SELECT u.*, e.*, (SELECT concat(NOMBRE,' ', APELLIDO_P, ' ', APELLIDO_M)  FROM ftc_usuarios fu where fu.id = $idu) AS usuario 
            FROM ftc_empresas_usuarios u 
            left join ftc_empresas e on u.ide=e.ide 
            WHERE u.idu = $idu and u.status = 1";
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
        return $data['ruta_bd'];
    }

    function cambioSenia($nuevaSenia, $usuario){
        $this->query="UPDATE ftc_usuarios SET contrasenia = '$nuevaSenia' where usuario = '$usuario'";
        $this->queryActualiza();
        return;
    }

}      
?>
