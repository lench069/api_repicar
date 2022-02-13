<?php

class Cliente_Ctrl
{
    public $M_Cliente = null;
    public $server = 'http://192.168.100.19:8080/api_repicar/';
    //public $server = 'http://riobytes.com/api_repicar/';
    public function __construct()
    {
        $this->M_Cliente = new M_Cliente();
    }

    public function registrar($f3)
    {
            
            $this->M_Cliente->set('NOMBRES', $f3->get('POST.nombres'));
            $this->M_Cliente->set('APELLIDOS', $f3->get('POST.apellidos'));
            $this->M_Cliente->set('EMAIL', $f3->get('POST.email'));
            $this->M_Cliente->set('CELULAR', $f3->get('POST.celular'));
            $this->M_Cliente->set('CONTRASENIA', $f3->get('POST.contrasenia'));
            $this->M_Cliente->set('ESTADO', $f3->get('POST.estado'));
            $this->M_Cliente->set('FOTO', $this->Guardar_Imagen($f3->get('POST.foto')));
            $this->M_Cliente->set('TOKEN', $f3->get('POST.token'));
            $this->M_Cliente->set('UIDD', $f3->get('POST.uidd'));
            $this->M_Cliente->set('LOGIN', $f3->get('POST.login'));
            $this->M_Cliente->save();
           // echo $f3->get('DB')->log();
            echo json_encode([
                'mensaje' => 'Cliente creado',
                'info' =>[
                    'id'=>$this->M_Cliente->get('ID_CLIENTE')
                ]
            ]);
            
    }
    public function consultar($f3)
    {
        $id_cliente = $f3->get('PARAMS.id_cliente');
        $this->M_Cliente->load(['ID_CLIENTE = ?',$id_cliente]);
        $msg='';
        $item = array();
        if($this->M_Cliente->loaded() > 0)
        {
            $msg = 'Cliente encontrado';
            $item = $this->M_Cliente->cast();
            $item['FOTO'] = !empty($item['FOTO']) ? $this->server . $item['FOTO'] : 'http://via.placeholder.com/300x300';
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
        $this->M_Cliente->load(['ID_CLIENTE = ?',$id_cliente]);
        $msg='';
        $info = array();
        if($this->M_Cliente->loaded() > 0)
        {
                $this->M_Cliente->set('NOMBRES', $f3->get('POST.nombres'));
                $this->M_Cliente->set('APELLIDOS', $f3->get('POST.apellidos'));
                if($f3->get('POST.foto') <> 'false')
                {
                    $this->M_Cliente->set('FOTO', $this->Guardar_Imagen($f3->get('POST.foto')));
                }
                $this->M_Cliente->save();
                $msg = 'Cliente fue actualizado';
                $info['id'] = $this->M_Cliente->get('ID_CLIENTE');
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
    public function actualizar_token($f3)
    {
        $id_cliente = $f3->get('PARAMS.id_cliente');
        $this->M_Cliente->load(['ID_CLIENTE = ?',$id_cliente]);
        $msg='';
        $info = array();
        if($this->M_Cliente->loaded() > 0)
        {
                $this->M_Cliente->set('TOKEN', $f3->get('POST.token'));
                $this->M_Cliente->save();
                $msg = 'token fue actualizado';
                $info['id'] = $this->M_Cliente->get('ID_CLIENTE');
        }else
        {
            $msg = 'NO se actualizo el token';
            $info['id'] = 0;

        }
        echo json_encode([
            'mensaje' => $msg,           
            'info' => $info
        ]);
        
    }

    public function actualizar_login($f3)
    {
        $id_cliente = $f3->get('PARAMS.id_cliente');
        $this->M_Cliente->load(['ID_CLIENTE = ?',$id_cliente]);
        $msg='';
        $info = array();
        if($this->M_Cliente->loaded() > 0)
        {
                $this->M_Cliente->set('LOGIN', $f3->get('POST.login'));
                $this->M_Cliente->save();
                $msg = 'login fue actualizado';
                $info['id'] = $this->M_Cliente->get('ID_CLIENTE');
        }else
        {
            $msg = 'NO se actualizo el login';
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
    public function login($f3)
    {
        $this->M_Cliente->load(['EMAIL = ?',$f3->get('POST.email')]);
       
        $msg='';
        $item = array();
        if($this->M_Cliente->loaded() > 0)
        {
            $this->M_Cliente->load(['CONTRASENIA = ? AND EMAIL = ?',$f3->get('POST.contrasenia'), $f3->get('POST.email')]);
            
            if($this->M_Cliente->loaded() > 0)
            {
                $msg = 'true';
                $item = $this->M_Cliente->cast();
            }else{
                $msg = 'Contraseña incorrecta';
            }
   
        }else
        {
            $msg = 'Email no existe';

        }
        echo json_encode([
            'mensaje' => $msg,
            'info' =>[
                'item'=>$item
            ]
        ]);
        
    }
    public function Push_Notificacion($f3)
    {
        
        $r = Push::android(['mtitle' =>$f3->get('POST.titulo'), 'mdesc' => $f3->get('POST.desc'),'COD' => $f3->get('POST.cod_pedido')],$f3->get('POST.token'));      
        if($r){
            echo 'push enviada';
        }else{
            echo 'error al enviar push';
        }

    }
}