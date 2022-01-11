<?php

include './lib/push.php';

class Inicio_Ctrl
{
    public function Test_Notificacion($f3)
    {
        $id_cliente = $f3->get('PARAMS.id_cliente');
        $this->M_Cliente->load(['ID_CLIENTE = ?',10]);
        $msg='';
        $item = array();
        $item = $this->M_Cliente->cast();
        $r = Push::android(['mtitle' => "Nueva propuesta", 'mdesc' => "Tiene una propuesta para el pidido AFSFGGHGA " . date("Y-m-d H:i:s")], 
        $item['TOKEN']);
        
        
        var_dump($r);
    }
}
