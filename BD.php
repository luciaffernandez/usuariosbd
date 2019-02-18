<?php

class BD {

    private $conexion;
    private $host;
    private $user;
    private $pass;
    private $bd;

    public function __construct($host = "172.17.0.2", $user = "root", $pass = "root", $bd = "dwes") {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->bd = $bd;
        $this->conexion = $this->conectar();
    }

    /**
     * @return \mysqli
     */
    private function conectar(): mysqli{
        $conexion = new mysqli($this->host, $this->user, $this->pass, $this->bd);
        if($conexion->connect_errno){
            $this->error = "Error conectando...<strong>" . $conexion->connect_error . "</strong>";
        }
        return $conexion; 
    }

    public function select(string $consulta) {
        $filas = [];
        if ($this->conexion == null) {
            $this->conexion = $this->conexion();
        }
        $resultado = $this->conexion->query($consulta);
        while ($fila = $resultado->fetch_row()) {//mientras fila sea distinto de null cogemos el siguiente valor
            $filas[] = $fila;
        }
        return $filas;
    }
    public function cerrar(){
        $this->conexion->close();
    }
    
    /**
     * 
     * @param string $tabla es el nombre de la tabla cuyos nombres de los campos que quiero
     * @return array indexado con los nombres de los campos
     */
    public function nomCol(string $tabla):array{
        $campos = [];
        $consulta = "select * from $tabla";
        $this->conexion->query($consulta);
        $campos=$r->fetch_fields();
        foreach($campos as $campo){
            $campos[]=$campo->name;
        }
        return $campos;
    }
    
    public function insert($query){
        return $this->conexion->query($query);
    }

    public function existe($user, $pass): boolean{
        if($this->conexion == null){
            $this->conexion = $this->conectar();
        }
        $consulta = "select * from usuarios where nombre='$user' AND pass='$pass'";
        $resultado = $this->conexion->query($consulta);
        if($resultado->num_rows > 0){
            return true;
        }else{
            return false;
        }
    }
}
