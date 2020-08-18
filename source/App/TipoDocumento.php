<?php

namespace Source\App;

use League\Plates\Engine;
use Source\Models\AssinaturaDisponivel;
use Source\Models\ModeloDocumento;
use Source\Models\Documentos;
use Source\Models\TipoDocModel;

class TipoDocumento
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
        $this->view->addFolder('modelo', __DIR__."/../views/TipoDocumento");
        $this->view->addData(["router" => $router]);
    }

    public function home(): void
    {
        $data = (new TipoDocModel())->find()->fetch(true);
        if(!$data) $data = array();

        echo $this->view->render("modelo::home",[
            "title" => "Modelos de Docrando | ". SITE,
            "data" => $data,
            "titulo" => "Tipo Documento",
            "subTitulo" => "Listagem de tipos Documento",
        ]);
    }

    public function edit($data): void
    {
        $id=intval(filter_var($data["id"], FILTER_SANITIZE_NUMBER_INT));
        $data = (new TipoDocModel())->findById($id);
        if ($_POST) {
            $nomeTipoDoc = filter_input(INPUT_POST, "nomeTipoDoc", FILTER_SANITIZE_STRIPPED);
            $tipo = filter_input(INPUT_POST, "tipo", FILTER_SANITIZE_STRIPPED);
            $sigla = filter_input(INPUT_POST, "sigla", FILTER_SANITIZE_STRIPPED);
            $data->nomeTipoDoc = $nomeTipoDoc;
            $data->tipo = $tipo;
            $data->sigla = $sigla;
            $data->save();
            setMessage("success","Edição Salva");
        }

        echo $this->view->render("modelo::edit",[
            "title" => "Novo Docrando | ". SITE,
            "data" => $data,
            "titulo" => "Editar Tipo Documento",
            "subTitulo" => "Confirme os campos abaixo antes de salvar",
            "action" => url("tipoDocumento/editar/{$data->id}")
        ]);
    }

    public function new(): void
    {
        $data = new TipoDocModel();
        if ($_POST) {
            $nomeTipoDoc = filter_input(INPUT_POST, "nomeTipoDoc", FILTER_SANITIZE_STRIPPED);
            $tipo = filter_input(INPUT_POST, "tipo", FILTER_SANITIZE_STRIPPED);
            $sigla = filter_input(INPUT_POST, "sigla", FILTER_SANITIZE_STRIPPED);
            $data->nomeTipoDoc = $nomeTipoDoc;
            $data->tipo = $tipo;
            $data->sigla = $sigla;
            $data->save();
            setMessage("success","Novo Tipo Documento Salvo");
           // $this->route->redirect("assinaturas");
        }

        echo $this->view->render("modelo::modelo",[
            "title" => "Novo Tipo Documento | ". SITE,
            "data" => $data,
            "titulo" => "Novo Tipo Documento",
            "subTitulo" => "Confirme os campos abaixo antes de salvar",
            "action" => url("tipoDocumento/novo")
        ]);

    }

    public function delete($data): void
    {
        $id=intval(filter_var($data["id"], FILTER_SANITIZE_NUMBER_INT));
        $modelo = (new TipoDocModel())->findById($id);
        $documentos = (new Documentos())->find("id_tipoDoc = :uid", "uid={$id}")->fetch(true);
        if($documentos){
            setMessage("warning", "Não foi possivel deletar pois esta em uso!");
        } else {
            $modelo->destroy();
            setMessage("info", "Tipo documeto Deletado!");
        }
        $this->route->redirect("tipoDocumento");
    }
}