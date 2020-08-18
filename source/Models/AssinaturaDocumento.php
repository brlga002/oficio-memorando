<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class AssinaturaDocumento extends DataLayer
{
    public function __construct()
    {
        parent::__construct("mie_assinaturas", [],"id",true);
    }
}