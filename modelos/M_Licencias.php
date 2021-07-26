<?php

class M_Licencias extends \DB\SQL\Mapper
{
    public function __construct() {
		parent::__construct( \Base::instance()->get('DB'), 'licencias'); //colocar el nombre de la tabla
	}
}