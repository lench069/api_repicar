<?php

class M_Tipo_Vehiculos extends \DB\SQL\Mapper
{
    public function __construct() {
		parent::__construct( \Base::instance()->get('DB'), 'tipo_vehiculo'); //colocar el nombre de la tabla
	}
}