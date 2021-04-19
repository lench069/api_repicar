<?php

class M_Ciudades extends \DB\SQL\Mapper
{
    public function __construct() {
		parent::__construct( \Base::instance()->get('DB'), 'ciudad'); //colocar el nombre de la tabla
	}
}