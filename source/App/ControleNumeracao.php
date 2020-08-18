<?php

namespace Source\App;


use League\Plates\Engine;
use Source\Models\ControleNumeroDocumento;
use Source\Models\Documentos;


class ControleNumeracao
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
        $this->view->addFolder('modelo', __DIR__."/../views/Controle");
        $this->view->addData(["router" => $router]);
    }

    public function home(): void
    {
        $data = (new ControleNumeroDocumento())->find()->fetch(true);
        if(!$data) $data = array();

        $numeracao = (new ControleNumeroDocumento())->getUltimoNumeroOficio();

        echo $this->view->render("modelo::home",[
            "title" => "Modelos de Docrando | ". SITE,
            "data" => $data,
            "numeracao" => $numeracao,
            "titulo" => "Documentos Emitidos",
            "subTitulo" => "Listagem de usuários",
        ]);
    }

    public function edit($data): void
    {
        $id=intval(filter_var($data["id"], FILTER_SANITIZE_NUMBER_INT));
        $data = (new ControleNumeroDocumento())->findById($id);
        $tipoDocumento = (new Documentos())->tiposDoc();
        if ($_POST) {
            $data->assuntoDoc = filter_input(INPUT_POST, "assuntoDoc", FILTER_SANITIZE_STRIPPED);
            $data->destinatarioDoc = filter_input(INPUT_POST, "destinatarioDoc", FILTER_SANITIZE_STRIPPED);
            $data->dataDoc = filter_input(INPUT_POST, "dataDoc", FILTER_SANITIZE_STRIPPED);
            $data->id_tipoDoc = filter_input(INPUT_POST, "id_tipoDoc", FILTER_SANITIZE_NUMBER_INT);
            $data->anoDoc = date("Y", strtotime($data->dataDoc));
            $data->numeroDoc = zeroEsquerda(filter_input(INPUT_POST, "numeroDoc", FILTER_SANITIZE_NUMBER_INT));
            $data->save();

            setMessage("success","Edição Salva");
        }

        echo $this->view->render("modelo::edit",[
            "title" => "Novo Docrando | ". SITE,
            "data" => $data,
            "tipoDocumento" => $tipoDocumento,
            "titulo" => "Editar Controle Documento",
            "subTitulo" => "Confirme os campos abaixo antes de salvar",
            "action" => url("controle/editar/{$data->id}")
        ]);
    }

    public function new(): void
    {
        $data = new ControleNumeroDocumento();
        $tipoDocumento = (new Documentos())->tiposDoc();
        if ($_POST) {
            $data->assuntoDoc = filter_input(INPUT_POST, "assuntoDoc", FILTER_SANITIZE_STRIPPED);
            $data->destinatarioDoc = filter_input(INPUT_POST, "destinatarioDoc", FILTER_SANITIZE_STRIPPED);
            $data->dataDoc = filter_input(INPUT_POST, "dataDoc", FILTER_SANITIZE_STRIPPED);
            $data->id_tipoDoc = filter_input(INPUT_POST, "id_tipoDoc", FILTER_SANITIZE_NUMBER_INT);
            $data->anoDoc = date("Y", strtotime($data->dataDoc));
            $data->numeroDoc = $data->getProximoControleNumeroDocumento($data->id_tipoDoc,$data->anoDoc);
            $data->save();

            setMessage("success","Documento Salvo {$data->numeroDoc}/{$data->anoDoc}");
            $this->route->redirect("controle");
        }

        echo $this->view->render("modelo::modelo",[
            "title" => "Novo Documento | ". SITE,
            "data" => $data,
            "tipoDocumento" => $tipoDocumento,
            "titulo" => "Novo Documento Manual",
            "subTitulo" => "Caso não seja gerado pelo sistema, insira o documento no controle",
            "action" => url("controle/novo")
        ]);

    }

    public function delete($data): void
    {
        $id=intval(filter_var($data["id"], FILTER_SANITIZE_NUMBER_INT));
        $modelo = (new ControleNumeroDocumento())->findById($id);
        $modelo->destroy();
        setMessage("info", "Controle Deletado!");
        $this->route->redirect("controle");
    }
}