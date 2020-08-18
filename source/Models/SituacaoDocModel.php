<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class SituacaoDocModel extends DataLayer
{
    public function __construct()
    {
        parent::__construct("mie_situacaoDoc", [],"id",true);
    }
}