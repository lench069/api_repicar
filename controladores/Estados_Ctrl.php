<?php

class Estados_Ctrl
{
    public $M_Estados = null;
   // public $server = 'http://192.168.100.19/api_repicar/';
    public function __construct()
    {
        $this->M_Estados = new M_Estados();
    }

    public function listar_Estados($f3)
    {
        $db_host="localhost";
        $db_user="root";
        $db_password="";
        $db_name="repicar";

        $respuesta = array();
        
        // Create connection
        $db_connection = new mysqli($db_host, $db_user, $db_password, $db_name);
    
        mysqli_set_charset($db_connection, 'utf8');
        
        // Check connection
        if ($db_connection->connect_error) {
        die("Connection failed: " . $db_connection->connect_error);
        }


        $sql = "SELECT * FROM `estado_proveedor` WHERE 1";
        $resultado = mysqli_query($db_connection, $sql);
        while($row = mysqli_fetch_array($resultado)){
                
            $Estados[] = $row; 
            
        }
        echo json_encode($Estados);
      
       
    }


   
}

