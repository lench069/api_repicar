<?php
include "php1/class.phpmailer.php";
include "php1/class.smtp.php";

			$nombre = $_GET['nombre'];
			$mail = $_GET['mail'];
			$asunto = $_GET['asunto'];
			$mensaje = $_GET['mensaje'];
			

$email_user = "infomezzaninecafebar@gmail.com";
$email_password = "mezzanine20";
$the_subject = $asunto;
$address_to = "lvelastegui@riobytes.com"; //AQUI CAMBIAR EL CORREO AL QUE QUIEES QUE TE LLEGUEN LOS CORREOS
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



$phpmailer->Body .="<h1 style='color:#3498db;'>Envio un correo</h1>";
$phpmailer->Body .= "<p><b>Su nombre es:</b> ". $nombre ."</p>";
$phpmailer->Body .= "<p><b>Su email es: </b>". $mail ."</p>";
$phpmailer->Body .= "<p> <b>Su mensaje es: </b>" . $mensaje ."</p>";


$phpmailer->IsHTML(true);
if($phpmailer->Send())
	{
			echo "enviado";
	}else {
		echo "error";
	};
?>