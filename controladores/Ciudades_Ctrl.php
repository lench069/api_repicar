<?php

class Ciudades_Ctrl
{
    public $M_Ciudad = null;

    public function __construct()
    {
        $this->M_Ciudad = new M_Ciudades();
    }
    public function consultar($f3)
    {
         
        $result = $this->M_Ciudad->find(['id_provincia = ?',$f3->get('PARAMS.id_provincia')]);

        $items = array();
        foreach($result as $ciudad)
        {
            $items[]= $ciudad->cast();
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