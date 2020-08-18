<?php

namespace Source\App;

use League\Plates\Engine;
use Source\Models\ModeloDocumento;
use Source\Models\Documentos;
use Source\Models\TipoDocModel;

class Modelo
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
        $this->view->addFolder('modelo', __DIR__."/../views/Modelo");
        $this->view->addData(["router" => $router]);
    }

    public function home($data): void
    {
        $modelos = array();

        if (isset($data["id"])) {
            $id=intval(filter_var($data["id"], FILTER_SANITIZE_NUMBER_INT));
            $modelos = (new ModeloDocumento())->find("id_tipoDoc=:id_tipoDoc", "id_tipoDoc={$id}")->fetch(true);
        } else {
            $modelos = (new ModeloDocumento())->find()->fetch(true);
        }

        if(!$modelos) $modelos = array();

        echo $this->view->render("modelo::home",[
            "title" => "Modelos de Docrando | ". SITE,
            "modelos" => $modelos,
            "titulo" => "Mode de Documentos",
            "subTitulo" => "Listagem de modelos",
        ]);
    }

    public function show($data): void
    {
        $id=intval(filter_var($data["id"], FILTER_SANITIZE_NUMBER_INT));
        $documento = (new Documentos());
        $modelo = (new ModeloDocumento())->findById($id);

        echo $this->view->render("modelo::useModelo",[
            "title" => "Novo Docrando | ". SITE,
            "modelo" => $modelo,
            "documento" => $documento,
            "titulo" => "Usar Modelo de Documento",
            "subTitulo" => "Confirme os campos abaixo antes de salvar",
            "action" => url("documento/novo")
        ]);
    }

    public function edit($data): void
    {
        $id=intval(filter_var($data["id"], FILTER_SANITIZE_NUMBER_INT));
        $tiposDoc = (new Documentos())->tiposDoc();
        $modelo = (new ModeloDocumento())->findById($id);

        if ($_POST) {
            $nomeModelo = filter_input(INPUT_POST, "nomeModelo", FILTER_SANITIZE_STRIPPED);
            $assuntoDoc = filter_input(INPUT_POST, "assuntoDoc", FILTER_SANITIZE_STRIPPED);
            $destinatarioDoc = filter_input(INPUT_POST, "destinatarioDoc", FILTER_SANITIZE_STRIPPED);
            $conteudoDoc = filter_input(INPUT_POST, "conteudoDoc", FILTER_SANITIZE_SPECIAL_CHARS);
            $id_tipoDoc = filter_input(INPUT_POST, "id_tipoDoc", FILTER_SANITIZE_NUMBER_INT);

            $modelo->nomeModelo = $nomeModelo;
            $modelo->assuntoDoc = $assuntoDoc;
            $modelo->destinatarioDoc = $destinatarioDoc;
            $modelo->conteudoDoc = $conteudoDoc;
            $modelo->id_tipoDoc = $id_tipoDoc;
            $modelo->save();
            setMessage("success","Edição Salva");
        }

        echo $this->view->render("modelo::modelo",[
            "title" => "Novo Docrando | ". SITE,
            "modelo" => $modelo,
            "tiposDoc" => $tiposDoc,
            "titulo" => "Editar Modelo",
            "subTitulo" => "Confirme os campos abaixo antes de salvar",
            "action" => url("modelos/modelo/editar/{$modelo->id}")
        ]);
    }

    public function new(): void
    {
        $tiposDoc = (new Documentos())->tiposDoc();
        $modelo = new ModeloDocumento();


        if ($_POST) {
            $nomeModelo = filter_input(INPUT_POST, "nomeModelo", FILTER_SANITIZE_STRIPPED);
            $assuntoDoc = filter_input(INPUT_POST, "assuntoDoc", FILTER_SANITIZE_STRIPPED);
            $destinatarioDoc = filter_input(INPUT_POST, "destinatarioDoc", FILTER_SANITIZE_STRIPPED);
            $conteudoDoc = filter_input(INPUT_POST, "conteudoDoc", FILTER_SANITIZE_SPECIAL_CHARS);
            $id_tipoDoc = filter_input(INPUT_POST, "id_tipoDoc", FILTER_SANITIZE_NUMBER_INT);

            $modelo->nomeModelo = $nomeModelo;
            $modelo->assuntoDoc = $assuntoDoc;
            $modelo->destinatarioDoc = $destinatarioDoc;
            $modelo->conteudoDoc = $conteudoDoc;
            $modelo->id_tipoDoc = $id_tipoDoc;
            $modelo->save();
            setMessage("success","Modelo Salvo");
            $this->route->redirect("/modelos");
        }

        echo $this->view->render("modelo::modelo",[
            "title" => "Novo Docrando | ". SITE,
            "modelo" => $modelo,
            "tiposDoc" => $tiposDoc,
            "titulo" => "Novo modelo de documento",
            "subTitulo" => "Confirme os campos abaixo antes de salvar",
            "action" => url("modelos/modelo/novo")
        ]);

    }

    public function delete($data): void
    {
        $id=intval(filter_var($data["id"], FILTER_SANITIZE_NUMBER_INT));
        $modelo = (new ModeloDocumento())->findById($id);
        $modelo->destroy();
        setMessage("info", "Modelo Deletado <strong>{$modelo->nomeModelo}</strong> Deletado!");
        $this->route->redirect("modelos");
    }



}