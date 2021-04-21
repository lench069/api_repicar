<?php
//Permite que las respuestas sean en formato json
header('Content-type: application/json; charset=utf-8');
//Otros librerias que son necesarias para el funcionamiento
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
//Zona Horaria del servidor
ini_set("date.timezone", "America/Bogota");
// Kickstart the framework
$f3=require('lib/base.php');

$f3->set('DEBUG',1);
if ((float)PCRE_VERSION<8.0)
	trigger_error('PCRE version is out of date');

// Load configuration
$f3->config('config.ini');
$f3->config('routes.ini');


//conexion a la base dedatos


$f3->set('DB', new DB\SQL('mysql:host='.$f3->get('database.host').';port=3306;dbname='.$f3->get('database.dbname'),$f3->get('database.user'),$f3->get('database.pass'), $options = array(
    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_PERSISTENT => TRUE, 
    \PDO::MYSQL_ATTR_COMPRESS => TRUE, 
)));
/*
//verificacion de la conexion a la base de datos
echo "<pre>";
print_r($f3->get('DB'));
echo "</pre>";

//Para probar que los modelos esten correctos

$f3->route('GET /prueba', function($f3)
{
	$M_Cliente = new M_Cliente();
	echo "<pre>";
	print_r($f3);
	echo "</pre>";
});*/

//$f3->route('POST /registrar-cliente', 'Cliente_Ctrl->registrar');

$f3->route('GET /',
	function($f3) {
		$classes=array(
			'Base'=>
				array(
					'hash',
					'json',
					'session',
					'mbstring'
				),
			'Cache'=>
				array(
					'apc',
					'apcu',
					'memcache',
					'memcached',
					'redis',
					'wincache',
					'xcache'
				),
			'DB\SQL'=>
				array(
					'pdo',
					'pdo_dblib',
					'pdo_mssql',
					'pdo_mysql',
					'pdo_odbc',
					'pdo_pgsql',
					'pdo_sqlite',
					'pdo_sqlsrv'
				),
			'DB\Jig'=>
				array('json'),
			'DB\Mongo'=>
				array(
					'json',
					'mongo'
				),
			'Auth'=>
				array('ldap','pdo'),
			'Bcrypt'=>
				array(
					'openssl'
				),
			'Image'=>
				array('gd'),
			'Lexicon'=>
				array('iconv'),
			'SMTP'=>
				array('openssl'),
			'Web'=>
				array('curl','openssl','simplexml'),
			'Web\Geo'=>
				array('geoip','json'),
			'Web\OpenID'=>
				array('json','simplexml'),
			'Web\OAuth2'=>
				array('json'),
			'Web\Pingback'=>
				array('dom','xmlrpc'),
			'CLI\WS'=>
				array('pcntl')
		);
		$f3->set('classes',$classes);
		$f3->set('content','welcome.htm');
		echo View::instance()->render('layout.htm');
	}
);

$f3->route('GET /userref',
	function($f3) {
		$f3->set('content','userref.htm');
		echo View::instance()->render('layout.htm');
	}
);

$f3->run();
