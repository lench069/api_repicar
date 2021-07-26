<?php

class M_Comisiones extends \DB\SQL\Mapper
{
    public function __construct() {
		parent::__construct( \Base::instance()->get('DB'), 'comisiones'); //colocar el nombre de la tabla
	}
}