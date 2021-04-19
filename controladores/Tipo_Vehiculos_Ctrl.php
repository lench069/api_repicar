<?php

class Tipo_Vehiculos_Ctrl
{
    public $M_Tipo_Vehiculo = null;

    public function __construct()
    {
        $this->M_Tipo_Vehiculo = new M_Tipo_Vehiculos();
    }

  public function listado($f3)
    {
        $result = $this->M_Tipo_Vehiculo->find();
        $items = array();
        foreach ($result as $producto) {
            $items[] = $producto->cast();
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