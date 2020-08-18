<?php

namespace Source\App;

use CoffeeCode\DataLayer\Connect;
use CoffeeCode\Router\Router;
use League\Plates\Engine;
use Source\Models\ControleNumeroDocumento;
use Source\Support\Email;
use Source\Models\HistoricoDoc;
use Source\Models\LoginModel;
use Source\Models\Documentos;
use Source\Models\TipoDocModel;
use Source\Models\AssinaturaDisponivel;
use Source\Models\NumeracaoDoc;
use Source\Models\AssinaturaDocumento;
use Source\Models\TokenAssinatura;

class Documento
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
        $this->view->addFolder('view', __DIR__."/../views/Memo");
        $this->view->addData(["router" => $router]);
    }

    public function home(): void
    {
        $documentos = (new Documentos())->find()->fetch(true);
        if(!$documentos) $documentos = array();
        echo $this->view->render("view::lista",[
            "title" => "Documentos | ". SITE,
            "documentos" => $documentos
        ]);
    }

    public function pesquisa(): void
    {
        $pesquisa = filter_input(INPUT_POST, "pesquisa", FILTER_SANITIZE_STRIPPED);
        $connect = Connect::getInstance();
        $conn = $connect->query("SELECT id FROM mie_documentos WHERE 
            numeroDoc like '%{$pesquisa}%' OR
            anoDoc like '%{$pesquisa}%' OR
            assuntoDoc like '%{$pesquisa}%' OR
            destinatarioDoc like '%{$pesquisa}%' OR
            conteudoDoc like '%{$pesquisa}%'
        ");
        $ids = array();
        foreach ($conn->fetchAll() as $documento) $ids[] = $documento->id;
        $ids = "'". implode("','",$ids) . "'";
        $documentos = (new Documentos())->find("id IN ({$ids})")->fetch(true);

        setMessage("success", "Resultado da pesquisa do termo: {$pesquisa}");

        if(!$documentos) $documentos = array();
        echo $this->view->render("view::lista",[
            "title" => "Documentos | ". SITE,
            "documentos" => $documentos
        ]);
    }

    public function tipo($data): void
    {
        $id=intval(filter_var($data["id"], FILTER_SANITIZE_NUMBER_INT));
        $documentos = (new Documentos())->find("id_tipoDoc = :uid", "uid={$id}")->fetch(true);

        if(!$documentos) $documentos = array();

        echo $this->view->render("view::lista",[
            "title" => "Documentos | ". SITE,
            "documentos" => $documentos
        ]);
    }

    public function situacao($data): void
    {
        $id=intval(filter_var($data["id"], FILTER_SANITIZE_NUMBER_INT));
        $documentos = (new Documentos())->find("id_situacaoDoc = :uid", "uid={$id}")->fetch(true);

        if(!$documentos) $documentos = array();

        echo $this->view->render("view::lista",[
            "title" => "Documentos | ". SITE,
            "documentos" => $documentos
        ]);
    }

    public function new(): void
    {
        $documento = new Documentos();

        if ($_POST) {
            $documento->id_tipoDoc = filter_input(INPUT_POST, "id_tipoDoc", FILTER_SANITIZE_STRIPPED);
            $documento->assuntoDoc = filter_input(INPUT_POST, "assuntoDoc", FILTER_SANITIZE_STRIPPED);
            $documento->dataDoc = filter_input(INPUT_POST, "dataDoc", FILTER_SANITIZE_STRIPPED);
            $documento->destinatarioDoc = filter_input(INPUT_POST, "destinatarioDoc", FILTER_SANITIZE_STRIPPED);
            $documento->conteudoDoc = filter_input(INPUT_POST, "conteudoDoc", FILTER_SANITIZE_SPECIAL_CHARS);
            //$documento->conteudoDoc = $_POST["conteudoDoc"];
            $documento->anoDoc = date("Y", strtotime($documento->dataDoc));
            $documento->numeroDoc = "xxxx";
            $documento->chave = alfanumericoAleatorio(6);
            $documento->id_situacaoDoc = 1;
            $documento->save();
            /** Inserindo Historico */
            $this->insertHitorico($documento->id,"Criou o Documento: {$documento->tipoDoc()->nomeTipoDoc}             
                {$documento->numeroDoc}/{$documento->anoDoc}
             ");

            setMessage("success", "Documento Salvo");
            $this->route->redirect("documento/assinatura/{$documento->id}");
        }
        echo $this->view->render("view::new",[
            "title" => "Novo Documento | ". SITE,
            "documento" => $documento,
            "cardDocumento" => "",
            "titulo" => "Novo Documento",
            "subTitulo" => "Preencha os campos abaixo",
            "action" => "novo"
        ]);
    }

    public function show($data): void
    {
        $id=intval(filter_var($data["id"], FILTER_SANITIZE_NUMBER_INT));
        $memo = (new Documentos())->findById($id);
        $tipoDoc = (new TipoDocModel())->findById($memo->id_tipoDoc);
        echo $this->view->render("view::show",[
            "title" => "Ver Documento| ". SITE,
            "memo" => $memo,
            "tipoDoc" => $tipoDoc
        ]);
    }

    public function edit($data): void
    {
        $id=intval(filter_var($data["id"], FILTER_SANITIZE_NUMBER_INT));
        $documento = (new Documentos())->findById($id);
        if ($_POST) {
            $documento->id_tipoDoc = filter_input(INPUT_POST, "id_tipoDoc", FILTER_SANITIZE_STRIPPED);
            $documento->assuntoDoc = filter_input(INPUT_POST, "assuntoDoc", FILTER_SANITIZE_STRIPPED);
            $documento->dataDoc = filter_input(INPUT_POST, "dataDoc", FILTER_SANITIZE_STRIPPED);
            $documento->destinatarioDoc = filter_input(INPUT_POST, "destinatarioDoc", FILTER_SANITIZE_SPECIAL_CHARS);
            $documento->conteudoDoc = filter_input(INPUT_POST, "conteudoDoc", FILTER_SANITIZE_SPECIAL_CHARS);
            $documento->numeroDoc = filter_input(INPUT_POST, "numeroDoc", FILTER_SANITIZE_SPECIAL_CHARS);
            $documento->save();
            setMessage("success", "Documento Salvo");

            /** Inserindo Historico */
            $this->insertHitorico($documento->id,"Editou o Documento");

        }

        ob_start();
        require __DIR__. "/../../contents/cardDocumento.php";
        $cardDocumento = ob_get_clean();

        ob_start();
        require __DIR__. "/../../contents/navegacaoDocumento.php";
        $navegacao = ob_get_clean();

        echo $this->view->render("view::edit",[
            "title" => "Editar Documento | ". SITE,
            "documento" => $documento,
            "cardDocumento" => $navegacao.$cardDocumento,
            "titulo" => "Editar Documento",
            "subTitulo" => "Preencha os campos abaixo",
            "action" => "editar/{$id}"
        ]);
    }

    public function delete($id): void
    {
        $id = filter_var_array($id,FILTER_SANITIZE_NUMBER_INT);
        $id=intval($id["id"]);
        $newDoc = (new Documentos())->findById($id);
        /** Inserindo Historico */
        $this->insertHitorico($id,"Deletou o Documento id: {$id} - {$newDoc->numeroDoc}/{$newDoc->anoDoc} - {$newDoc->assuntoDoc} ");

        $newDoc->destroy();
        setMessage("info", "Documento 
            <strong>
                {$newDoc->tipoDoc()->nomeTipoDoc} 
                {$newDoc->numeroDoc}/{$newDoc->anoDoc} 
                {$newDoc->assuntoDoc}
            </strong> 
        Deletado!");

        $this->route->redirect("documento");
    }

    public function historico($id): void
    {
        $id=intval(filter_var($id["id"], FILTER_SANITIZE_NUMBER_INT));
        $documento = (new Documentos())->findById($id);
        $historicos = (new HistoricoDoc())->find("id_documento = :uid", "uid={$id}")->fetch(true);
        $historicos = (!$historicos) ? array() : $historicos;

        ob_start();
        require __DIR__. "/../../contents/cardDocumento.php";
        $cardDocumento = ob_get_clean();

        ob_start();
        require __DIR__. "/../../contents/navegacaoDocumento.php";
        $navegacao = ob_get_clean();

        echo $this->view->render("view::historicoDoc",[
            "title" => "Editar Documento | ". SITE,
            "documento" => $documento,
            "cardDocumento" => $navegacao.$cardDocumento,
            "historicos" => $historicos,
            "titulo" => "Histórico Documento",
            "subTitulo" => "Movimentações do documento",
        ]);
    }

    public function insertHitorico($idDocumento,$acao): void
    {
        $historico = new HistoricoDoc();
        $historico->id_memorando = $idDocumento;
        $historico->acao = $acao;
        $historico->id_usuario = $_SESSION["usuarioLogado"]["id"];
        $historico->save();
    }

    public function signature($id): void
    {
        $id=intval(filter_var($id["id"], FILTER_SANITIZE_NUMBER_INT));
        $documento = (new Documentos())->findById($id);
        /* Mostra somente as assinaturas Disponiveis para o usuario Desativado */
        //$assinaturasDiponiveis = (new AssinaturaDisponivel())->assinaturasUsuarioLogago();
        /* Mostra todas as asinturas Diponiveis */
        $assinaturasDiponiveis = (new AssinaturaDisponivel())->find()->fetch(true);

        ob_start();
        require __DIR__. "/../../contents/cardDocumento.php";
        $cardDocumento = ob_get_clean();

        ob_start();
        require __DIR__. "/../../contents/navegacaoDocumento.php";
        $navegacao = ob_get_clean();

        echo $this->view->render("view::signature",[
            "title" => "Assinar Documento | ". SITE,
            "documento" => $documento,
            "assinaturasDiponiveis" => $assinaturasDiponiveis,
            "assinaturasNoDocumento" => $documento->assinaturaNocumento(),
            "cardDocumento" => $navegacao.$cardDocumento,
            "titulo" => "Assinar Documento",
            "subTitulo" => "Necessário senha para assinar o documento",
        ]);
    }

    public function signatureAuth($id): void
    {
        $id=intval(filter_var($id["id"], FILTER_SANITIZE_NUMBER_INT));
        $id_assinaturaDisponivel = filter_input(INPUT_POST, "id_assinaturaDisponivel", FILTER_SANITIZE_STRIPPED);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRIPPED);

        $documento = (new Documentos())->findById($id);
        $usuarioLogado = (new LoginModel())->findById($_SESSION["usuarioLogado"]["id"]);
        $assinaturasDiponivel = new AssinaturaDisponivel();
        /* Mostra somente as assinaturas Disponiveis para o usuario Desativado */
        //$assinaturasDiponiveis = (new AssinaturaDisponivel())->assinaturasUsuarioLogago();
        /* Mostra todas as asinturas Diponiveis */
        $assinaturasDiponiveis = (new AssinaturaDisponivel())->find()->fetch(true);
        $dadosAssinaturaAtual = $assinaturasDiponivel->findById($id_assinaturaDisponivel);

        $error = false;

        if (!password_verify($password,$usuarioLogado->password)) {
            setMessage("danger", "Senha incorreta");
            $error = true;
        }

        if (arrayAssociativo("id_assinaturaDisponivel",$id_assinaturaDisponivel,$documento->assinaturaNocumento())) {
            setMessage("danger", "Já existe uma assinatura desse Tipo");
            $error = true;
        }

        /* Bloqueia que um usuario assine mais de uma vez*/
        /*if (arrayAssociativo("id_usuario",$_SESSION["usuarioLogado"]["id"],$documento->assinaturaNocumento())) {
            setMessage("danger", "Você ja assinou esse documento");
            $error = true;
        }*/

        /* Bloqueia o uso de assinaturas de outros usuarios*/
        /*if ($_SESSION["usuarioLogado"]["id"] <> $dadosAssinaturaAtual->id_usuario) {
            setMessage("danger", "Esse usuario não tem permissão de usar essa assinatura");
            $error = true;
        }*/

        if(!$error) {
            $usuarioLogado = (new LoginModel())->findById($_SESSION["usuarioLogado"]["id"]);
            $token = (new TokenAssinatura())->getToken($id_assinaturaDisponivel,$documento->id);
            $urlAtivacao = url("documento/assinatura/confimacao/{$documento->id}/{$token}");
            $envioEmail = new Email();
            $dataDocFormatada = formataData($documento->dataDoc);
            /*Para o fluxo de envio de email e faz a assinatura direto */
            $this->route->redirect("documento/assinatura/confimacao/{$documento->id}/{$token}");

            /* Desativado envio de email para solicitar assinatura*/
            /*$envioEmail->add(
                "Confirmação de Assinatura {$documento->tipoDoc()->nomeTipoDoc} N° {$documento->numeroDoc}/{$documento->anoDoc}",
                "<h1>Confirme a assinatura:</h1>
                       <p>{$documento->tipoDoc()->nomeTipoDoc} N° {$documento->numeroDoc}/{$documento->anoDoc}</p>
                       <p>Assunto: {$documento->assuntoDoc}</p>
                       <p>Data: {$dataDocFormatada}</p>
                       <p>Assinatura Eletrônica da transação: {$token}</p>
                       <p>Solicitado pelo Usuário: {$_SESSION["usuarioLogado"]["nome"]}</p>
                       <a href='{$urlAtivacao}'>Clique Aqui para confimar</a>",
                $usuarioLogado->nome,
                $usuarioLogado->email
            )->send();*/

            /** Inserindo Historico Desativado pois não éusado assinatura Eletronica*/
//            $this->insertHitorico($documento->id,"Solicitou confirmação de Assinatura: {$documento->tipoDoc()->nomeTipoDoc}
//                {$documento->numeroDoc}/{$documento->anoDoc} no e-mail: {$usuarioLogado->email}
//             ");

            if(!$envioEmail->error()){
                setMessage("success", "Enviado e-mail para confirmação de assinatura: 
                    <strong>{$usuarioLogado->email}</strong> verifique seu e-mail."
                );
            }  else {
                setMessage("danger", $envioEmail->error()->getMessage());
            }

        }

        ob_start();
        require __DIR__. "/../../contents/cardDocumento.php";
        $cardDocumento = ob_get_clean();

        ob_start();
        require __DIR__. "/../../contents/navegacaoDocumento.php";
        $navegacao = ob_get_clean();

        echo $this->view->render("view::signature",[
            "title" => "Assinar Documento | ". SITE,
            "documento" => $documento,
            "assinaturasDiponiveis" => $assinaturasDiponiveis,
            "assinaturasNoDocumento" => $documento->assinaturaNocumento(),
            "cardDocumento" => $navegacao.$cardDocumento,
            "titulo" => "Assinar Documento",
            "subTitulo" => "Necessário senha para assinar o memorando",
        ]);
    }

    public function confimSignature($dados): void
    {
        $id=intval(filter_var($dados["id"], FILTER_SANITIZE_NUMBER_INT));
        $idToken=filter_var($dados["idToken"], FILTER_SANITIZE_URL);
        $token = (new TokenAssinatura())->find("token = :uid", "uid={$idToken}")->fetch();
        $documento = (new Documentos())->findById($id);

        if(!$token){
            setMessage("danger","Confirmação não encontrada");
        } elseif ($token->id_usuario <> $_SESSION["usuarioLogado"]["id"]) {
            setMessage("danger","Este token não pertence a esse usuário");
        } else {
            $dadosAssinaturaAtual = (new AssinaturaDisponivel())->findById($token->id_assinaturaDisponivel);
            $documento->addAssinatura($id, $dadosAssinaturaAtual->id,$dadosAssinaturaAtual->nome,$dadosAssinaturaAtual->cargo,$token->token);

            /* Salva Numeração no documento */
            if ($documento->numeroDoc == "xxxx"){
                $numeracao = (new NumeracaoDoc())->getProximoNumeroDoc($documento->id_tipoDoc, $documento->anoDoc);
                $documento->numeroDoc = $numeracao;
                $documento->save();

                setMessage("success", "Documento Assinado: {$dadosAssinaturaAtual->nome} - {$dadosAssinaturaAtual->cargo}");
                $token->destroy();

                /* Inseri na lista de controle */
                $controle = new ControleNumeroDocumento();
                $controle->assuntoDoc = $documento->assuntoDoc;
                $controle->destinatarioDoc = $documento->destinatarioDoc;
                $controle->dataDoc =  $documento->dataDoc;
                $controle->id_tipoDoc = $documento->id_tipoDoc;
                $controle->anoDoc =  $documento->anoDoc;
                $controle->numeroDoc = $documento->numeroDoc;
                $controle->save();
            }


        }

        $this->route->redirect("documento/editar/{$id}");
    }

    public function deleteSignature($id): void
    {
        $idDocumento=intval(filter_var($id["idDocumento"], FILTER_SANITIZE_NUMBER_INT));
        $idAssinatura=intval(filter_var($id["idAssinatura"], FILTER_SANITIZE_NUMBER_INT));
        $assinatura = (new AssinaturaDocumento())->find("id = :uid", "uid={$idAssinatura}")
            ->find("id_documento = :uid", "uid={$idDocumento}")->fetch();

        if (!$assinatura) {
            setMessage("danger", "Erro ao deletar a assinatura");
        }else {
            /** Inserindo Historico */
            $this->insertHitorico($idDocumento,"Deletou a assinatura: {$assinatura->nome} - {$assinatura->cargo}");

            setMessage("success", "Assinatura deletada: {$assinatura->nome} - {$assinatura->cargo}");
            $assinatura->destroy();
        }

        $this->route->redirect("documento/assinatura/{$idDocumento}");
    }
}