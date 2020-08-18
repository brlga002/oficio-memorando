<?php

namespace Source\Models;

use CoffeeCode\DataLayer\DataLayer;

class Documentos extends DataLayer
{
    public function __construct()
    {
        parent::__construct("mie_documentos", ["numeroDoc","anoDoc","assuntoDoc","dataDoc","destinatarioDoc","conteudoDoc","chave","id_tipoDoc","id_situacaoDoc"],"id",true);
    }

    public function tipoDoc()
    {
        return (new TipoDocModel())->findById("{$this->id_tipoDoc}");
    }

    public function situacaoDoc()
    {
        return (new SituacaoDocModel())->findById("{$this->id_situacaoDoc}");
    }

    public function tiposDoc()
    {
        return (new TipoDocModel())->find()->fetch(true);
    }

    public function addAssinatura(string $id_documento,string $id_assinaturaDisponivel,string $nome,string $cargo,string $token,bool $eletronica = false)
    {
        $assinatura = new AssinaturaDocumento();
        $assinatura->id_documento = $id_documento;
        $assinatura->id_assinaturaDisponivel = $id_assinaturaDisponivel;
        $assinatura->id_usuario = $_SESSION["usuarioLogado"]["id"];
        $assinatura->nome = $nome;
        $assinatura->cargo = $cargo;
        /* Desativado assinaturaEletronica*/
        if ($eletronica){
            $assinatura->assinaturaEletronica = $token;
        } else {
            $assinatura->assinaturaEletronica = "";
        }

        $assinatura->save();

        /** Inserindo Historico */
        $historico = new HistoricoDoc();
        $historico->id_documento = $this->id;
        $historico->id_usuario = $_SESSION["usuarioLogado"]["id"];
        $historico->acao = "Confirmou assinatura por e-mail";
        $historico->save();

        /** Atualizando Situação */
        $this->id_situacaoDoc = 2;
        $this->save();
    }

    public function assinaturaNocumento()
    {
        $assinaturas = (new AssinaturaDocumento())->find("id_documento = :uid", "uid={$this->id}")->fetch(true);
        return (!$assinaturas) ? array() :$assinaturas;
    }
}