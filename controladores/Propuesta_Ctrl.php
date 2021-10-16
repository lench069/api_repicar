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
                $this->M_Propuesta->set('P_ENVIO', $f3->get('POST.p_envio'));  
                $this->M_Propuesta->set('P_ORIGINAL_COM', $f3->get('POST.p_original_com'));  
                $this->M_Propuesta->set('P_GENERICO_COM', $f3->get('POST.p_generico_com'));  
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

    public function Recotizar_propuesta($f3)
    {
       
        $id_propuesta = $f3->get('PARAMS.id_propuesta');
        $this->M_Propuesta->load(['ID_PROPUESTA = ?',$id_propuesta]);
        $msg='';
        $info = array();

        $resultado  = $f3->get('DB')->exec("UPDATE `propuesta` SET P_ORIGINAL=".$f3->get('POST.p_original').",
        `P_ORIGINAL_COM`=".$f3->get('POST.p_original_com').",`P_GENERICO`=".$f3->get('POST.p_generico').",
        `P_GENERICO_COM`=".$f3->get('POST.p_generico_com').",
        `P_ENVIO`=".$f3->get('POST.p_envio').",`FACTURA`=".$f3->get('POST.factura').",`ENVIO`=".$f3->get('POST.envio').", FECHA_INI ="."'". $this->fecha_ini."'"." WHERE ID_PROPUESTA = ".$id_propuesta);
        //echo $f3->get('DB')->log();


        if($resultado)
        {
                $msg = 'Propuesta fue editada correctamente';
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

    public function cliente_acepta_propuesta($f3)
    {
      
        $id_propuesta = $f3->get('PARAMS.id_propuesta');
        $this->M_Propuesta->load(['ID_PROPUESTA = ?',$id_propuesta]);
        $msg='';
        $info = array();
        if($this->M_Propuesta->loaded() > 0)
        {
               $this->M_Propuesta->set('ESTADO', $f3->get('POST.estado'));
                $this->M_Propuesta->set('FECHA_FIN', $this->fecha_fin);  
                if($this->M_Propuesta->save())
                {
                    $resultado  = $f3->get('DB')->exec("UPDATE `propuesta` SET `ESTADO`='Eliminado',
                    `FECHA_FIN`="."'".$this->fecha_fin."'"." WHERE `COD_PEDIDO` ="."'".$f3->get('POST.cod_pedido')."'"." AND
                    ID_PROPUESTA <>".$this->M_Propuesta->get('ID_PROPUESTA'));
                   // echo $f3->get('DB')->log();
                    $msg = 'Propuesta fue aceptada';
                    $info['id'] = $this->M_Propuesta->get('ID_PROPUESTA');
                }else{
                    $msg = 'Ocurrio un Error';
                    $info['id'] = 0;
                }
               
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