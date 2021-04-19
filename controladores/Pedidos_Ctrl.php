<?php

class Pedidos_Ctrl
{
    public $M_Pedidos = null;
    public $M_Datos_Factura = null;
    public $M_Datos_Envio = null;
    public $M_Propuesta = null;
    public $M_Proveedor = null;


    public function __construct()
    {
        $this->M_Pedidos = new M_Pedidos();
        $this->M_Datos_Factura = new M_Datos_Factura();
        $this->M_Datos_Envio = new M_Datos_Envio();
        $this->M_Propuesta = new M_Propuesta();
        $this->M_Proveedor = new M_Proveedor();
    }

    public function registrar($f3)
    {
       
            $this->M_Pedidos->set('COD_PEDIDO', $f3->get('POST.cod_pedido'));
            $this->M_Pedidos->set('ID_CLIENTE', $f3->get('POST.id_cliente'));
            $this->M_Pedidos->set('ID_CIUDAD', $f3->get('POST.id_ciudad'));
            $this->M_Pedidos->set('TIPO_VEHICULO', $f3->get('POST.tipo_vehiculo'));
            $this->M_Pedidos->set('MARCA', $f3->get('POST.marca'));
            $this->M_Pedidos->set('MODELO', $f3->get('POST.modelo'));
            $this->M_Pedidos->set('ANIO', $f3->get('POST.anio'));
            $this->M_Pedidos->set('DESCRIPCION', $f3->get('POST.descripcion'));
            $this->M_Pedidos->set('ORIGINAL', $f3->get('POST.original'));
            $this->M_Pedidos->set('GENERICO', $f3->get('POST.generico'));
            $this->M_Pedidos->set('FACTURA', $f3->get('POST.factura'));
            $this->M_Pedidos->set('SERVICIO_ENV', $f3->get('POST.servicio_env'));
            $this->M_Pedidos->set('ESTADO', $f3->get('POST.estado'));
            $this->M_Pedidos->set('FECHA_INI', $f3->get('POST.fecha_ini'));
            $this->M_Pedidos->set('FECHA_FIN', $f3->get('POST.fecha_fin'));
            $this->M_Pedidos->save();

            if($f3->get('POST.factura') == '1')
            {   
                $this->M_Datos_Factura->set('ID_CLIENTE', $f3->get('POST.id_cliente'));
                $this->M_Datos_Factura->set('NOMBRES', $f3->get('POST.nombres'));
                $this->M_Datos_Factura->set('EMAIL', $f3->get('POST.email'));
                $this->M_Datos_Factura->set('TELEFONO', $f3->get('POST.telefono'));
                $this->M_Datos_Factura->set('CI', $f3->get('POST.ci'));
                $this->M_Datos_Factura->set('DIRECCION', $f3->get('POST.direccion'));
                $this->M_Datos_Factura->save();
                
            }
            if($f3->get('POST.servicio_env') == '1')
            {
                $this->M_Datos_Envio->set('ID_CLIENTE', $f3->get('POST.id_cliente'));
                $this->M_Datos_Envio->set('CALL_PRINCIPAL', $f3->get('POST.call_principal'));
                $this->M_Datos_Envio->set('CALL_SECUNDARIA', $f3->get('POST.call_secundaria'));
                $this->M_Datos_Envio->set('TELEFONO', $f3->get('POST.telefono_env'));
                $this->M_Datos_Envio->set('REFERENCIA', $f3->get('POST.referencia'));
                $this->M_Datos_Envio->save(); 
            }

            $result = $this->M_Proveedor->find(['ID_CIUDAD_F = ?', $f3->get('POST.id_ciudad')]);
            $items = array();
            $carros = ['auto','perro'];
            foreach($result as $proveedor) {
                $items[] = $proveedor->cast(); 
            }   
//Permite ver los datos de la consulta
           $items = json_encode($items);
           $objetos = json_decode($items);
           foreach ($objetos as $objeto) {
               $this->M_Propuesta->reset();
               $this->M_Propuesta->set('CI_RUC', $objeto->CI_RUC);
               $this->M_Propuesta->set('COD_PEDIDO', $f3->get('POST.cod_pedido'));
               $this->M_Propuesta->set('P_ORIGINAL', 0);
               $this->M_Propuesta->set('P_GENERICO', 0);
               $this->M_Propuesta->set('FACTURA', 0);
               $this->M_Propuesta->set('ENVIO', 0);
               $this->M_Propuesta->set('ESTADO', 'Creado');
               $this->M_Propuesta->set('NOTIFICACION', '');
               $this->M_Propuesta->set('FECHA_INI','2021-04-19');
               $this->M_Propuesta->save(); 

          }

            
            echo json_encode([
                'mensaje' => 'Pedido creado',
                'info' =>[
                    'id'=>$this->M_Pedidos->get('COD_PEDIDO')
                ]
            ]);
            
    }
    public function consultar($f3)
    {
        $id_cliente = $f3->get('PARAMS.id_cliente');
        $this->M_Pedidos->load(['ID_CLIENTE = ?',$id_cliente]);
        $msg='';
        $item = array();
        if($this->M_Pedidos->loaded() > 0)
        {
            $msg = 'Cliente encontrado';
            $item = $this->M_Pedidos->cast();
        }else
        {
            $msg = 'El Cliente no existe';

        }
        echo json_encode([
            'mensaje' => $msg,
            'info' =>[
                'item'=>$item
            ]
        ]);
        
    }
    public function actualizar_cuenta($f3)
    {
        $id_cliente = $f3->get('PARAMS.id_cliente');
        $this->M_Pedidos->load(['ID_CLIENTE = ?',$id_cliente]);
        $msg='';
        $info = array();
        if($this->M_Pedidos->loaded() > 0)
        {
                $this->M_Pedidos->set('NOMBRES', $f3->get('POST.nombres'));
                $this->M_Pedidos->set('APELLIDOS', $f3->get('POST.apellidos'));
                $this->M_Pedidos->set('FOTO', $f3->get('POST.imagen'));
                $this->M_Pedidos->save();
                $msg = 'Cliente fue actualizado';
                $info['id'] = $this->M_Pedidos->get('ID_CLIENTE');
        }else
        {
            $msg = 'El cliente no existe';
            $info['id'] = 0;

        }
        echo json_encode([
            'mensaje' => $msg,           
            'info' => $info
        ]);
        
    };
    
    public function Guardar_Imagen($contenido)
    {
        $nombre_imagen = '';
        if(!empty($contenido))
        {
            $contenido = explode('base64',$contenido);
            $imagen = $contenido[1];
            $nombre_imagen = 'imagenes/'. time().'.jpg';
            file_put_contents($nombre_imagen,base64_decode($imagen));
        }

        return $nombre_imagen;
        
    }
}