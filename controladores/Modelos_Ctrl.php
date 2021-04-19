<?php

class Modelos_Ctrl
{
    public $M_Modelos = null;

    public function __construct()
    {
        $this->M_Modelos = new M_Modelos();
    }
    public function consultar($f3)
    {
         
        $result = $this->M_Modelos->find(['ID_MARCA = ?',$f3->get('PARAMS.id_marca')]);

        $items = array();
        foreach($result as $modelo)
        {
            $items[]= $modelo->cast();
        }
        echo json_encode([
            'mensaje' => count($items) > 0 ? '' : 'No existen registros para mostrar',
            'info' =>[
                'items'=> $items,
                'total'=>count($items)
            ]
        ]);

        
    }
}