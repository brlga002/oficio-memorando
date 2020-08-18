<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class ModeloDocumento extends DataLayer
{
    public function __construct()
    {
        parent::__construct("mie_modeloDocumento", ["nomeModelo","assuntoDoc","destinatarioDoc","conteudoDoc","id_tipoDoc"],"id",true);
    }

    public function tipoDoc()
    {
        return (new TipoDocModel())->findById("{$this->id_tipoDoc}")->nomeTipoDoc;
    }
}