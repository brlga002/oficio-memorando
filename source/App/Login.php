<?php

namespace Source\App;

use CoffeeCode\Router\Router;
use League\Plates\Engine;
use \Source\Models\LoginModel;
use Source\Support\Email;

class Login
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
    }

    public function show(): void
    {
        echo $this->view->render("dash::login",[
            "title" => "Login | ". SITE,
            "email" => ""
        ]);
    }

    public function logout(): void
    {
        session_destroy();
        $this->route->redirect("login");
    }

    public function changePassword(): void
    {
        logonNecessario($this->route);

       if ($_POST) {
           $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRIPPED);
           $newPassword = filter_input(INPUT_POST, "newPassword", FILTER_SANITIZE_STRIPPED);
           $usuarioLogado = (new LoginModel())->findById($_SESSION["usuarioLogado"]["id"]);

           if (!password_verify($password,$usuarioLogado->password)) {
               setMessage("danger", "Erro de senha");
           } else {
                   $usuarioLogado->password = password_hash($newPassword, PASSWORD_DEFAULT);
                   $usuarioLogado->save();
                   setMessage("success", "Sua senha foi alterada");
                   $this->route->redirect("/");
           }
       }

        echo $this->view->render("dash::change_password",[
            "title" => "Login | ". SITE,
        ]);
    }

    public function auth(): void
    {
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRIPPED);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRIPPED);
        $usuarioLogado = (new LoginModel())->find("email = :uid", "uid={$email}")->fetch(false);
        if (!$usuarioLogado){
            setMessage("danger", "Não encontrado o email {$email}");
        } else {
            if (!password_verify($password,$usuarioLogado->password)) {
                setMessage("danger", "Erro de senha");
            }else {
                setMessage("success", "Bem vindo Novamente {$usuarioLogado->nome}");
                $_SESSION["usuarioLogado"] = [
                    "id"=>$usuarioLogado->id, "nome"=>$usuarioLogado->nome
                ];
                $this->route->redirect("/");
            }
        }

        echo $this->view->render("dash::login",[
            "title" => "Login | ". SITE,
            "email" => $email
        ]);
    }

    public function forgotPassword(): void
    {
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_STRIPPED);
        if ($_POST){
            $usuarioLogado = (new LoginModel())->find("email = :uid", "uid={$email}")->fetch(false);
            if (!$usuarioLogado){
                setMessage("danger", "Não encontrado o email {$email}");
            } else {
                $novaSenha = chr(rand(99, 122)).rand(10, 99).chr(rand(99, 122)).rand(12, 99);
                $usuarioLogado->password = password_hash($novaSenha, PASSWORD_DEFAULT);
                $usuarioLogado->save();

                $envioEmail = new Email();
                $envioEmail->add(
                    "E-mail de recuperação de Senha",
                    "<h1>Redefinição de senha solicitada:</h1><p>Segue sua nova senha: <strong>{$novaSenha}</strong></p></p>",
                    $usuarioLogado->nome,
                    $email
                )->send();

                if(!$envioEmail->error()){
                    setMessage("success", "Enviado e-mail de recuperação para: <strong>{$email}</strong> verifique seu e-mail.");
                    $email = "";
                }  else {
                    setMessage("danger", $envioEmail->error()->getMessage());
                }
            }
        }

        echo $this->view->render("dash::forgot_password",[
            "title" => "Login | ". SITE,
            "email" => $email
        ]);
    }


}