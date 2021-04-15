<?php

class M_Calificacion extends \DB\SQL\Mapper
{
    public function __construct() {
		parent::__construct( \Base::instance()->get('DB'), 'calificacion'); //colocar el nombre de la tabla
	}
}