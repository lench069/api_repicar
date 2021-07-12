<?php

class Administradores_Ctrl
{
    public $M_Administradores = null;
   // public $server = 'http://192.168.100.19/api_repicar/';
    public function __construct()
    {
        $this->M_Administradores = new M_Administradores();
    }

    public function login($f3)
    {
        $this->M_Administradores->load(['USUARIO = ?',$f3->get('POST.usuario')]);
      
       /* echo "<pre>";
        print_r($this->M_Administradores);
        echo "</pre>";*/
        $msg='';
        $item = array();
        if($this->M_Administradores->loaded() > 0)
        {
            $this->M_Administradores->load(['CONTRASENIA = ? AND USUARIO = ?',$f3->get('POST.contrasenia'), $f3->get('POST.usuario')]);
            
            if($this->M_Administradores->loaded() > 0)
            {
                $msg = 'true';
                $item = $this->M_Administradores->cast();
            }else{
                $msg = 'Contraseña incorrecta';
            }
   
        }else
        {
            $msg = 'Usuario no existe';

        }
        echo json_encode([
            'mensaje' => $msg,
            'info' =>[
                'item'=>$item
            ]
        ]);
        
    }

    public function consultar($f3)
    {
        $db_host="localhost";
        $db_user="root";
        $db_password="";
        $db_name="repicar";
        
        // Create connection
        $db_connection = new mysqli($db_host, $db_user, $db_password, $db_name);
    
        mysqli_set_charset($db_connection, 'utf8');
        
        // Check connection
        if ($db_connection->connect_error) {
        die("Connection failed: " . $db_connection->connect_error);
        }

        $sql = "SELECT pro.NOMBRES, pro.CI_RUC,pro.TELEFONO,pro.EMAIL,pro.NOMBRE_LOCAL,pro.DIRECCION,
        pro.SECTOR,c.NOMBRE as NOMBRE_C,provin.NOMBRE as NOMBRE_PRO FROM `Administradores` as pro INNER JOIN 
        ciudad as c on pro.ID_CIUDAD_F=c.ID_CIUDAD INNER JOIN provincia as provin on 
        c.ID_PROVINCIA=provin.ID_PROVINCIA where `CI_RUC` ="."'".$f3->get('PARAMS.cod_Administradores')."'";
       
        $resultado = mysqli_query($db_connection, $sql);

        $Administradores = array();
        if ($resultado->num_rows > 0) {
            $msg = 'Administradores encontrado';
             // output data of each row
            $Administradores = mysqli_fetch_assoc($resultado);

        }else{
            $msg = 'Administradores no exites';
        }

        echo json_encode([
            'mensaje' => $msg,
           
                'Administradores' => $Administradores,

        ]);
        
    }


   
}