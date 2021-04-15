<?php

class M_Propuesta extends \DB\SQL\Mapper
{
    public function __construct() {
		parent::__construct( \Base::instance()->get('DB'), 'propuesta'); //colocar el nombre de la tabla
	}
}