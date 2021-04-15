<?php

class M_Administradores extends \DB\SQL\Mapper
{
    public function __construct() {
		parent::__construct( \Base::instance()->get('DB'), 'administradores'); //colocar el nombre de la tabla
	}
}