<?php

class Tipo_Patrocinador_Ctrl
{
    public $M_Tipo_Patrocinador = null;

    public function __construct()
    {
        $this->M_Tipo_Patrocinador = new M_Tipo_Patrocinador();
    }
    public function listado($f3)
    {
        $result = $this->M_Tipo_Patrocinador->find();
        $items = array();
        foreach ($result as $tipo) {
            $items[] = $tipo->cast();
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