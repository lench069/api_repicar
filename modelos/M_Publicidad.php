<?php

class M_Publicidad extends \DB\SQL\Mapper
{
    public function __construct() {
		parent::__construct( \Base::instance()->get('DB'), 'publicidad'); //colocar el nombre de la tabla
	}
}