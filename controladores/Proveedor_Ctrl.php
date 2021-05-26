<?php

class Proveedor_Ctrl
{
    public $M_Proveedor = null;
   // public $server = 'http://192.168.100.19/api_repicar/';
    public function __construct()
    {
        $this->M_Proveedor = new M_Proveedor();
    }

    public function registrar($f3)
    {
            
            $this->M_Proveedor->set('NOMBRES', $f3->get('POST.nombres'));
            $this->M_Proveedor->set('CI_RUC', $f3->get('POST.ci_ruc'));
            $this->M_Proveedor->set('ID_ADMINISTRADOR', 1);
            $this->M_Proveedor->set('TELEFONO', $f3->get('POST.telefono'));
            $this->M_Proveedor->set('EMAIL', $f3->get('POST.email'));
            $this->M_Proveedor->set('NOMBRE_LOCAL', $f3->get('POST.nombre_local'));
            $this->M_Proveedor->set('ID_CIUDAD_F', 1);
            $this->M_Proveedor->set('DIRECCION', $f3->get('POST.direccion'));
            $this->M_Proveedor->set('SECTOR', $f3->get('POST.sector'));
            $this->M_Proveedor->set('CONTRASENIA', $f3->get('POST.contrasenia'));
            $this->M_Proveedor->save();
            echo json_encode([
                'mensaje' => 'Proveedor creado',
                'info' =>[
                    'id'=>$this->M_Proveedor->get('CI_RUC')
                ]
            ]);
            
    }

    public function login($f3)
    {
        $this->M_Proveedor->load(['CI_RUC = ?',$f3->get('POST.ci_ruc')]);
      
       /* echo "<pre>";
        print_r($this->M_Proveedor);
        echo "</pre>";*/
        $msg='';
        $item = array();
        if($this->M_Proveedor->loaded() > 0)
        {
            $this->M_Proveedor->load(['CONTRASENIA = ? AND CI_RUC = ?',$f3->get('POST.contrasenia'), $f3->get('POST.ci_ruc')]);
            
            if($this->M_Proveedor->loaded() > 0)
            {
                $msg = 'true';
                $item = $this->M_Proveedor->cast();
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
        pro.SECTOR,c.NOMBRE as NOMBRE_C,provin.NOMBRE as NOMBRE_PRO FROM `proveedor` as pro INNER JOIN 
        ciudad as c on pro.ID_CIUDAD_F=c.ID_CIUDAD INNER JOIN provincia as provin on 
        c.ID_PROVINCIA=provin.ID_PROVINCIA where `CI_RUC` ="."'".$f3->get('PARAMS.cod_proveedor')."'";
       
        $resultado = mysqli_query($db_connection, $sql);

        $proveedor = array();
        if ($resultado->num_rows > 0) {
            $msg = 'Proveedor encontrado';
             // output data of each row
            $proveedor = mysqli_fetch_assoc($resultado);

        }else{
            $msg = 'Proveedor no exites';
        }

        echo json_encode([
            'mensaje' => $msg,
           
                'proveedor' => $proveedor,

        ]);
        
    }


   
}