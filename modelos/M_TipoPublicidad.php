<?php

class M_TipoPublicidad extends \DB\SQL\Mapper
{
    public function __construct() {
		parent::__construct( \Base::instance()->get('DB'), 'tipo_publicidad'); //colocar el nombre de la tabla
	}
}