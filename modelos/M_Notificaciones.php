<?php

class M_Notificaciones extends \DB\SQL\Mapper
{
    public function __construct() {
		parent::__construct( \Base::instance()->get('DB'), 'notificaciones'); //colocar el nombre de la tabla
	}
}