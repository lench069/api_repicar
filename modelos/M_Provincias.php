<?php

class M_Provincias extends \DB\SQL\Mapper
{
    public function __construct() {
		parent::__construct( \Base::instance()->get('DB'), 'provincia'); //colocar el nombre de la tabla
	}
}