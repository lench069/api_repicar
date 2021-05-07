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

    


   
}