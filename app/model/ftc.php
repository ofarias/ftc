<?php

class ftcws {
    private $DBServer="ofa.dyndns.org:3306";
    private $DBUser="ftc";
    private $DBPaswd="elPaso01+";
    private $DBName="ftc_ws";
    private $cnx;
    protected $query;
    private function AbreCnx() {
        $this->cnx = mysqli_connect($this->DBServer, $this->DBUser, $this->DBPaswd);
        //$this->cnx = mysqli_connect('192.168.100.33:3308', 'ftc3', 'elPaso01+');
        if (!$this->cnx) {
            die('no se pudo conectar 1 al host: '.$DBServer.' con el usuario: '.$DBUser.''. mysqli_error());
        }
        $sdb = mysqli_select_db($this->cnx, $this->DBName);
        if (!$sdb) {
            die('no se pudo conectar 2 ' . mysqli_error($sdb));
        }
    }
    private function CierraCnx() {
        mysqli_close($this->cnx);
    }
    #Ejecuta un query simple del tipo INSERT
     function grabaBD() {
        $this->AbreCnx();
        $res = mysqli_query($this->cnx, $this->query);
        return $res;
        $this->CierraCnx();
    }
    #Ejecuta un query de tipo Select 
    function EjecutaQuerySimple() {
        $this->AbreCnx();
        $resultado = mysqli_query($this->cnx, $this->query) or die ("Algo salio mal...");
        return $resultado;
        unset($this->query);
        $this->CierraCnx();
    }

    #Ejecuta un query simple del tipo Actualiza
    function queryActualiza() {
        $this->AbreCnx();
        $result = mysqli_query($this->cnx, $this->query) or die ("La actualizacion no se logro, favor de revisar la informacion...");
        $rows=mysqli_affected_rows($this->cnx);
        unset($this->query);
        $this->CierraCnx();
        return $rows;
    }
    #Ejecuta un query simple del tipo Delete
    function queryBorrar() {
        $this->AbreCnx();
        $resultado = mysqli_query($this->cnx, $this->query);
        $rows=mysqli_affected_rows($this->cnx);
        unset($this->query);
        $this->CierraCnx();
        return $r;
    }

    #Obtiene la cantidad de filas afectadas en BD
    function NumRows($result) {
        return mysqli_num_rows($result);
    }
    #Regresa arreglo de datos asociativo
    function FetchArray($result) {
        return mysqli_fetch_array($result);
    }
}