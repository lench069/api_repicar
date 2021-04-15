<?php

class Provincias_Ctrl
{
    public $M_Provincia = null;

    public function __construct()
    {
        $this->M_Provincia = new M_Provincias();
    }
    public function consultar($f3)
    {
         
        $result = $this->M_Provincia->find(['id_pais = ?',$f3->get('PARAMS.id_pais')]);

        $items = array();
        foreach($result as $provincia)
        {
            $items[]= $provincia->cast();
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