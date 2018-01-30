<?php

class databasemysql {
    private $DBServer = "192.168.1.102";
    private $DBUser = "pegaso";
    private $DBPaswd = "genseg01+";
    private $DBName = "pegaso";
    private $cnx;
    protected $query;

    private function AbreCnx() {
        $this->cnx = mysqli_connect($this->DBServer, $this->DBUser, $this->DBPaswd);
        if (!$this->cnx) {
            die('no se pudo conectar 1' . mysqli_error());
        }
        $sdb = mysqli_select_db($this->cnx, $this->DBName);
        if (!$sdb) {
            die('no se pudo conectar 2 ' . mysqli_error($sdb));
        }
    }
    #Cierra la conexion a la base de datos
    private function CierraCnx() {
        mysqli_close($this->cnx);
    }
    #Ejecuta un query simple del tipo INSERT, DELETE, UPDATE
     function Create($query) {
        $this->AbreCnx();
        $resultado = mysqli_query($this->cnx, $query);
        return $resultado;
        $this->CierraCnx();
    }
    function Read($query) {
        $this->AbreCnx();
        $resultado = mysqli_query($this->cnx, $query);
        return $this->FetchArray($resultado);
        $this->CierraCnx();
    }
     function Update($query) {
        $this->AbreCnx();
        $resultado = mysqli_query($this->cnx, $query);
        $r = $this->NumRows($result);
        return $r;
        $this->CierraCnx();
    }
     function Delete($query) {
        $this->AbreCnx();
        $resultado = mysqli_query($this->cnx, $query);
        $r = $this->NumRows($result);
        return $r;
        $this->CierraCnx();
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