<?php

namespace Source\App;

use League\Plates\Engine;
use Source\Models\AssinaturaDisponivel;
use Source\Models\Documentos;
use Source\Models\LoginModel;
use Source\Models\ModeloDocumento;
use Source\Models\TipoDocModel;

class App
{
    /** @var Engine */
    private $view;
    /** @var Router */
    private $route;

    public function __construct($router)
    {
        $this->view = Engine::create(__DIR__."/../../theme","php");
        $this->view->addFolder('dash', __DIR__."/../../theme/dash");
        $this->view->addData(["router" => $router]);
        $this->route = $router;
        logonNecessario($this->route);
    }

    public function home($data): void
    {
        $numedoDocumentos = (new Documentos())->find()->count();
        $numedoModelos= (new ModeloDocumento())->find()->count();
        $numedoAssinaturaPedente = (new Documentos())->find("id_situacaoDoc = :uid", "uid=1")->count();
        $numedoDocumentosAssinados = (new Documentos())->find("id_situacaoDoc = :uid", "uid=2")->count();
        $porcentagemAssinados = 0;
        if ($numedoDocumentosAssinados <> 0 and $numedoDocumentos <> 0){
            $porcentagemAssinados = intval($numedoDocumentosAssinados / ($numedoDocumentos / 100));
        }

        $assinaturas = (new AssinaturaDisponivel())->find()->fetch(true);
        $tipoDocumento = (new TipoDocModel())->find()->fetch(true);
        $linkADM = "";
        $usarioADM = (new LoginModel())->findById("1");
        if ($usarioADM->id == $_SESSION["usuarioLogado"]["id"]){
            $tempLink = url("usuario");
            $linkADM = "<a href='{$tempLink}' >Usuários</a>";
        }

        echo $this->view->render("dash::home",[
            "title" => "Home | ". SITE,
            "numedoDocumentos" => $numedoDocumentos,
            "numedoModelos" => $numedoModelos,
            "numedoAssinaturaPedente" => $numedoAssinaturaPedente,
            "porcentagemAssinados" => $porcentagemAssinados,
            "assinaturas" => $assinaturas,
            "tipoDocumento" => $tipoDocumento,
            "linkADM" => $linkADM,
        ]);
    }

    public function error(array $data): void
    {
        echo $this->view->render("dash::error",[
            "title" => "Error | ". SITE,
            "error" => $data["errcode"]
        ]);
    }
}