<?php

class M_Estados extends \DB\SQL\Mapper
{
    public function __construct() {
		parent::__construct( \Base::instance()->get('DB'), 'estado_proveedor'); //colocar el nombre de la tabla
	}
}