<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class TokenAssinatura extends DataLayer
{
    public function __construct()
    {
        parent::__construct("mie_tokenAssinatura", [],"id",true);
    }

    public function getToken($id_assinaturaDisponivel,$id_documentos)
    {
        $this->deletaTokenNaoUsado($id_assinaturaDisponivel,$id_documentos);

        $token = password_hash($id_assinaturaDisponivel. KEY . $id_documentos, PASSWORD_DEFAULT);
        $token = filter_var($token, FILTER_SANITIZE_URL);
        $token = preg_replace("/([^a-z0-9])/",'',$token);
        $this->id_assinaturaDisponivel = $id_assinaturaDisponivel;
        $this->id_documentos = $id_documentos;
        $this->token = $token;
        $this->id_usuario =  $_SESSION["usuarioLogado"]["id"];
        $this->save();
        return $this->token;
    }

    public function deletaTokenNaoUsado($id_assinaturaDisponivel,$id_documentos)
    {
        $tokenVelho =  ($this)->find("id_assinaturaDisponivel = :uid", "uid={$id_assinaturaDisponivel}")
            ->find("id_documentos = :uid2", "uid2={$id_documentos}")->fetch(true);
        if($tokenVelho){
           foreach ($tokenVelho as $token){
               $token->destroy();
           }
        }
    }
}