<?php

namespace Source\App;

use League\Plates\Engine;
use Source\Models\AssinaturaDisponivel;
use Source\Models\AssinaturaDocumento;
use Source\Models\LoginModel;

class Usuario
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
        $this->view->addFolder('modelo', __DIR__."/../views/Usuarios");
        $this->view->addData(["router" => $router]);
    }

    public function home(): void
    {
        $data = (new LoginModel())->find()->fetch(true);
        if(!$data) $data = array();

        echo $this->view->render("modelo::home",[
            "title" => "Modelos de Docrando | ". SITE,
            "data" => $data,
            "titulo" => "Usuários",
            "subTitulo" => "Listagem de usuários",
        ]);
    }

    public function edit($data): void
    {
        $id=intval(filter_var($data["id"], FILTER_SANITIZE_NUMBER_INT));
        $data = (new LoginModel())->findById($id);
        if ($_POST) {
            $data->nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_STRIPPED);
            $data->nick = filter_input(INPUT_POST, "nick", FILTER_SANITIZE_STRIPPED);
            $data->email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRIPPED);
            $data->password = password_hash(filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRIPPED), PASSWORD_DEFAULT);
            $data->save();
            setMessage("success","Edição Salva");
        }

        echo $this->view->render("modelo::edit",[
            "title" => "Novo Docrando | ". SITE,
            "data" => $data,
            "titulo" => "Editar Tipo Documento",
            "subTitulo" => "Confirme os campos abaixo antes de salvar",
            "action" => url("usuario/editar/{$data->id}")
        ]);
    }

    public function new(): void
    {
        $data = new LoginModel();
        if ($_POST) {
            $data->nome = filter_input(INPUT_POST, "nome", FILTER_SANITIZE_STRIPPED);
            $data->nick = filter_input(INPUT_POST, "nick", FILTER_SANITIZE_STRIPPED);
            $data->email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRIPPED);
            $data->password = password_hash(filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRIPPED), PASSWORD_DEFAULT);
            $data->save();
            setMessage("success","Novo usuario Salvo");
            $this->route->redirect("usuario");
        }

        echo $this->view->render("modelo::modelo",[
            "title" => "Novo Usuário | ". SITE,
            "data" => $data,
            "titulo" => "Novo Usuário",
            "subTitulo" => "Confirme os campos abaixo antes de salvar",
            "action" => url("usuario/novo")
        ]);

    }

    public function delete($data): void
    {
        $id=intval(filter_var($data["id"], FILTER_SANITIZE_NUMBER_INT));
        $modelo = (new LoginModel())->findById($id);
        $assinatiras = (new AssinaturaDisponivel())->find("id_usuario = :uid", "uid={$id}")->fetch(true);
        $assinatirasNodocumento = (new AssinaturaDocumento())->find("id_usuario = :uid", "uid={$id}")->fetch(true);

        if($assinatiras OR $assinatirasNodocumento){
            setMessage("warning", "Não foi possivel deletar pois esta em uso!");
        } else {
            $modelo->destroy();
            setMessage("info", "Usuário Deletado!");
        }
        $this->route->redirect("usuario");
    }
}