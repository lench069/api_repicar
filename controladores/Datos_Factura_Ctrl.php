<?php

class Datos_Factura_Ctrl
{
    public $M_Datos_Factura = null;

    public function __construct()
    {
        $this->M_Datos_Factura = new M_Datos_Factura();
    }

    public function registrar($f3)
    {
        $this->M_Datos_Factura->set('ID_CLIENTE', $f3->get('POST.id_cliente'));
            $this->M_Datos_Factura->set('NOMBRES', $f3->get('POST.nombres'));
            $this->M_Datos_Factura->set('APELLIDOS', $f3->get('POST.apellidos'));
            $this->M_Datos_Factura->set('EMAIL', $f3->get('POST.email'));
            $this->M_Datos_Factura->set('TELEFONO', $f3->get('POST.telefono'));
            $this->M_Datos_Factura->set('CI', $f3->get('POST.ci'));
            $this->M_Datos_Factura->set('DIRECCION', $f3->get('POST.direccion'));
            $this->M_Datos_Factura->save();
            echo json_encode([
                'mensaje' => 'Datos de factura creado',
                'info' =>[
                    'id'=>$this->M_Datos_Factura->get('ID_DFACTURA')
                ]
            ]);
            
    }
}