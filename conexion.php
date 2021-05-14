<?php

    class conexion{

        private $conn;

        public function __construct(){

            $this->conn = new mysqli("localhost","root","", "travelblog");
        
        }

        public function conectar(){ // VALIDO SI ME GENERA ALGUN ERROR AL REALIZAR LA CONEXION.

            if (($this->conn)->connect_error){
    
                $error = ($this->conn)->connect_error;
        
                echo $error;
        
            }

        }

        public function getConn(){ // RETORNO EL VALOR DE CONN

            return $this->conn;

        }

    }

    $conexion = new conexion();

    $conexion->conectar();

?>