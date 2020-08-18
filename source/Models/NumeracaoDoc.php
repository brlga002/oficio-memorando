<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class NumeracaoDoc extends DataLayer
{
    public function __construct()
    {
        parent::__construct("mie_controleNumeracao", [],"id",true);
    }

    public function getProximoNumeroDoc(string $id_tipoDoc,string $ano)
    {
        $data = new ControleNumeroDocumento();
        return $data->numeroDoc = $data->getProximoControleNumeroDocumento($id_tipoDoc,$ano);
    }
    public function getProximoNumeroDoc_old(string $id_tipoDoc,string $ano)
    {
        $numeros = ($this)->find("id_tipoDoc = :uid", "uid={$id_tipoDoc}")
            ->find("ano = :uid", "uid={$ano}")->fetch();
        if(!$numeros){
            $this->id_tipoDoc = $id_tipoDoc;
            $this->ano = $ano;
            $this->ultimoNumero = "1";
            $this->save();
            return $this->ultimoNumero;
        } else {
            $numeros->ultimoNumero +=  1;
            $numeros->save();
            return $numeros->ultimoNumero;
        }
    }
}