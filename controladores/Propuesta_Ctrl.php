<?php

class Propuesta_Ctrl
{
    public $M_Propuesta = null;
    public function __construct()
    {
        $this->M_Propuesta = new M_Propuesta();
        $this->fecha_ini = date('Y-m-d H:i:s');
        $this->fecha_fin = date('Y-m-d H:i:s');
    }

    public function cotizar_propuesta($f3)
    {
      
        $id_propuesta = $f3->get('PARAMS.id_propuesta');
        $this->M_Propuesta->load(['ID_PROPUESTA = ?',$id_propuesta]);
        $msg='';
        $info = array();
        if($this->M_Propuesta->loaded() > 0)
        {
               $this->M_Propuesta->set('ESTADO', $f3->get('POST.estado'));
                $this->M_Propuesta->set('P_ORIGINAL', $f3->get('POST.p_original'));
                $this->M_Propuesta->set('P_GENERICO', $f3->get('POST.p_generico'));  
                if($f3->get('POST.factura') == 'true')
                {
                    $this->M_Propuesta->set('FACTURA', true);
                }else 
                {
                    $this->M_Propuesta->set('FACTURA', false);
                }
                if($f3->get('POST.envio') == 'true')
                {
                    $this->M_Propuesta->set('ENVIO', true);
                }else{
                    $this->M_Propuesta->set('ENVIO', false);
                }
                $this->M_Propuesta->set('FECHA_INI', $this->fecha_ini);  
                $this->M_Propuesta->save();
                $msg = 'Propuesta fue cotizada';
                $info['id'] = $this->M_Propuesta->get('ID_PROPUESTA');
        }else
        {
            $msg = 'La propuesta no existe';
            $info['id'] = 0;

        }
        echo json_encode([
            'mensaje' => $msg,           
            'info' => $info
        ]);
        
    }
}