<?php

class M_Datos_Factura extends \DB\SQL\Mapper
{
    public function __construct() {
		parent::__construct( \Base::instance()->get('DB'), 'datos_factura'); //colocar el nombre de la tabla
	}
}