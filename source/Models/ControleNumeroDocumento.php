<?php

namespace Source\Models;

use CoffeeCode\DataLayer\Connect;
use CoffeeCode\DataLayer\DataLayer;

class ControleNumeroDocumento extends DataLayer
{
    public function __construct()
    {
        parent::__construct("mie_controleNumeroDocumento", [],"id",true);
    }

    public function getProximoControleNumeroDocumento(string $id_tipoDoc,string $ano)
    {
        $connect = Connect::getInstance();
        $conn = $connect->query("SELECT * FROM mie_controleNumeroDocumento 
                WHERE id_tipoDoc = {$id_tipoDoc} AND anoDoc = {$ano} ORDER BY numeroDoc DESC");
        $numeros = $conn->fetch();
        print_r($numeros);

        if(!$numeros){
            $this->numeroDoc = "1";
            return $this->numeroDoc;
        } else {
            return  $numeros->numeroDoc +=  1;
        }
    }

    public function getUltimoNumeroOficio()
    {
        $connect = Connect::getInstance();
        $sql = "SELECT Max(numeroDoc) AS numeroDoc, id_tipoDoc, nomeTipoDoc, anoDoc FROM mie_controleNumeroDocumento
        INNER JOIN mie_tipoDoc
        ON mie_controleNumeroDocumento.id_tipoDoc = mie_tipoDoc.id
        GROUP BY mie_controleNumeroDocumento.id_tipoDoc,mie_controleNumeroDocumento.anoDoc
	ORDER BY anoDoc,nomeTipoDoc";
        $conn = $connect->query($sql);
        $numeros = $conn->fetchAll();
        if(!$numeros) $numeros = array();
        return $numeros;
    }

    public function tipoDoc()
    {
        return (new TipoDocModel())->findById("{$this->id_tipoDoc}")->nomeTipoDoc;
    }
}