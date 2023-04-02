<?php

class M_Tipo_Patrocinador extends \DB\SQL\Mapper
{
    public function __construct() {
		parent::__construct( \Base::instance()->get('DB'), 'tipo_patrocinador'); //colocar el nombre de la tabla
	}
}