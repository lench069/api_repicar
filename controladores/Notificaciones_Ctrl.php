<?php

class Notificaciones_Ctrl
{
    public $M_Notificaciones = null;

    public function __construct()
    {
        $this->M_Notificaciones = new M_Notificaciones();
        $this->fecha = date('Y-m-d H:i:s');
    }
   
    public function registrar($f3)
    {
            
            $this->M_Notificaciones->set('ID_CLIENTE', $f3->get('POST.id_cliente'));
            $this->M_Notificaciones->set('DESCRIPCION', $f3->get('POST.mensaje'));
            $this->M_Notificaciones->set('ESTADO', $f3->get('POST.estado'));
            $this->M_Notificaciones->set('FECHA', $this->fecha);
            $this->M_Notificaciones->set('TITULO', $f3->get('POST.titulo'));
            $this->M_Notificaciones->set('COD_PEDIDO', $f3->get('POST.cod_pedido'));
            $this->M_Notificaciones->save();
            echo json_encode([
                'mensaje' => 'Notificacion Guardada',
                'info' =>[
                    'id'=>$this->M_Notificaciones->get('ID_NOTIFICACIONES')
                ]
            ]);
            
    }
    public function consultar_new($f3)
    {
        $id_cliente = $f3->get('PARAMS.id_cliente');
        $f3->get('DB')->begin();
        $resultado = $f3->get('DB')->exec("SELECT * FROM `notificaciones` WHERE `ID_CLIENTE` = $id_cliente and `ESTADO` = 0");
        $f3->get('DB')->commit();
        $notificaciones_new = array();
        foreach ($resultado  as $row)
        {             
            $notificaciones_new[] = $row;   
        }
        echo json_encode($notificaciones_new);
      
       
    }
    public function Cargar_notificaciones($f3)
    {
        $f3->get('DB')->begin();
        $resultado = $f3->get('DB')->exec("SELECT SUBSTRING(`FECHA`,1,10) as FECHA_NOTI,COUNT(`FECHA`) as num FROM `notificaciones` where  
        `ID_CLIENTE` =". $f3->get('POST.id_cliente')." GROUP by FECHA_NOTI ORDER by `FECHA` desc");          
        //echo $f3->get('DB')->log();
        $f3->get('DB')->commit();
        $fecha = '';
        $pedidos = array();
        $total = array();
        foreach ($resultado  as $row1)
        {
            //echo $row1['FECHA_INICIAL'];
           $pedidos= [];
           $fecha = $row1['FECHA_NOTI'];
           $cantidad = $row1['num'];
           $f3->get('DB')->begin();
           $resultado1 = $f3->get('DB')->exec("SELECT * from notificaciones  WHERE `FECHA` LIKE '".$fecha."%' and `ID_CLIENTE` =". $f3->get('POST.id_cliente') ." order by FECHA desc");
           //echo $f3->get('DB')->log();
           $f3->get('DB')->commit();
            $row2= array();
            foreach ($resultado1  as $row2)
            {
               // echo $row2;
                $pedidos[] = $row2;
                
            }
            array_push($total,array('fecha' => $fecha,'cantidad' => $cantidad, 'items' =>$pedidos) );
        
        };
        echo json_encode($total);
    }
    public function actualizar_noti($f3)
    {
        $id_noti = $f3->get('PARAMS.id_notificacion');
        $this->M_Notificaciones->load(['ID_NOTIFICACIONES = ?',$id_noti]);
        $msg='';
        $info = array();
        if($this->M_Notificaciones->loaded() > 0)
        {
                $this->M_Notificaciones->set('ESTADO', $f3->get('POST.estado'));
                $this->M_Notificaciones->save();
                $msg = 'notificacion fue actualizado';
                $info['id'] = $this->M_Notificaciones->get('ID_NOTIFICACIONES');
        }else
        {
            $msg = 'La notificacion no existe';
            $info['id'] = 0;

        }
        echo json_encode([
            'mensaje' => $msg,           
            'info' => $info
        ]);
        
    }
}