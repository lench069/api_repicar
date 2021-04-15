<?php

class M_Fotos extends \DB\SQL\Mapper
{
    public function __construct() {
		parent::__construct( \Base::instance()->get('DB'), 'fotos'); //colocar el nombre de la tabla
	}
}