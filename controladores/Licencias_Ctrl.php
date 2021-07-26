<?php

class Licencias_Ctrl
{
    public $M_Licencias = null;
   // public $server = 'http://192.168.100.19/api_repicar/';
    public function __construct()
    {
        $this->M_Licencias = new M_Licencias();
    }

    public function listar_Licencias($f3)
    {   
            $result = $this->M_Licencias->find();
            $items = array();
            foreach ($result as $licencia) {
                $items[] = $licencia->cast();
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

