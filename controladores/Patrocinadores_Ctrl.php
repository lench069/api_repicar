<?php

class Patrocinadores_Ctrl
{
    public $M_Patrocinadores = null;

    public function __construct()
    {
        $this->M_Patrocinadores = new M_Patrocinadores();
    }
    public function listado($f3)
    {
        $result = $this->M_Patrocinadores->find(['id_tipo_patrocinador = ?',$f3->get('PARAMS.id_tipo')]);
        $items = array();
        foreach ($result as $patrocinador) {
            $items[] = $patrocinador->cast();
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