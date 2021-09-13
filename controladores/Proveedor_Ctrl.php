<?php
include "php1/class.phpmailer.php";
include "php1/class.smtp.php";

class Proveedor_Ctrl
{
    public $M_Proveedor = null;
   // public $server = 'http://192.168.100.19/api_repicar/';
    public $key="01234567890123456789012345678901"; // 32 bytes
    public $vector="1234567890123412"; // 16 bytes

    public function __construct()
    {
        $this->M_Proveedor = new M_Proveedor();
    }

    public function registrar($f3)
    {
            
            $this->M_Proveedor->set('NOMBRES', $f3->get('POST.nombres'));
            $this->M_Proveedor->set('CI_RUC', $f3->get('POST.ci_ruc'));
            $this->M_Proveedor->set('ID_ADMINISTRADOR', null);
            $this->M_Proveedor->set('ESTADO', 3);
            $this->M_Proveedor->set('TELEFONO', $f3->get('POST.telefono'));
            $this->M_Proveedor->set('EMAIL', $f3->get('POST.email'));
            $this->M_Proveedor->set('NOMBRE_LOCAL', $f3->get('POST.nombre_local'));
            $this->M_Proveedor->set('ID_CIUDAD_F', $f3->get('POST.id_ciudad_f'));
            $this->M_Proveedor->set('DIRECCION', $f3->get('POST.direccion'));
            $this->M_Proveedor->set('SECTOR', $f3->get('POST.sector'));
            $this->M_Proveedor->set('CONTRASENIA', $f3->get('POST.contrasenia'));
            $this->M_Proveedor->set('TIPO_PUBLICIDAD', 1);
            $this->M_Proveedor->set('LICENCIA', 1);
            $this->M_Proveedor->save();
           
            if($this->M_Proveedor->save())
             {
                       
                        $nombre = 'Repicar';
                        $mail = 'lcvelastegui@gmail.com';
                        $asunto = 'Bienvenida';
                        $mensaje = 'esto es una prueba';
                
                        $email_user = "lcvelastegui@gmail.com";
                        $email_password = "@P@ssw0rd69";
                        $the_subject = $asunto;
                        $address_to = $f3->get('POST.email'); //AQUI CAMBIAR EL CORREO AL QUE QUIEES QUE TE LLEGUEN LOS CORREOS
                        $from_name = $nombre;
                        $phpmailer = new PHPMailer();
                        // ---------- datos de la cuenta de Gmail -------------------------------
                        $phpmailer->Username = $email_user;
                        $phpmailer->Password = $email_password; 
                        //-----------------------------------------------------------------------
                        // $phpmailer->SMTPDebug = 1;
                        $phpmailer->SMTPSecure = 'ssl';
                        $phpmailer->Host = "smtp.gmail.com"; // GMail
                        $phpmailer->Port = 465;
                        $phpmailer->IsSMTP(); // use SMTP
                        $phpmailer->SMTPAuth = true;
                        $phpmailer->setFrom($phpmailer->Username,$from_name);
                        $phpmailer->AddAddress($address_to); // recipients email
                        $phpmailer->Subject = $the_subject;	 
                        $phpmailer->Body .="<body style='background-color: black'>

                        <!--Copia desde aquí-->
                        <table style='max-width: 600px; padding: 10px; margin:0 auto; border-collapse: collapse;'>
                            <tr>
                                <td style='background-color: #093856; text-align: left; padding: 0'>
                                    
                                        <center><img width='15%' style='display:block; margin: 1.5% 3%' src='https://docs.google.com/uc?export=download&id=1iNXe-TAFQKqvkjbsHB1wmpHSHPJD2VaO'></center>
                                    
                                </td>
                            </tr>

                            <tr>
                                <td style='padding: 0'
                                    <img style='padding: 0; display: block' src='https://s19.postimg.org/y5abc5ryr/alola_region.jpg' width='100%'>
                                </td>
                            </tr>
                            
                            <tr>
                                <td style='background-color: #093856'>
                                    <div style='color: #FDFEFE; margin: 4% 10% 2%; text-align: justify;font-family: sans-serif'>
                                        <h2 style='color: #FDC134; margin: 0 0 7px'>Bienvenido a REPiCAR!</h2>
                                        <p style='margin: 2px; font-size: 15px; style='color: #FFFF'>
                                        Gracias por suscribirte a REPICAR, estas a muy poco de formar parte de la mejor plataforma de venta de repuestos automotrices online, con la cual aumentaras el volumen de tus ventas y serás parte del marketing digital que REPICAR ofrece a sus suscriptores.  </p>
                                        <p>Pronto un asesor se comunicará contigo para completar tu suscripción y detallarte de forma más clara los términos de uso de la aplicación y todos los beneficios que tenemos para ti.</p>
                                        <p>En caso de que uno de nuestros asesores no se haya comunicado con usted dentro de 48 horas, por favor de clic en el siguiente enlace.
                                        (Enlace para que se mande nuevamente una alerta)
                                        Visítanos en la página oficial (Repicar.com) o en nuestra página de Facebook</p>                                  
                                        <p style='color: #b3b3b3; font-size: 12px; text-align: center;margin: 30px 0 0'>Derechos reservados Repicar Diseñado por RiobytesSolutions</p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <!--hasta aquí-->

                        </body>";


                        $phpmailer->IsHTML(true);
                        $phpmailer->Send();

                        echo json_encode([
                            'mensaje' => 'Proveedor creado',
                            'info' =>[
                                'id'=>$this->M_Proveedor->get('CI_RUC')
                            ]
                        ]);
                        
            
            }
           
            
}

public function cambiar_contrasenia($f3)
{
    $this->M_Proveedor->load(['CI_RUC = ? and RESETCONTRA = ?',$f3->get('POST.ci_ruc'), 1]);
    $msg='';
    $flag='';
    $item = array();
    if($this->M_Proveedor->loaded() > 0)
    {
        $this->M_Proveedor->set('CONTRASENIA', $f3->get('POST.new_contrasenia'));
        $this->M_Proveedor->set('RESETCONTRA', 0);
        $this->M_Proveedor->save();
        $item = $this->M_Proveedor->cast();
        $flag = 'true';
        $msg = 'La contraseña se actualizo exitosamente';

    }else
    {
        $flag = 'false';
        $msg = 'El usario no solicito cambio de contraseña';
    }
    echo json_encode([
        'mensaje' => $msg,
        'flag' => $flag,
        'info' =>[
            'item'=>$item
        ]
    ]);
}

public function olvide_contrasenia($f3)
{  
    $this->M_Proveedor->load(['CI_RUC = ? and EMAIL = ?',$f3->get('POST.ci_ruc'), $f3->get('POST.correo')]);
    $id_proveedor = $f3->get('POST.ci_ruc');
    $pass = $this->myDecrypt($f3->get('POST.pass_temp'), $this->key, $this->vector); // desencripta
    $msg='';
    $flag='';
    $item = array();
    if($this->M_Proveedor->loaded() > 0)
    {
        $this->M_Proveedor->set('RESETCONTRA', 1);
        $this->M_Proveedor->set('CONTRASENIA', $f3->get('POST.pass_temp'));
        $this->M_Proveedor->save();
        if($this->M_Proveedor->save())
        {
            $this->enviar_correo_datos($f3->get('POST.correo'),'Olvide mi contraseña',$id_proveedor,$pass,$this->M_Proveedor->get('NOMBRE_LOCAL'));
        }
        $item = $this->M_Proveedor->cast();
        $flag = 'true';
        $msg = 'Solicitud de cambio de contraseña correcta';

    }else
    {
        $flag = 'false';
        $msg = 'No existe usuario con ese CI/RUC o correo';
    }
    echo json_encode([
        'mensaje' => $msg,
        'flag' => $flag,
        'info' =>[
            'item'=>$item
        ]
    ]);
}

public function verificar_cambio_contrasenia($f3)
{
    $this->M_Proveedor->load(['CI_RUC = ? and RESETCONTRA = ?',$f3->get('POST.ci_ruc'), 1]);
    $msg='';
    $item = array();
    if($this->M_Proveedor->loaded() > 0)
    {
        $item = $this->M_Proveedor->cast();
        $msg = 'true';
    }else
    {
        $msg = 'false';
    }
    echo json_encode([
        'mensaje' => $msg,
        'info' =>[
            'item'=>$item
        ]
    ]);
}

    public function login($f3)
    {
        $this->M_Proveedor->load(['CI_RUC = ?',$f3->get('POST.ci_ruc')]);
      
       /* echo "<pre>";
        print_r($this->M_Proveedor);
        echo "</pre>";*/
        $msg='';
        $item = array();
        if($this->M_Proveedor->loaded() > 0)
        {
            $this->M_Proveedor->load(['CONTRASENIA = ? AND CI_RUC = ?',$f3->get('POST.contrasenia'), $f3->get('POST.ci_ruc')]);
            
            if($this->M_Proveedor->loaded() > 0)
            {          
                if($this->M_Proveedor['ESTADO'] == 2)
                {   
                    $msg = 'Ingreso exitoso';
                    $item = $this->M_Proveedor->cast();
                }else if($this->M_Proveedor['ESTADO'] == 1)
                {
                    $msg = 'Usuario desactivado, comunicate con el administrador';
                }

            }else{
                $msg = 'Contraseña o usuario incorrecta';
            }
   
        }else
        {
            $msg = 'Usuario no existe';

        }
        echo json_encode([
            'mensaje' => $msg,
            'info' =>[
                'item'=>$item
            ]
        ]);
        
    }

    public function consultar($f3)
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

        $sql = "SELECT pro.NOMBRES, pro.CI_RUC,pro.TELEFONO,pro.EMAIL,pro.NOMBRE_LOCAL,pro.DIRECCION,
        pro.SECTOR,c.NOMBRE as NOMBRE_C,provin.NOMBRE as NOMBRE_PRO, pro.ESTADO, pro.RESETCONTRA,pro.TIPO_PUBLICIDAD,pro.LICENCIA FROM `proveedor` as pro INNER JOIN 
        ciudad as c on pro.ID_CIUDAD_F=c.ID_CIUDAD INNER JOIN provincia as provin on 
        c.ID_PROVINCIA=provin.ID_PROVINCIA where `CI_RUC` ="."'".$f3->get('PARAMS.cod_proveedor')."'";
       
        $resultado = mysqli_query($db_connection, $sql);

        $proveedor = array();
        if ($resultado->num_rows > 0) {
            $msg = 'Proveedor encontrado';
             // output data of each row
            $proveedor = mysqli_fetch_assoc($resultado);

        }else{
            $msg = 'Proveedor no exites';
        }

        echo json_encode([
            'mensaje' => $msg,
           
                'proveedor' => $proveedor,

        ]);
        
    }

    public function listar_proveedores($f3)
    {
        $db_host="localhost";
        $db_user="root";
        $db_password="";
        $db_name="repicar";

        $respuesta = array();
        
        // Create connection
        $db_connection = new mysqli($db_host, $db_user, $db_password, $db_name);
    
        mysqli_set_charset($db_connection, 'utf8');
        
        // Check connection
        if ($db_connection->connect_error) {
        die("Connection failed: " . $db_connection->connect_error);
        }


        $sql = "SELECT provee.NOMBRES,provee.CI_RUC,provee.TELEFONO,provee.EMAIL,provee.NOMBRE_LOCAL,
        ciu.NOMBRE as NOM_CIUDAD,provee.DIRECCION,provee.SECTOR,est_provee.DESCRIPCION as ESTADO,
        est_provee.ID_ESTADO, provee.`RESETCONTRA`,provee.`TIPO_PUBLICIDAD`,provee.`LICENCIA` 
        FROM `proveedor` as provee INNER JOIN estado_proveedor as est_provee on 
        provee.ESTADO = est_provee.ID_ESTADO INNER JOIN ciudad as ciu on provee.ID_CIUDAD_F=ciu.ID_CIUDAD 
        order by est_provee.DESCRIPCION desc";
        $resultado = mysqli_query($db_connection, $sql);
        while($row = mysqli_fetch_array($resultado)){
                
            $proveedores[] = $row; 
            
        }
        echo json_encode($proveedores);
      
       
    }

    public function actualizar($f3)
    {
        $id_proveedor = $f3->get('PARAMS.id_proveedor');
        $this->M_Proveedor->load(['CI_RUC = ?',$id_proveedor]);       
        $msg='';
        $info = array();
        if($this->M_Proveedor->loaded() > 0)
        {          
          if($f3->get('POST.estado') == 2)
          {
            $this->M_Proveedor->set('CONTRASENIA', $f3->get('POST.contrasenia'));
          }
            $this->M_Proveedor->set('NOMBRES', $f3->get('POST.nombres'));
            $this->M_Proveedor->set('ESTADO', $f3->get('POST.estado'));
            $this->M_Proveedor->set('TELEFONO', $f3->get('POST.telefono'));
            $this->M_Proveedor->set('EMAIL', $f3->get('POST.email'));
            $this->M_Proveedor->set('NOMBRE_LOCAL', $f3->get('POST.nombre_local'));
            $this->M_Proveedor->set('DIRECCION', $f3->get('POST.direccion'));
            $this->M_Proveedor->set('SECTOR', $f3->get('POST.sector'));
            $this->M_Proveedor->set('RESETCONTRA', 1);
            
            $pass = $this->myDecrypt($f3->get('POST.contrasenia'), $this->key, $this->vector); // desencripta

             $this->M_Proveedor->save();
            if($this->M_Proveedor->save())
            {
                       
                $this->enviar_correo_datos($f3->get('POST.email'),'Datos de ingreso Repicar',$id_proveedor,$pass,$f3->get('POST.nombre_local'));     

              }

                $msg = 'Proveedor fue actualizado';
                $info['CI_RUC'] = $this->M_Proveedor->get('CI_RUC');
            

        }else
        {
            $msg = 'El cliente no existe';
            $info['CI_RUC'] = 0;

        }
        echo json_encode([
            'mensaje' => $msg,           
            'info' => $info
        ]);
        
    }


    public function enviar_correo_datos($correo,$asuntop,$id_proveedor,$pass,$nombre_local)
    {
        $nombre = 'Repicar';
        $mail = 'lcvelastegui@gmail.com';
        $asunto = $asuntop;

        $email_user = "lcvelastegui@gmail.com";
        $email_password = "@P@ssw0rd69";
        $the_subject = $asunto;
        $address_to = $correo; //AQUI CAMBIAR EL CORREO AL QUE QUIEES QUE TE LLEGUEN LOS CORREOS
        $from_name = $nombre;
        $phpmailer = new PHPMailer();
        // ---------- datos de la cuenta de Gmail -------------------------------
        $phpmailer->Username = $email_user;
        $phpmailer->Password = $email_password; 
        //-----------------------------------------------------------------------
        // $phpmailer->SMTPDebug = 1;
        $phpmailer->SMTPSecure = 'ssl';
        $phpmailer->Host = "smtp.gmail.com"; // GMail
        $phpmailer->Port = 465;
        $phpmailer->IsSMTP(); // use SMTP
        $phpmailer->SMTPAuth = true;
        $phpmailer->setFrom($phpmailer->Username,$from_name);
        $phpmailer->AddAddress($address_to); // recipients email
        $phpmailer->Subject = $the_subject;	 
        $phpmailer->Body .="<body style='background-color: black'>

        <!--Copia desde aquí-->
        <table style='max-width: 600px; padding: 10px; margin:0 auto; border-collapse: collapse;'>
            <tr>
                <td style='background-color: #093856; text-align: left; padding: 0'>
                    
                        <center><img width='15%' style='display:block; margin: 1.5% 3%' src='https://docs.google.com/uc?export=download&id=1iNXe-TAFQKqvkjbsHB1wmpHSHPJD2VaO'></center>
                    
                </td>
            </tr>

            <tr>
                <td style='padding: 0'
                    <img style='padding: 0; display: block' src='https://s19.postimg.org/y5abc5ryr/alola_region.jpg' width='100%'>
                </td>
            </tr>
            
            <tr>
                <td style='background-color: #093856'>
                    <div style='color: #FDFEFE; margin: 4% 10% 2%; text-align: justify;font-family: sans-serif'>
                        <h2 style='color: #FDC134; margin: 0 0 7px'>FELICIDADES $nombre_local, Ya eres un socio REPICAR.!</h2>
                        <p style='margin: 2px; font-size: 15px; style='color: #FFFF'>
                        Gracias por suscribirte a REPICAR, Tus datos para el ingreso a la plataforma son:   </p>
                        <ul style='font-size: 15px;  margin: 10px 0 ; style='color: #FFFF'>
                            <li>USUARIO: $id_proveedor </li>
                            <li>CONTRASEÑA: $pass</li>                             
                        </ul>
                        <p style='margin: 2px; font-size: 15px; style='color: #FFFF' >
                        Ahora formas parte de la mejor plataforma de venta de repuestos automotrices online, auguramos éxitos en tu negocio.
Visítanos en la página oficial (Repicar.com) o en nuestra página de Facebook
                        </p>
                        
                        <p style='color: #b3b3b3; font-size: 12px; text-align: center;margin: 30px 0 0'>Derechos reservados Repicar Diseñado por RiobytesSolutions</p>
                    </div>
                </td>
            </tr>
        </table>
        <!--hasta aquí-->

        </body>";


        $phpmailer->IsHTML(true);
        $phpmailer->Send();

    }

    function myCrypt($value, $key, $iv){
        $encrypted_data = openssl_encrypt($value, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($encrypted_data);
    }
    
    function myDecrypt($value, $key, $iv){
        $value = base64_decode($value);
        $data = openssl_decrypt($value, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
        return $data;
    }
 
}

/* FUNCION PARA ENCRIPTAR Y DESENCRIPTAR
   function myCrypt($value, $key, $iv){
    $encrypted_data = openssl_encrypt($value, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
    return base64_encode($encrypted_data);
        }

        function myDecrypt($value, $key, $iv){
            $value = base64_decode($value);
            $data = openssl_decrypt($value, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
            return $data;
        }

        $valTxt="MyText";
        $key="01234567890123456789012345678901"; // 32 bytes
        $vector="1234567890123412"; // 16 bytes
        $encrypted = myCrypt($valTxt, $key, $vector);
        $decrypted = myDecrypt($encrypted, $key, $vector);
        print($encrypted . "\n");
        print($decrypted . "\n");*/

