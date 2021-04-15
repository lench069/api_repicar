<?php

class Publicidad_Ctrl
{
    public $M_Publicidad = null;

    public function __construct()
    {
        $this->M_Publicidad = new M_Publicidad();
    }

    public function registrar($f3)
    {
            $this->M_Publicidad->set('descripcion', $f3->get('POST.descripcion'));
            $this->M_Publicidad->set('fecha', $f3->get('POST.fecha'));
            $this->M_Publicidad->save();
            echo json_encode([
                'mensaje' => 'publicidad creado',
                'info' =>[
                    'id'=>$this->M_Publicidad->get('id_publicidad')
                ]
            ]);
            
    }
}