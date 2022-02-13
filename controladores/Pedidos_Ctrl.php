<?php

class Pedidos_Ctrl
{
    public $M_Pedidos = null;
    public $M_Datos_Factura = null;
    public $M_Datos_Envio = null;
    public $M_Propuesta = null;
    public $M_Proveedor = null;
    public $M_Fotos = null;
    public $server = 'http://192.168.100.19:8080/api_repicar/';
    //public $server = 'http://riobytes.com/api_repicar/';
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
        $this->fecha_fin = date('Y-m-d H:i:s');
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
                $this->M_Datos_Factura->load(['ID_CLIENTE = ?',$f3->get('POST.id_cliente')]);
                if($this->M_Datos_Factura->loaded() > 0)
                {
                    $this->M_Datos_Factura->set('ID_CLIENTE', $f3->get('POST.id_cliente'));
                    $this->M_Datos_Factura->set('NOMBRES', $f3->get('POST.nombres'));
                    $this->M_Datos_Factura->set('EMAIL', $f3->get('POST.email'));
                    $this->M_Datos_Factura->set('TELEFONO', $f3->get('POST.telefono'));
                    $this->M_Datos_Factura->set('CI', $f3->get('POST.ci'));
                    $this->M_Datos_Factura->set('DIRECCION', $f3->get('POST.direccion'));
                    $this->M_Datos_Factura->save();
                }else{
                    //reset model datos factura
                    $this->M_Datos_Factura->reset();
                    $this->M_Datos_Factura->set('ID_CLIENTE', $f3->get('POST.id_cliente'));
                    $this->M_Datos_Factura->set('NOMBRES', $f3->get('POST.nombres'));
                    $this->M_Datos_Factura->set('EMAIL', $f3->get('POST.email'));
                    $this->M_Datos_Factura->set('TELEFONO', $f3->get('POST.telefono'));
                    $this->M_Datos_Factura->set('CI', $f3->get('POST.ci'));
                    $this->M_Datos_Factura->set('DIRECCION', $f3->get('POST.direccion'));
                    $this->M_Datos_Factura->save();
                }

                
                
            }
        //Insertar datos de envio
            if($f3->get('POST.servicio_env') == '1')
            {
                $this->M_Datos_Envio->load(['ID_CLIENTE = ?',$f3->get('POST.id_cliente')]);
                if($this->M_Datos_Envio->loaded() > 0)
                {
                    $this->M_Datos_Envio->set('ID_CLIENTE', $f3->get('POST.id_cliente'));
                    $this->M_Datos_Envio->set('CALL_PRINCIPAL', $f3->get('POST.call_principal'));
                    $this->M_Datos_Envio->set('CALL_SECUNDARIA', $f3->get('POST.call_secundaria'));
                    $this->M_Datos_Envio->set('TELEFONO', $f3->get('POST.telefono_env'));
                    $this->M_Datos_Envio->set('REFERENCIA', $f3->get('POST.referencia'));
                    $this->M_Datos_Envio->save(); 
                }else{
                    $this->M_Datos_Envio->reset();
                    $this->M_Datos_Envio->set('ID_CLIENTE', $f3->get('POST.id_cliente'));
                    $this->M_Datos_Envio->set('CALL_PRINCIPAL', $f3->get('POST.call_principal'));
                    $this->M_Datos_Envio->set('CALL_SECUNDARIA', $f3->get('POST.call_secundaria'));
                    $this->M_Datos_Envio->set('TELEFONO', $f3->get('POST.telefono_env'));
                    $this->M_Datos_Envio->set('REFERENCIA', $f3->get('POST.referencia'));
                    $this->M_Datos_Envio->save(); 
                }
               
            }
 //Creacion de Propuestas
            $result = $this->M_Proveedor->find(['ID_CIUDAD_F = ? AND ESTADO = ?', $f3->get('POST.id_ciudad'), 2]);
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
               $this->M_Propuesta->set('P_ORIGINAL_COM', 0);
               $this->M_Propuesta->set('P_GENERICO_COM', 0);
               $this->M_Propuesta->set('P_ENVIO', 0);
               $this->M_Propuesta->set('FACTURA', 0);
               $this->M_Propuesta->set('ENVIO', 0);
               $this->M_Propuesta->set('ESTADO', 'Creado');
               $this->M_Propuesta->set('NOTIFICACION', '');
               $this->M_Propuesta->set('FECHA_INI',$this->fecha_ini);
               $this->M_Propuesta->save(); 

          }
        //Guadar fotos
      
        if($f3->get('POST.foto[2]') <> '')
        {
            for ($i = 0; $i<=2;$i++)
            {
               
                $this->M_Fotos->reset();
                $this->M_Fotos->set('COD_PEDIDO', $f3->get('POST.cod_pedido'));
                
                $this->M_Fotos->set('IMAGEN', $this->Guardar_Imagen($f3->get('POST.foto['.$i.']')));
                $this->M_Fotos->save();
            }
        }
        elseif($f3->get('POST.foto[1]') <> '')
        {
            for ($i = 0; $i<=1;$i++)
            {
                
                $this->M_Fotos->reset();
                $this->M_Fotos->set('COD_PEDIDO', $f3->get('POST.cod_pedido'));
                
                $this->M_Fotos->set('IMAGEN', $this->Guardar_Imagen($f3->get('POST.foto['.$i.']')));
                $this->M_Fotos->save();
            }
        }
        elseif($f3->get('POST.foto[0]') <> '')
        {
            for ($i = 0; $i<=0;$i++)
            {
               
                $this->M_Fotos->reset();
                $this->M_Fotos->set('COD_PEDIDO', $f3->get('POST.cod_pedido'));
                
                $this->M_Fotos->set('IMAGEN', $this->Guardar_Imagen($f3->get('POST.foto['.$i.']')));
                $this->M_Fotos->save();
            }
        }elseif($f3->get('POST.foto[0]') == '')
        {
            
        }
        // respuesta al front
            echo json_encode([
                'mensaje' => 'Pedido creado',
                'info' =>[
                    'id'=>$this->M_Pedidos->get('COD_PEDIDO')
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
        $tiempo = time() + rand();
        $nombre_imagen = '';
        if(!empty($contenido))
        {
            $contenido = explode('base64',$contenido);
            $imagen = $contenido[1];
            $nombre_imagen = 'imagenes/'.$tiempo.'.jpg';
            file_put_contents($nombre_imagen,base64_decode($imagen));
        }

        return $nombre_imagen;
        
    }
    public function Listar_Pedidos($f3)
    {
       
        $f3->get('DB')->begin();
        $resultado = $f3->get('DB')->exec("SELECT SUBSTRING(`FECHA_INI`,1,10) as FECHA_INICIAL,COUNT(`FECHA_INI`) as num
        FROM `pedidos` where `ID_CLIENTE` =". $f3->get('POST.id_cliente')." and ESTADO='Creado' GROUP by FECHA_INICIAL ORDER by `FECHA_INI` desc");
        $f3->get('DB')->commit();
        $fecha = '';
        $pedidos = array();
        $total = array();
        
        foreach ($resultado  as $row1){
            //echo $row1['FECHA_INICIAL'];
           $pedidos= [];
           $fecha = $row1['FECHA_INICIAL'];
           $cantidad = $row1['num'];
           $f3->get('DB')->begin();
           $resultado1= $f3->get('DB')->exec("SELECT p.COD_PEDIDO,p.`ID_CLIENTE`,p.`ANIO`,p.`DESCRIPCION`,p.TIPO_VEHICULO,p.MARCA,p.MODELO,p.`ORIGINAL`,p.`GENERICO`,
           p.`ESTADO`,p.`FECHA_INI`,p.`FECHA_FIN`,c.NOMBRE as NOMBRE_CIUDAD,pro.NOMBRE as NOMBRE_PROV 
           FROM `pedidos`as p INNER JOIN ciudad as c ON p.id_ciudad = c.ID_CIUDAD INNER JOIN provincia 
           as pro ON c.ID_PROVINCIA = pro.ID_PROVINCIA  WHERE `FECHA_INI` LIKE '".$fecha."%' and `ESTADO`='Creado' and `ID_CLIENTE` =". $f3->get('POST.id_cliente')." ORDER BY FECHA_INI DESC");
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

    public function Total_Pedidos($f3)
    {
        $resultado  = $f3->get('DB')->exec("SELECT COUNT(*) as total_pedido
        FROM `pedidos` where `ID_CLIENTE` =".$f3->get('POST.id_cliente')." and ESTADO='Creado' ORDER by `FECHA_INI` desc");
         
        $resultado1  = $f3->get('DB')->exec("SELECT COUNT(*) as total_pedido_Aceptados
         FROM `pedidos` where `ID_CLIENTE` =".$f3->get('POST.id_cliente')." and ESTADO='Finalizado' ORDER by `FECHA_INI` desc");
        $totales = array();
        array_push($totales,array('info_totales' => $resultado,'totales_pedidos' => $resultado1) );
        echo json_encode([         
            'info' => $totales
        ]);
    }

    public function Listar_Pedidos_Historial($f3)
    {
        $f3->get('DB')->begin();
        $resultado = $f3->get('DB')->exec("SELECT SUBSTRING(`FECHA_INI`,1,10) as FECHA_INICIAL,COUNT(`FECHA_INI`) as num
        FROM `pedidos` where ESTADO='Finalizado' and `ID_CLIENTE` =". $f3->get('POST.id_cliente')." GROUP by FECHA_INICIAL ORDER by `FECHA_INI` desc");
        $f3->get('DB')->commit();
        $fecha = '';
        $pedidos = array();
        $total = array();
        foreach ($resultado  as $row1)
        {
            //echo $row1['FECHA_INICIAL'];
           $pedidos= [];
           $fecha = $row1['FECHA_INICIAL'];
           $cantidad = $row1['num'];
           $f3->get('DB')->begin();
           $resultado1 = $f3->get('DB')->exec("SELECT p.COD_PEDIDO,p.`ID_CLIENTE`,p.`ANIO`,p.`DESCRIPCION`,p.TIPO_VEHICULO,p.MARCA,p.MODELO,p.`ORIGINAL`,p.`GENERICO`,
           p.`ESTADO`,p.`FECHA_INI`,p.`FECHA_FIN`,c.NOMBRE as NOMBRE_CIUDAD,pro.NOMBRE as NOMBRE_PROV 
           FROM `pedidos`as p INNER JOIN ciudad as c ON p.id_ciudad = c.ID_CIUDAD INNER JOIN provincia 
           as pro ON c.ID_PROVINCIA = pro.ID_PROVINCIA  WHERE `FECHA_INI` LIKE '".$fecha."%' and ESTADO='Finalizado' and `ID_CLIENTE` =". $f3->get('POST.id_cliente'));
           // echo $f3->get('DB')->log();
           $f3->get('DB')->commit();
            $row2= array();
            foreach ($resultado1  as $row2)
            {
               // echo $row2;
                $notificaciones[] = $row2;
                
            }
            array_push($total,array('fecha' => $fecha,'cantidad' => $cantidad, 'items' =>$notificaciones) );
        
        };
        echo json_encode($total);
    }


    public function consultar($f3)
    {
        $f3->get('DB')->begin();

        $resultado = $f3->get('DB')->exec("SELECT p.COD_PEDIDO,p.`ID_CLIENTE`,p.`ANIO`,p.`DESCRIPCION`,p.TIPO_VEHICULO,p.MARCA,p.MODELO,p.`ORIGINAL`,p.`GENERICO`,
        p.`ESTADO`,p.`FECHA_INI`,p.`FECHA_FIN`,c.NOMBRE as NOMBRE_CIUDAD,pro.NOMBRE as NOMBRE_PROV 
        FROM `pedidos`as p INNER JOIN ciudad as c ON p.id_ciudad = c.ID_CIUDAD INNER JOIN provincia 
        as pro ON c.ID_PROVINCIA = pro.ID_PROVINCIA  WHERE  `COD_PEDIDO` ="."'".$f3->get('PARAMS.cod_pedido')."'");
        $f3->get('DB')->commit();

        $pedido = array();
        $propuesta = array();
        if ($resultado) {
            $msg = 'Pedido encontrado';
             // output data of each row
            $pedido = $resultado[0];
            $f3->get('DB')->begin();
            $result = $f3->get('DB')->exec("SELECT pro.CI_RUC,pro.COD_PEDIDO,pro.P_ORIGINAL,pro.P_GENERICO,pro.FACTURA,pro.ENVIO,
            pro.ESTADO,pro.NOTIFICACION,pro.ID_PROPUESTA,pro.FECHA_INI,prove.NOMBRES as NOMBRE_PROVEE,
            prove.NOMBRE_LOCAL,prove.DIRECCION,prove.SECTOR, 
            c.NOMBRE as NOMBRE_CIUDAD, provin.NOMBRE as NOMBRE_PROVIN FROM `propuesta` as pro INNER JOIN 
            proveedor as prove on pro.`CI_RUC` = prove.CI_RUC INNER JOIN ciudad as c on 
            prove.ID_CIUDAD_F=c.ID_CIUDAD INNER JOIN provincia as provin ON c.ID_PROVINCIA=provin.ID_PROVINCIA
             WHERE `COD_PEDIDO` = "."'".$f3->get('PARAMS.cod_pedido')."'"."and (pro.ESTADO='Cotizado' or pro.ESTADO='Aceptado') order by pro.FECHA_INI desc") ;
            $f3->get('DB')->commit();

            if ($result) {
                foreach ($result  as $row)
                {
                    // echo $row2;
                     $propuesta[] = $row;  
                 }
            }else{
                $msg = 'Pedido encontrado pero no tiene propuestas';
            }

        }else{
            $msg = 'Pedido no exites';
        }

        echo json_encode([
            'mensaje' => $msg,
           
                'pedido' => $pedido,
                'propuestas' => $propuesta

        ]);
        
    }

    public function Listar_Pedidos_Nuevos($f3)
    {
        $f3->get('DB')->begin();

        $resultado = $f3->get('DB')->exec("SELECT propues.CI_RUC,propues.COD_PEDIDO,propues.ID_PROPUESTA, pe.TIPO_VEHICULO,pe.MARCA,pe.MODELO,pe.ANIO,
        pe.DESCRIPCION,pe.ORIGINAL,pe.GENERICO,pe.FACTURA,pe.SERVICIO_ENV,pe.ESTADO,pe.FECHA_INI, 
        ci.NOMBRE as NOMBRE_CIUDAD, provin.NOMBRE as NOMBRE_PROVINCIA, cli.ID_CLIENTE,
        cli.TOKEN FROM `proveedor` as pro INNER JOIN
         propuesta as propues on pro.ci_ruc = propues.CI_RUC INNER JOIN pedidos as pe on 
         propues.COD_PEDIDO=pe.COD_PEDIDO INNER JOIN ciudad as ci on pro.`ID_CIUDAD_F`=ci.ID_CIUDAD 
         INNER JOIN provincia as provin on ci.ID_PROVINCIA=provin.ID_PROVINCIA INNER JOIN cliente as cli on pe.ID_CLIENTE=cli.ID_CLIENTE WHERE pro.`CI_RUC`=
         "."'".$f3->get('POST.id_proveedor')."'"." and propues.ESTADO = 'Creado' order by pe.FECHA_INI DESC");
        // echo $f3->get('DB')->log();
        $f3->get('DB')->commit();
        $pedidos = array();
        $fotos = array();
        $respuesta = array();
        foreach ($resultado  as $row){
          
            
            $pedidos[] = $row; 
            $f3->get('DB')->begin();
            $result = $f3->get('DB')->exec("SELECT * FROM `fotos` WHERE `COD_PEDIDO` ="."'".$row["COD_PEDIDO"]."'");
            $f3->get('DB')->commit();

            if ($result) {
                foreach ($result as $row1){
                    // echo $row2;                   
                     $row1['IMAGEN'] = !empty($row1['IMAGEN']) ? $this->server . $row1['IMAGEN'] : 'http://via.placeholder.com/300x300';
                     $fotos[] = $row1;  
                    }
            }else{
                $msg = 'Pedido encontrado pero no tiene fotos';
            }
            //array_push($row,array('fotos' => $fotos) );
            array_push($respuesta,array('pedidos' => $pedidos,'fotos' => $fotos) );
            $pedidos = [];
            $fotos=[];
            
        }
        echo json_encode($respuesta);
      
       
    }

    public function Listar_Pedidos_Nuevos_PorTipoV($f3)
    {
        $f3->get('DB')->begin();

        $resultado = $f3->get('DB')->exec("SELECT propues.CI_RUC,propues.COD_PEDIDO,propues.ID_PROPUESTA, pe.TIPO_VEHICULO,pe.MARCA,pe.MODELO,pe.ANIO,
        pe.DESCRIPCION,pe.ORIGINAL,pe.GENERICO,pe.FACTURA,pe.SERVICIO_ENV,pe.ESTADO,pe.FECHA_INI, 
        ci.NOMBRE as NOMBRE_CIUDAD, provin.NOMBRE as NOMBRE_PROVINCIA FROM `proveedor` as pro INNER JOIN
         propuesta as propues on pro.ci_ruc = propues.CI_RUC INNER JOIN pedidos as pe on 
         propues.COD_PEDIDO=pe.COD_PEDIDO INNER JOIN ciudad as ci on pro.`ID_CIUDAD_F`=ci.ID_CIUDAD 
         INNER JOIN provincia as provin on ci.ID_PROVINCIA=provin.ID_PROVINCIA WHERE pro.`CI_RUC`=
         "."'".$f3->get('POST.id_proveedor')."'"." and propues.ESTADO = 'Creado' and pe.`TIPO_VEHICULO` = "."'".$f3->get('POST.detalle_tipov')."'"."  order by pe.FECHA_INI DESC");
        $f3->get('DB')->commit();
        $pedidos = array();
        $fotos = array();
        $respuesta = array();
        foreach ($resultado  as $row){ 
            $pedidos[] = $row; 
            $f3->get('DB')->begin();
            $result = $f3->get('DB')->exec("SELECT * FROM `fotos` WHERE `COD_PEDIDO` ="."'".$row["COD_PEDIDO"]."'");
            $f3->get('DB')->commit();
            if ($result) {
                foreach ($result  as $row1){
                    // echo $row2;                   
                     $row1['IMAGEN'] = !empty($row1['IMAGEN']) ? $this->server . $row1['IMAGEN'] : 'http://via.placeholder.com/300x300';
                     $fotos[] = $row1;  
                    }
            }else{
                $msg = 'Pedido encontrado pero no tiene fotos';
            }
            //array_push($row,array('fotos' => $fotos) );
            array_push($respuesta,array('pedidos' => $pedidos,'fotos' => $fotos) );
            $pedidos = [];
            $fotos=[];
            
        }
        echo json_encode($respuesta);
      
       
    }

    public function Listar_Pedidos_Nuevos_PorMarca($f3)
    {
        $f3->get('DB')->begin();

        $resultado = $f3->get('DB')->exec("SELECT propues.CI_RUC,propues.COD_PEDIDO,propues.ID_PROPUESTA, pe.TIPO_VEHICULO,pe.MARCA,pe.MODELO,pe.ANIO,
        pe.DESCRIPCION,pe.ORIGINAL,pe.GENERICO,pe.FACTURA,pe.SERVICIO_ENV,pe.ESTADO,pe.FECHA_INI, 
        ci.NOMBRE as NOMBRE_CIUDAD, provin.NOMBRE as NOMBRE_PROVINCIA FROM `proveedor` as pro INNER JOIN
         propuesta as propues on pro.ci_ruc = propues.CI_RUC INNER JOIN pedidos as pe on 
         propues.COD_PEDIDO=pe.COD_PEDIDO INNER JOIN ciudad as ci on pro.`ID_CIUDAD_F`=ci.ID_CIUDAD 
         INNER JOIN provincia as provin on ci.ID_PROVINCIA=provin.ID_PROVINCIA WHERE pro.`CI_RUC`=
         "."'".$f3->get('POST.id_proveedor')."'"." and propues.ESTADO = 'Creado' and pe.`TIPO_VEHICULO` = "."'".$f3->get('POST.detalle_tipov')."'"." and pe.`MARCA` = "."'".$f3->get('POST.detalle_marca')."'"."  order by pe.FECHA_INI DESC");
         $f3->get('DB')->commit();
        $pedidos = array();
        $fotos = array();
        $respuesta = array();
        foreach ($resultado  as $row){
          
            
            $pedidos[] = $row; 
            $f3->get('DB')->begin();
            $result = $f3->get('DB')->exec("SELECT * FROM `fotos` WHERE `COD_PEDIDO` ="."'".$row["COD_PEDIDO"]."'");
            $f3->get('DB')->commit();
            if ($result) {
                foreach ($result  as $row1){
                    // echo $row2;                   
                     $row1['IMAGEN'] = !empty($row1['IMAGEN']) ? $this->server . $row1['IMAGEN'] : 'http://via.placeholder.com/300x300';
                     $fotos[] = $row1;  
                    }
            }else{
                $msg = 'Pedido encontrado pero no tiene fotos';
            }
            //array_push($row,array('fotos' => $fotos) );
            array_push($respuesta,array('pedidos' => $pedidos,'fotos' => $fotos) );
            $pedidos = [];
            $fotos=[];
            
        }
        echo json_encode($respuesta);
      
       
    }

    public function Listar_Pedidos_Nuevos_PorTermino($f3)
    {
        $f3->get('DB')->begin();

        $resultado = $f3->get('DB')->exec("SELECT propues.CI_RUC,propues.COD_PEDIDO,propues.ID_PROPUESTA, pe.TIPO_VEHICULO,pe.MARCA,pe.MODELO,pe.ANIO,
        pe.DESCRIPCION,pe.ORIGINAL,pe.GENERICO,pe.FACTURA,pe.SERVICIO_ENV,pe.ESTADO,pe.FECHA_INI, 
        ci.NOMBRE as NOMBRE_CIUDAD, provin.NOMBRE as NOMBRE_PROVINCIA FROM `proveedor` as pro INNER JOIN
         propuesta as propues on pro.ci_ruc = propues.CI_RUC INNER JOIN pedidos as pe on 
         propues.COD_PEDIDO=pe.COD_PEDIDO INNER JOIN ciudad as ci on pro.`ID_CIUDAD_F`=ci.ID_CIUDAD 
         INNER JOIN provincia as provin on ci.ID_PROVINCIA=provin.ID_PROVINCIA WHERE pro.`CI_RUC`=
         "."'".$f3->get('POST.id_proveedor')."'"." and propues.ESTADO = 'Creado' and (pe.`TIPO_VEHICULO` like "."'%".$f3->get('POST.termino')."%'"." 
         || pe.`MARCA` like "."'%".$f3->get('POST.termino')."%'"." || pe.`DESCRIPCION` like "."'%".$f3->get('POST.termino')."%'"." || pe.`ANIO` like "."'%".$f3->get('POST.termino')."%'".") order by pe.FECHA_INI DESC");
         $f3->get('DB')->commit();
        $pedidos = array();
        $fotos = array();
        $respuesta = array();
        foreach ($resultado  as $row){
          
            
            $pedidos[] = $row; 
            $f3->get('DB')->begin();
            $result = $f3->get('DB')->exec("SELECT * FROM `fotos` WHERE `COD_PEDIDO` ="."'".$row["COD_PEDIDO"]."'");
            $f3->get('DB')->commit();
            if ($result) {
                foreach ($result  as $row1){
                    // echo $row2;                   
                     $row1['IMAGEN'] = !empty($row1['IMAGEN']) ? $this->server . $row1['IMAGEN'] : 'http://via.placeholder.com/300x300';
                     $fotos[] = $row1;  
                    }
            }else{
                $msg = 'Pedido encontrado pero no tiene fotos';
            }
            //array_push($row,array('fotos' => $fotos) );
            array_push($respuesta,array('pedidos' => $pedidos,'fotos' => $fotos) );
            $pedidos = [];
            $fotos=[];
            
        }
        echo json_encode($respuesta);
      
       
    }

    public function Listar_Pedidos_Enviados($f3)
    {
        $resultado = array();   
        $resultado  = $f3->get('DB')->exec("SELECT propues.CI_RUC,propues.COD_PEDIDO,propues.ID_PROPUESTA,propues.P_ORIGINAL,propues.P_ORIGINAL_COM,
        propues.P_GENERICO,propues.P_GENERICO_COM,propues.P_ENVIO,propues.FACTURA as FAC_PROPUESTA,propues.ENVIO 
        as ENV_PROPUESTA,pe.TIPO_VEHICULO,pe.MARCA,pe.MODELO,pe.ANIO,
        pe.DESCRIPCION,pe.ORIGINAL,pe.GENERICO,pe.FACTURA,pe.SERVICIO_ENV,pe.ESTADO as ESTADO_PEDIDO,pe.FECHA_INI, 
        ci.NOMBRE as NOMBRE_CIUDAD, provin.NOMBRE as NOMBRE_PROVINCIA, propues.ESTADO as ESTADO_PROPUESTA FROM `proveedor` as pro INNER JOIN
         propuesta as propues on pro.ci_ruc = propues.CI_RUC INNER JOIN pedidos as pe on 
         propues.COD_PEDIDO=pe.COD_PEDIDO INNER JOIN ciudad as ci on pro.`ID_CIUDAD_F`=ci.ID_CIUDAD 
         INNER JOIN provincia as provin on ci.ID_PROVINCIA=provin.ID_PROVINCIA WHERE pro.`CI_RUC`=
         "."'".$f3->get('POST.id_proveedor')."'"." and (propues.ESTADO = 'Cotizado' or propues.ESTADO='Aceptado') and propues.ACEPT=0 order by pe.FECHA_INI DESC");
       //echo $f3->get('DB')->log();
        $pedidos = array();
        $fotos = array();
        $respuesta = array();
        foreach ($resultado  as $row) {
            $pedidos[] = $row; 
            $result =  $f3->get('DB')->exec("SELECT * FROM `fotos` WHERE `COD_PEDIDO` ="."'".$row["COD_PEDIDO"]."'");
            if (count($resultado) > 0) {        
                    foreach ($result  as $row1){
                    // echo $row2;                   
                     $row1['IMAGEN'] = !empty($row1['IMAGEN']) ? $this->server . $row1['IMAGEN'] : 'http://via.placeholder.com/300x300';
                     $fotos[] = $row1;  
                    }
            }else{
                $msg = 'Pedido encontrado pero no tiene fotos';
            }
            //array_push($row,array('fotos' => $fotos) );
            array_push($respuesta,array('pedidos' => $pedidos,'fotos' => $fotos) );
            $pedidos = [];
            $fotos=[];
        }
        echo json_encode($respuesta);
    }

    public function Listar_Pedidos_Aceptados($f3)
    {
        $resultado = array();   
        $resultado  = $f3->get('DB')->exec("SELECT propues.CI_RUC,propues.COD_PEDIDO,propues.ID_PROPUESTA, pe.TIPO_VEHICULO,pe.MARCA,pe.MODELO,pe.ANIO,
        pe.DESCRIPCION,pe.ORIGINAL,pe.GENERICO,pe.FACTURA,pe.SERVICIO_ENV,pe.ESTADO,pe.FECHA_INI, pe.ESTADO,pe.FECHA_FIN,
        ci.NOMBRE as NOMBRE_CIUDAD, provin.NOMBRE as NOMBRE_PROVINCIA, propues.P_ORIGINAL, propues.P_ORIGINAL_COM,propues.P_GENERICO, propues.P_GENERICO_COM,
        propues.P_ENVIO,propues.FACTURA as FAC_PROPUESTA,propues.ENVIO as ENV_PROPUESTA FROM `proveedor` as pro INNER JOIN
         propuesta as propues on pro.ci_ruc = propues.CI_RUC INNER JOIN pedidos as pe on 
         propues.COD_PEDIDO=pe.COD_PEDIDO INNER JOIN ciudad as ci on pro.`ID_CIUDAD_F`=ci.ID_CIUDAD 
         INNER JOIN provincia as provin on ci.ID_PROVINCIA=provin.ID_PROVINCIA WHERE pro.`CI_RUC`=
         "."'".$f3->get('POST.id_proveedor')."'"." and propues.ESTADO = 'Aceptado' and propues.ACEPT=1 order by pe.FECHA_INI DESC");
       //echo $f3->get('DB')->log();
        $pedidos = array();
        $fotos = array();
        $respuesta = array();
        foreach ($resultado  as $row) {
            $pedidos[] = $row; 
            $result =  $f3->get('DB')->exec("SELECT * FROM `fotos` WHERE `COD_PEDIDO` ="."'".$row["COD_PEDIDO"]."'");
            if (count($resultado) > 0) {        
                    foreach ($result  as $row1){
                    // echo $row2;                   
                     $row1['IMAGEN'] = !empty($row1['IMAGEN']) ? $this->server . $row1['IMAGEN'] : 'http://via.placeholder.com/300x300';
                     $fotos[] = $row1;  
                    }
            }else{
                $msg = 'Pedido encontrado pero no tiene fotos';
            }
            //array_push($row,array('fotos' => $fotos) );
            array_push($respuesta,array('pedidos' => $pedidos,'fotos' => $fotos) );
            $pedidos = [];
            $fotos=[];
        }
        echo json_encode($respuesta);

    }

    public function Listar_Pedidos_Finalizados($f3)
    {
       
        $fecha_inicial= new DateTime();
        $fecha_inicial->modify('first day of this month');
        $fecha_final= new DateTime();
        $fecha_final->modify('last day of this month');
        $respuesta = array();

        $f3->get('DB')->begin();
        $resultado = $f3->get('DB')->exec("SELECT propues.CI_RUC,propues.COD_PEDIDO,propues.ID_PROPUESTA, pe.TIPO_VEHICULO,pe.MARCA,pe.MODELO,pe.ANIO,
        pe.DESCRIPCION,pe.ORIGINAL,pe.GENERICO,pe.FACTURA,pe.SERVICIO_ENV,pe.ESTADO,pe.FECHA_INI, pe.ESTADO,pe.FECHA_FIN,
        ci.NOMBRE as NOMBRE_CIUDAD, provin.NOMBRE as NOMBRE_PROVINCIA, propues.ESTADO,propues.P_ORIGINAL, propues.P_ORIGINAL_COM,propues.P_GENERICO, propues.P_GENERICO_COM,
        propues.P_ENVIO,propues.FACTURA as FAC_PROPUESTA,propu.ENVIO as ENV_PROPUESTA FROM `proveedor` as pro INNER JOIN
         propuesta as propues on pro.ci_ruc = propues.CI_RUC INNER JOIN pedidos as pe on 
         propues.COD_PEDIDO=pe.COD_PEDIDO INNER JOIN ciudad as ci on pro.`ID_CIUDAD_F`=ci.ID_CIUDAD 
         INNER JOIN provincia as provin on ci.ID_PROVINCIA=provin.ID_PROVINCIA WHERE pro.`CI_RUC`=
         "."'".$f3->get('POST.id_proveedor')."'"." and propues.ESTADO = 'Aceptado' and propues.ACEPT=1 and 
         pe.FECHA_FIN BETWEEN "."'".$fecha_inicial->format('Y-m-d')."'"." AND "."'".$fecha_final->format('Y-m-d')."'"." 
         order by pe.FECHA_INI DESC");
         $f3->get('DB')->commit();
        $pedidos = array();
        foreach ($resultado  as $row){
                
            $pedidos[] = $row; 
            
        }
        array_push($respuesta,array('finalizados' => $pedidos,'fecha_ini' => $fecha_inicial->format('Y-m-d'),'fecha_fin' => $fecha_final->format('Y-m-d')) );
        echo json_encode($respuesta);
      
       
    }

    public function consultar_Pedido($f3)
    {
  
        $f3->get('DB')->begin();
        $resultado = $f3->get('DB')->exec("SELECT p.COD_PEDIDO,p.`ID_CLIENTE`,p.`ANIO`,p.`DESCRIPCION`,p.TIPO_VEHICULO,p.MARCA,p.MODELO,p.`ORIGINAL`,p.`GENERICO`,
        p.`ESTADO`,p.`FECHA_INI`,p.`FECHA_FIN`,c.NOMBRE as NOMBRE_CIUDAD,pro.NOMBRE as NOMBRE_PROV,propu.ID_PROPUESTA,propu.CI_RUC,propu.ESTADO,propu.P_ORIGINAL, propu.P_ORIGINAL_COM,propu.P_GENERICO, propu.P_GENERICO_COM,
        propu.P_ENVIO,propu.FACTURA as FAC_PROPUESTA,propu.ENVIO as ENV_PROPUESTA 
        FROM `pedidos`as p INNER JOIN ciudad as c ON p.id_ciudad = c.ID_CIUDAD INNER JOIN provincia 
        as pro ON c.ID_PROVINCIA = pro.ID_PROVINCIA INNER JOIN propuesta as propu on p.COD_PEDIDO = propu.COD_PEDIDO
         WHERE  p.`COD_PEDIDO` = "."'".$f3->get('PARAMS.cod_pedido')."'"." and propu.CI_RUC="."'".$f3->get('POST.id_proveedor')."'"." and propu.ESTADO='Aceptado' and propu.ACEPT=0");
         $f3->get('DB')->commit();
         //echo $f3->get('DB')->log();
        $pedidos = array();
        $fotos = array();
        $respuesta = array();
        foreach ($resultado  as $row) {
            $pedidos[] = $row; 
            $result =  $f3->get('DB')->exec("SELECT * FROM `fotos` WHERE `COD_PEDIDO` ="."'".$row["COD_PEDIDO"]."'");
            if (count($resultado) > 0) {        
                    foreach ($result  as $row1){
                    // echo $row2;                   
                     $row1['IMAGEN'] = !empty($row1['IMAGEN']) ? $this->server . $row1['IMAGEN'] : 'http://via.placeholder.com/300x300';
                     $fotos[] = $row1;  
                    }
            }else{
                $msg = 'Pedido encontrado pero no tiene fotos';
            }
            //array_push($row,array('fotos' => $fotos) );
            array_push($respuesta,array('pedidos' => $pedidos,'fotos' => $fotos) );
            $pedidos = [];
            $fotos=[];
        }
        echo json_encode($respuesta);
    }

    public function finalizar_Pedido($f3)
    {
        $respuesta = array();
        $f3->get('DB')->begin();
        $resultado = $f3->get('DB')->exec("SELECT p.COD_PEDIDO,p.`ID_CLIENTE`,p.`ANIO`,p.`DESCRIPCION`,p.TIPO_VEHICULO,p.MARCA,p.MODELO,p.`ORIGINAL`,p.`GENERICO`,
        p.`ESTADO`,p.`FECHA_INI`,p.`FECHA_FIN`,c.NOMBRE as NOMBRE_CIUDAD,pro.NOMBRE as NOMBRE_PROV,propu.ID_PROPUESTA,propu.CI_RUC,propu.ESTADO 
        FROM `pedidos`as p INNER JOIN ciudad as c ON p.id_ciudad = c.ID_CIUDAD INNER JOIN provincia 
        as pro ON c.ID_PROVINCIA = pro.ID_PROVINCIA INNER JOIN propuesta as propu on p.COD_PEDIDO = propu.COD_PEDIDO
         WHERE  p.`COD_PEDIDO` = "."'".$f3->get('PARAMS.cod_pedido')."'"." and propu.CI_RUC="."'".$f3->get('POST.id_proveedor')."'"." and propu.ESTADO='Aceptado' and propu.ACEPT=0");
         $f3->get('DB')->commit();
        $fila= $resultado;
        if ($resultado) {
            foreach ($resultado  as $row)
        {
            $f3->get('DB')->begin();
            $sql0 = $f3->get('DB')->exec("UPDATE `propuesta` SET `ESTADO`='Eliminado' WHERE `COD_PEDIDO`=".'"'.$row["COD_PEDIDO"].'"');
            $sql1 = $f3->get('DB')->exec("UPDATE `propuesta` SET `ESTADO`='Aceptado',`ACEPT`=1,`FECHA_FIN`=".'"'.$this->fecha_fin.'"'." WHERE `ID_PROPUESTA`=".$row["ID_PROPUESTA"]);
            $sql2 = $f3->get('DB')->exec("UPDATE `pedidos` SET `ESTADO`='Finalizado',`FECHA_FIN`=".'"'.$this->fecha_fin.'"'." WHERE `COD_PEDIDO`=".'"'.$row["COD_PEDIDO"].'"');
            $f3->get('DB')->commit();
           
        }   
            $result = 'true';
            $msg = 'Operacion correcta';   

        }else{
            $result = 'false';
            $msg = 'El codigo del pedido no es el correcto, vuelva a ingresarlo';
        }
        array_push($respuesta,array('result' => $result,'msg' => $msg) );
        echo json_encode($respuesta);

        
        
    }

    public function total_ventas($f3)
    {
       
        $fecha_inicial= new DateTime();
        $fecha_inicial->modify('first day of this month');
        $fecha_final= new DateTime();
        $fecha_final->modify('last day of this month');
        $respuesta = array();   

        $respuesta  = $f3->get('DB')->exec("SELECT count(pro.CI_RUC) as VENTAS,sum(propues.P_ORIGINAL) as 
        TOTAL_ORIGINAL,sum(propues.P_ORIGINAL_COM) as TOTAL_ORIGINAL_COM FROM `proveedor` as pro INNER JOIN 
        propuesta as propues on pro.ci_ruc = propues.CI_RUC INNER JOIN pedidos as pe on 
        propues.COD_PEDIDO=pe.COD_PEDIDO INNER JOIN ciudad as ci on pro.`ID_CIUDAD_F`=ci.ID_CIUDAD 
        INNER JOIN provincia as provin on ci.ID_PROVINCIA=provin.ID_PROVINCIA WHERE pro.`CI_RUC`=
         "."'".$f3->get('POST.id_proveedor')."'"." and propues.ESTADO = 'Aceptado' and propues.ACEPT=1 and 
         pe.FECHA_FIN BETWEEN "."'".$fecha_inicial->format('Y-m-d')."'"." AND "."'".$fecha_final->format('Y-m-d')."'"." 
         order by pe.FECHA_INI DESC");

        echo json_encode($respuesta);
      
       
    }


}