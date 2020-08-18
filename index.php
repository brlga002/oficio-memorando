<?php
use \CoffeeCode\Router\Router;
require __DIR__ . "/vendor/autoload.php";

$route = new Router(ROOT);

$route->namespace("Source\App");

$route->group(null);
    $route->get("/", "App:home");

/* Error */
$route->group("ops");
    $route->get("/{errcode}", "App:error");

/* Login */
$route->group("login");
    $route->get("/", "Login:show");
    $route->post("/", "Login:auth");
    $route->get("/logout", "Login:logout");
    $route->get("/muda", "Login:changePassword");
    $route->post("/muda", "Login:changePassword");
    $route->get("/recupera", "Login:forgotPassword");
    $route->post("/recupera", "Login:forgotPassword");

/* Docuemntos */
$route->group("documento");
    /* Listagens */
    $route->get("/", "Documento:home");
    $route->post("/", "Documento:pesquisa");
    $route->get("/tipo/{id}", "Documento:tipo");
    $route->get("/situacao/{id}", "Documento:situacao");
    /* Novo */
    $route->get("/novo", "Documento:new");
    $route->post("/novo", "Documento:new","Documento.new");
    /* Mostra */
    $route->get("/show/{id}", "Documento:show","Documento.show");
    /* Editar */
    $route->get("/editar/{id}", "Documento:edit","Documento.edit");
    $route->post("/editar/{id}", "Documento:edit","Documento.edit");
    /* Deletar */
    $route->get("/deletar/{id}", "Documento:delete");
    /* Historico Documento */
    $route->get("/historico/{id}", "Documento:historico");
    /* Assinatura */
    $route->get("/assinatura/{id}", "Documento:signature");
    $route->post("/assinatura/{id}", "Documento:signatureAuth");
    $route->get("/assinatura/confimacao/{id}/{idToken}", "Documento:confimSignature");
    $route->get("/assinatura/deletar/{idDocumento}/{idAssinatura}","Documento:deleteSignature");


/* Modelo Memorando */
$route->group("modelos");
    $route->get("/", "Modelo:home");
    $route->get("/{id}", "Modelo:home");
    $route->get("/modelo/{id}", "Modelo:show");
    $route->get("/modelo/novo", "Modelo:new");
    $route->post("/modelo/novo", "Modelo:new");
    $route->get("/modelo/deletar/{id}", "Modelo:delete");
    $route->get("/modelo/editar/{id}", "Modelo:edit");
    $route->post("/modelo/editar/{id}", "Modelo:edit");

/* Assinaturas */
$route->group("assinaturas");
$route->get("/", "Assinatura:home");
$route->get("/novo", "Assinatura:new");
$route->post("/novo", "Assinatura:new");
$route->get("/deletar/{id}", "Assinatura:delete");
$route->get("/editar/{id}", "Assinatura:edit");
$route->post("/editar/{id}", "Assinatura:edit");

/* Tipo Documento */
$route->group("tipoDocumento");
$route->get("/", "TipoDocumento:home");
$route->get("/novo", "TipoDocumento:new");
$route->post("/novo", "TipoDocumento:new");
$route->get("/deletar/{id}", "TipoDocumento:delete");
$route->get("/editar/{id}", "TipoDocumento:edit");
$route->post("/editar/{id}", "TipoDocumento:edit");

/* usuarios */
$route->group("usuario");
$route->get("/", "Usuario:home");
$route->get("/novo", "Usuario:new");
$route->post("/novo", "Usuario:new");
$route->get("/deletar/{id}", "Usuario:delete");
$route->get("/editar/{id}", "Usuario:edit");
$route->post("/editar/{id}", "Usuario:edit");

/* Controle Numeração Documento */
$route->group("controle");
$route->get("/", "ControleNumeracao:home");
$route->get("/novo", "ControleNumeracao:new");
$route->post("/novo", "ControleNumeracao:new");
$route->get("/deletar/{id}", "ControleNumeracao:delete");
$route->get("/editar/{id}", "ControleNumeracao:edit");
$route->post("/editar/{id}", "ControleNumeracao:edit");


/* Verifica Documento */
$route->group("verifica");
    $route->get("/documento/{id}", "Verifica:home");
    $route->post("/documento/{id}", "Verifica:home");
    $route->get("/exibir/documento/{id}", "Verifica:show");

$route->dispatch();

if ($route->error()) {
    $route->redirect("/ops/{$route->error()}");
}