<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class HistoricoDoc extends DataLayer
{
    public function __construct()
    {
        parent::__construct("mie_historico", [],"id",true);
    }

    public function getNome()
    {
        $nome = (new LoginModel())->findById($this->id_usuario);
        return $nome->nick;
    }
}