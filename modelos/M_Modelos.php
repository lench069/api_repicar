<?php

class M_Modelos extends \DB\SQL\Mapper
{
    public function __construct() {
		parent::__construct( \Base::instance()->get('DB'), 'modelo'); //colocar el nombre de la tabla
	}
}