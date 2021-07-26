<?php

require_once ("./conexion/conexion.php");

class TipoPublicidad_Ctrl
{

    public $M_TipoPublicidad = null;
   // public $server = 'http://192.168.100.19/api_repicar/';
    public function __construct()
    {
        $this->M_TipoPublicidad = new M_TipoPublicidad();
    }

    /*public function listar_tipopublicidad($f3)
    {
      
        $respuesta = array();   
        $respuesta  = $f3->get('DB')->exec('SELECT provee.NOMBRES,provee.CI_RUC,provee.TELEFONO,provee.EMAIL,provee.NOMBRE_LOCAL,ciu.NOMBRE as NOM_CIUDAD,provee.DIRECCION,provee.SECTOR,est_provee.DESCRIPCION as ESTADO,est_provee.ID_ESTADO FROM `proveedor` as provee INNER JOIN estado_proveedor as est_provee on provee.ESTADO = est_provee.ID_ESTADO INNER JOIN ciudad as ciu on provee.ID_CIUDAD_F=ciu.ID_CIUDAD order by est_provee.DESCRIPCION desc');
        foreach ($respuesta  as $publicidad) {
            $items[] = $publicidad;
        }
        echo json_encode($items);
         
    }*/

    public function listar_tipopublicidad($f3)
    {   
            $result = $this->M_TipoPublicidad->find();
            $items = array();
            foreach ($result as $publicidad) {
                $items[] = $publicidad->cast();
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

