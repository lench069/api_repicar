<?php

class M_Marcas extends \DB\SQL\Mapper
{
    public function __construct() {
		parent::__construct( \Base::instance()->get('DB'), 'marca'); //colocar el nombre de la tabla
	}
}