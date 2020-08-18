<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class TipoDocModel extends DataLayer
{
    public function __construct()
    {
        parent::__construct("mie_tipoDoc", [],"id",true);
    }
}