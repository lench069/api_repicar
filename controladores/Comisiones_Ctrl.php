<?php

class Comisiones_Ctrl
{
    public $M_Comisiones = null;
   // public $server = 'http://192.168.100.19/api_repicar/';
    public function __construct()
    {
        $this->M_Comisiones = new M_Comisiones();
    }

    public function listar_Comisiones($f3)
    {   
            $result = $this->M_Comisiones->find();
            $items = array();
            foreach ($result as $comision) {
                $items[] = $comision->cast();
            }
            echo json_encode([
                'mensaje' => count($items) > 0 ? '' : 'Aún no hay registros para mostrar.',
                'info' => [
                    'items' => $items,
                    'total' => count($items)
                ]
            ]);    
    } 
}

