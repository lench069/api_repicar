<?php

class Marcas_Ctrl
{
    public $M_Marcas = null;

    public function __construct()
    {
        $this->M_Marcas = new M_Marcas();
    }
    public function consultar($f3)
    {
         
        $result = $this->M_Marcas->find(['ID_TIPOV = ?',$f3->get('PARAMS.id_tipov')]);

        $items = array();
        foreach($result as $marca)
        {
            $items[]= $marca->cast();
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