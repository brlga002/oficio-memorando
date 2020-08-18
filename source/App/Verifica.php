<?php

namespace Source\App;

use League\Plates\Engine;
use Source\Models\Documentos;


class Verifica
{
    /** @var Engine */
    private $view;
    /** @var Router */
    private $route;

    public function __construct($router)
    {
        $this->view = Engine::create(__DIR__."/../../theme","php");
        $this->view->addFolder('dash', __DIR__."/../../theme/dash");
        $this->view->addFolder('verifica', __DIR__."/../views/Verifica");
        $this->view->addData(["router" => $router]);
        $this->route = $router;
        //logonNecessario($this->route);
    }

    public function home($data): void
    {
        $id=intval(filter_var($data["id"], FILTER_SANITIZE_NUMBER_INT));
        $memorando = (new Documentos())->findById($id);

        if(!$memorando){
            setMessage("danger", "Documento {$id} não encontrado");
        } else {
            if ($_POST) {
                $chave = filter_input(INPUT_POST, "chave", FILTER_SANITIZE_STRIPPED);
                if ($memorando->chave === $chave){
                    setMessage("success", "A chave do documento está correta");
                    $this->route->redirect("exibir/documento/{$memorando->id}");
                } else {
                    setMessage("danger", "A chave digitada não confere com a chave do documento");
                }
            }
        }

        echo $this->view->render("dash::verificaAutenticidadeDocumento",[
            "title" => "Verificar Documento | ". SITE,
            "memorando" => $memorando,
            "cardMemorando" => "",
            "action" => "novo"
        ]);
    }

    public function show($data): void
    {
        $id=intval(filter_var($data["id"], FILTER_SANITIZE_NUMBER_INT));
        $memorando = (new Documentos())->findById($id);

        if(!$memorando){
            setMessage("danger", "Documento {$id} não encontrado");
        } else {
            if ($_POST) {
                $chave = filter_input(INPUT_POST, "chave", FILTER_SANITIZE_STRIPPED);
                if ($memorando->chave === $chave) {
                    setMessage("success", "A chave do documento está correta");
                } else {
                    setMessage("danger", "A chave digitada não confere com a chave do documento");
                }
            }
        }

        echo $this->view->render("dash::mostraDocumento",[
            "title" => "Verificar Documento | ". SITE,
            "memorando" => $memorando,
            "cardMemorando" => "",
            "action" => "novo"
        ]);
    }



}