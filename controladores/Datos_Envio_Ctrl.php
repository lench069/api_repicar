<?php

class Datos_Envio_Ctrl
{
    public $M_Datos_Envio = null;

    public function __construct()
    {
        $this->M_Datos_Envio = new M_Datos_Envio();
    }

    public function registrar($f3)
    {
        $this->M_Datos_Envio->set('ID_CLIENTE', $f3->get('POST.id_cliente'));
            $this->M_Datos_Envio->set('CALL_PRINCIPAL', $f3->get('POST.call_principal'));
            $this->M_Datos_Envio->set('CALL_SECUANDARIA', $f3->get('POST.call_secundaria'));
            $this->M_Datos_Envio->set('TELEFONO', $f3->get('POST.telefono_env'));
            $this->M_Datos_Envio->set('REFERENCIA', $f3->get('POST.referencia'));
            $this->M_Datos_Envio->save();
            echo json_encode([
                'mensaje' => 'Datos de envio fue creado',
                'info' =>[
                    'id'=>$this->M_Datos_Envio->get('ID_DFACTURA')
                ]
            ]);
            
    }
    public function consultar_datosEnv($f3)
    {
        $id_cliente = $f3->get('PARAMS.id_cliente');
        $this->M_Datos_Envio->load(['ID_CLIENTE = ?',$id_cliente]);
        $msg='';
        $item = array();
        if($this->M_Datos_Envio->loaded() > 0)
        {
            $msg = 'Datos de envio encontrado';
            $item = $this->M_Datos_Envio->cast();
        }else
        {
            $msg = 'No tiene datos de envio';

        }
        echo json_encode([
            'mensaje' => $msg,
            'item'=>$item
        ]);
        
    }
}