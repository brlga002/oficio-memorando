<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class LoginModel extends DataLayer
{
    public function __construct()
    {
        parent::__construct("mie_usuarios", [],"id",true);
    }
}