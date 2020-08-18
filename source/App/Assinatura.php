<?php

namespace Source\App;

use League\Plates\Engine;
use Source\Models\AssinaturaDisponivel;
use Source\Models\ModeloDocumento;
use Source\Models\Documentos;
use Source\Models\TipoDocModel;

class Assinatura
{
    /** @var Engine */
    private $view;
    /** @var Router */
    private $route;

    public function __construct($router)
    {
        $this->route = $router;
        logonNecessario($this->route);
        $this->view = Engine::create(__DIR__."/../../theme","php");
        $this->view->addFolder('dash', __DIR__."/../../theme/dash");
        $this->view->addFolder('modelo', __DIR__."/../views/Assinatura");
        $this->view->addData(["router" => $router]);
    }

    public function home(): void
    {
        $assinaturas = (new AssinaturaDisponivel())->find()->fetch(true);
        if(!$assinaturas) $assinaturas = array();

        echo $this->view->render("modelo::home",[
            "title" => "Modelos de Docrando | ". SITE,
            "assinaturas" => $assinaturas,
            "titulo" => "Assinaturas",
            "subTitulo" => "Listagem de assinaturas",
        ]);
    }

    public function edit($data): void
    {
        $id=intval(filter_var($data["id"], FILTER_SANITIZE_NUMBER_INT));
        $assinatura = (new AssinaturaDisponivel())->findById($id);

        if ($_POST) {
            $nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_STRIPPED);
            $cargo = filter_input(INPUT_POST, "cargo", FILTER_SANITIZE_STRIPPED);
            $assinatura->nome = $nome;
            $assinatura->cargo = $cargo;
            $assinatura->save();
            setMessage("success","Edição Salva");
        }

        echo $this->view->render("modelo::edit",[
            "title" => "Novo Docrando | ". SITE,
            "assinatura" => $assinatura,
            "titulo" => "Editar Assinatura",
            "subTitulo" => "Confirme os campos abaixo antes de salvar",
            "action" => url("assinaturas/editar/{$assinatura->id}")
        ]);
    }

    public function new(): void
    {
        $assinatura = new AssinaturaDisponivel();


        if ($_POST) {
            $nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_STRIPPED);
            $cargo = filter_input(INPUT_POST, "cargo", FILTER_SANITIZE_STRIPPED);
            $assinatura->nome = $nome;
            $assinatura->cargo = $cargo;
            $assinatura->ativa = 1;
            $assinatura->id_usuario = 1;
            $assinatura->save();
            setMessage("success","Assinatura Salva");
            $this->route->redirect("assinaturas");
        }

        echo $this->view->render("modelo::modelo",[
            "title" => "Nova Assinatura | ". SITE,
            "assinatura" => $assinatura,
            "titulo" => "Nova assinatura",
            "subTitulo" => "Confirme os campos abaixo antes de salvar",
            "action" => url("assinaturas/novo")
        ]);

    }

    public function delete($data): void
    {
        $id=intval(filter_var($data["id"], FILTER_SANITIZE_NUMBER_INT));
        $modelo = (new AssinaturaDisponivel())->findById($id);
        $modelo->destroy();
        setMessage("info", "Assinatura Deletada <strong>{$modelo->nome}</strong> Deletado!");
        $this->route->redirect("assinaturas");
    }



}