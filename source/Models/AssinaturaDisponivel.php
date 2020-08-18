<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class AssinaturaDisponivel extends DataLayer
{
    public function __construct()
    {
        parent::__construct("mie_assinaturaDisponivel", [], "id", true);
    }

    public function assinaturasUsuarioLogago()
    {
        return ($this)->find("id_usuario = :uid", "uid={$_SESSION["usuarioLogado"]["id"]}")->fetch(true);
    }
}