<?php

class M_Cliente extends \DB\SQL\Mapper
{
    public function __construct() {
		parent::__construct( \Base::instance()->get('DB'), 'cliente'); //colocar el nombre de la tabla
	}
}