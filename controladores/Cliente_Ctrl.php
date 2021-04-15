<?php

class Cliente_Ctrl
{
    public $M_Cliente = null;

    public function __construct()
    {
        $this->M_Cliente = new M_Cliente();
    }

    public function registrar($f3)
    {
       
            $this->M_Cliente->set('NOMBRES', $f3->get('POST.nombres'));
            $this->M_Cliente->set('APELLIDOS', $f3->get('POST.apellidos'));
            $this->M_Cliente->set('EMAIL', $f3->get('POST.email'));
            $this->M_Cliente->set('CELULAR', $f3->get('POST.celular'));
            $this->M_Cliente->set('CONTRASENIA', $f3->get('POST.contrasenia'));
            $this->M_Cliente->set('ESTADO', $f3->get('POST.estado'));
            $this->M_Cliente->set('FOTO', $f3->get('POST.foto'));
            $this->M_Cliente->save();
            echo json_encode([
                'mensaje' => 'Cliente creado',
                'info' =>[
                    'id'=>$this->M_Cliente->get('ID_CLIENTE')
                ]
            ]);
            
    }
    public function consultar($f3)
    {
        $id_cliente = $f3->get('PARAMS.id_cliente');
        $this->M_Cliente->load(['ID_CLIENTE = ?',$id_cliente]);
        $msg='';
        $item = array();
        if($this->M_Cliente->loaded() > 0)
        {
            $msg = 'Cliente encontrado';
            $item = $this->M_Cliente->cast();
        }else
        {
            $msg = 'El Cliente no existe';

        }
        echo json_encode([
            'mensaje' => $msg,
            'info' =>[
                'item'=>$item
            ]
        ]);
        
    }
    public function actualizar_cuenta($f3)
    {
        $id_cliente = $f3->get('PARAMS.id_cliente');
        $this->M_Cliente->load(['ID_CLIENTE = ?',$id_cliente]);
        $msg='';
        $info = array();
        if($this->M_Cliente->loaded() > 0)
        {
                $this->M_Cliente->set('NOMBRES', $f3->get('POST.nombres'));
                $this->M_Cliente->set('APELLIDOS', $f3->get('POST.apellidos'));
                $this->M_Cliente->set('FOTO', $f3->get('POST.imagen'));
                $this->M_Cliente->save();
                $msg = 'Cliente fue actualizado';
                $info['id'] = $this->M_Cliente->get('ID_CLIENTE');
        }else
        {
            $msg = 'El cliente no existe';
            $info['id'] = 0;

        }
        echo json_encode([
            'mensaje' => $msg,           
            'info' => $info
        ]);
        
    }
}