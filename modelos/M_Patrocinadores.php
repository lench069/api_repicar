<?php

class M_Patrocinadores extends \DB\SQL\Mapper
{
    public function __construct() {
		parent::__construct( \Base::instance()->get('DB'), 'patrocinadores'); //colocar el nombre de la tabla
	}
}