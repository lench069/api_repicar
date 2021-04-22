<?php

class Pedidos_Ctrl
{
    public $M_Pedidos = null;
    public $M_Datos_Factura = null;
    public $M_Datos_Envio = null;
    public $M_Propuesta = null;
    public $M_Proveedor = null;
    public $M_Fotos = null;
    public $server = 'http://192.168.100.19/api_repicar/';
    public $time;
    


    public function __construct()
    {

        $this->M_Pedidos = new M_Pedidos();
        $this->M_Datos_Factura = new M_Datos_Factura();
        $this->M_Datos_Envio = new M_Datos_Envio();
        $this->M_Propuesta = new M_Propuesta();
        $this->M_Proveedor = new M_Proveedor();
        $this->M_Fotos = new M_Fotos();
        $this->fecha_ini = date('Y-m-d H:i:s');
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
            $this->M_Pedidos->set('FECHA_INI', $this->fecha_ini);
            $this->M_Pedidos->set('FECHA_FIN', $f3->get('POST.fecha_fin'));
            $this->M_Pedidos->save();
        //Insertar datos de factura
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
        //Insertar datos de envio
            if($f3->get('POST.servicio_env') == '1')
            {
                $this->M_Datos_Envio->set('ID_CLIENTE', $f3->get('POST.id_cliente'));
                $this->M_Datos_Envio->set('CALL_PRINCIPAL', $f3->get('POST.call_principal'));
                $this->M_Datos_Envio->set('CALL_SECUNDARIA', $f3->get('POST.call_secundaria'));
                $this->M_Datos_Envio->set('TELEFONO', $f3->get('POST.telefono_env'));
                $this->M_Datos_Envio->set('REFERENCIA', $f3->get('POST.referencia'));
                $this->M_Datos_Envio->save(); 
            }
 //Creacion de Propuestas
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
               $this->M_Propuesta->set('FECHA_INI',$this->fecha_ini);
               $this->M_Propuesta->save(); 

          }
        //Guadar fotos
                
                $this->M_Fotos->set('COD_PEDIDO', $f3->get('POST.cod_pedido'));
                $this->M_Fotos->set('IMAGEN', $this->Guardar_Imagen($f3->get('POST.foto')));
                $this->M_Fotos->save(); 
            
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
        
    }

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
    public function Listar_Pedidos($f3)
    {
        $db_host="localhost";
        $db_user="root";
        $db_password="";
        $db_name="repicar";
        
        // Create connection
        $db_connection = new mysqli($db_host, $db_user, $db_password, $db_name);
    
        mysqli_set_charset($db_connection, 'utf8');
        
        // Check connection
        if ($db_connection->connect_error) {
        die("Connection failed: " . $db_connection->connect_error);
        }

        $sql = "SELECT SUBSTRING(`FECHA_INI`,1,10) as FECHA_INICIAL,COUNT(`FECHA_INI`) as num
        FROM `pedidos` where `ID_CLIENTE` =". $f3->get('POST.id_cliente')." GROUP by FECHA_INICIAL ORDER by `FECHA_INI` desc";
        $resultado = mysqli_query($db_connection, $sql);
        $fecha = '';
        $pedidos = array();
        $total = array();
        while($row1 = mysqli_fetch_array($resultado)){
            //echo $row1['FECHA_INICIAL'];
            $pedidos= [];
           $fecha = $row1['FECHA_INICIAL'];
           $cantidad = $row1['num'];
           $sql = "SELECT p.COD_PEDIDO,p.`ID_CLIENTE`,p.`ANIO`,p.`DESCRIPCION`,p.`ORIGINAL`,p.`GENERICO`,
           p.`ESTADO`,p.`FECHA_INI`,p.`FECHA_FIN`,c.NOMBRE as NOMBRE_CIUDAD,pro.NOMBRE as NOMBRE_PROV,
           m.DESCRIPCION as DES_MODELO,ma.DESCRIPCION as DES_MARCA,tv.DESCRIPCION as DES_TIPOV 
           FROM `pedidos`as p INNER JOIN ciudad as c ON p.id_ciudad = c.ID_CIUDAD INNER JOIN provincia 
           as pro ON c.ID_PROVINCIA = pro.ID_PROVINCIA INNER JOIN modelo as m ON m.ID_MODELO=p.modelo 
           INNER JOIN marca as ma ON ma.ID_MARCA=m.ID_MARCA INNER JOIN tipo_vehiculo as tv ON 
           tv.ID_TIPOV=ma.ID_TIPOV WHERE `FECHA_INI` LIKE '".$fecha."%' and `ID_CLIENTE` =". $f3->get('POST.id_cliente');
           //echo $sql;
            $resultado1 = mysqli_query($db_connection, $sql);
            $row2= array();
            while($row2 = mysqli_fetch_array($resultado1)){
               // echo $row2;
                $pedidos[] = $row2;
                
            }
            array_push($total,array('fecha' => $fecha,'cantidad' => $cantidad, 'items' =>$pedidos) );
        
        };
        echo json_encode($total);
    }


}