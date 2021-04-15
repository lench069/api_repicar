<?php

class M_Proveedor extends \DB\SQL\Mapper
{
    public function __construct() {
		parent::__construct( \Base::instance()->get('DB'), 'proveedor'); //colocar el nombre de la tabla
	}
}