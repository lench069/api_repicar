<?php

class Estados_Ctrl
{
    public $M_Estados = null;
   // public $server = 'http://192.168.100.19/api_repicar/';
    public function __construct()
    {
        $this->M_Estados = new M_Estados();
    }

    public function listar_Estados($f3)
    {
        $f3->get('DB')->begin();
        $resultado = $f3->get('DB')->exec("SELECT * FROM `estado_proveedor` WHERE 1");
        $f3->get('DB')->commit();
        foreach ($resultado  as $row)
        {             
            $Estados[] = $row;   
        }
        echo json_encode($Estados);
      
       
    }


   
}

