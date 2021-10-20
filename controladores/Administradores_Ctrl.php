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
        $proveedores = array();   
        $proveedores  = $f3->get('DB')->exec("SELECT * from administradores where `ID_ADMINISTRADOR` ="."'".$f3->get('PARAMS.cod_Administradores')."'");
        echo $f3->get('DB')->log();
        foreach ($proveedores  as $proveedor) {
            $items[] = $proveedor;
        }
        /*echo $items;
        /*if($items[] == [])
        {
            $msg = 'Administradores no exites'; 
        }else{
            $msg = 'Administradores encontrado';
        }
        echo json_encode([
            'mensaje' => $msg,
           
                'Administradores' => $items,

        ]);*/
           
    }


   
}