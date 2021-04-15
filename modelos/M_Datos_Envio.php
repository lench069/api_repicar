<?php

class M_Datos_Envio extends \DB\SQL\Mapper
{
    public function __construct() {
		parent::__construct( \Base::instance()->get('DB'), 'datos_envio'); //colocar el nombre de la tabla
	}
}