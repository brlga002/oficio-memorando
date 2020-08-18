<?php

use Source\Models\ModeloDocumento;
use Source\Models\TipoDocModel;

session_cache_expire(60);
session_start();
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Manaus');

define("ROOT", "http://localhost/oficio-memorando");
define("SITE", "#Docs");
define("KEY", "#sgopkrweogkrwkgwrkgop");

define("MAIL", [
    "host" => "smtp.gmail.com",
    "port" => "587",
    "user" => "",
    "passwd" => '',
    "from_name" => "",
    "from_email" => ""
]);

define("DATA_LAYER_CONFIG_site", [
    "driver" => "mysql",
    "host" => "localhost",
    "port" => "3306",
    "dbname" => "docs",
    "username" => "root",
    "passwd" => "",
    "options" => [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ]
]);

/**
 * @param string|null $uri
 * @return string
 */
function url(string $uri = null): string
{
    if ($uri) {
        return ROOT . "/{$uri}";
    }
    return ROOT;
}

/**
 * $type :"success","info","warning","danger","primary","secondary","dark","light"
 */
function setMessage(string $type,string $text ): void
{
    $_SESSION["messages"][] = ["type"=>$type,"text"=>$text];
}

function getMessage(): array
{
    if (isset($_SESSION["messages"])){
        $messagens = $_SESSION["messages"];
        unset($_SESSION["messages"]);
        return $messagens;
    }
    return array();
}

function logonNecessario($route): void
{
    if (!isset($_SESSION["usuarioLogado"])){
        setMessage("warning", "Necessário está logado para acessar !");
        $route->redirect("login");
    }
}
function formataData($data): ?string
{
    $dataFormatada = "";
    if ($data != "") {
        $dataFormatada = date("d/m/Y", strtotime($data));
    }
    return $dataFormatada;
}

function formataDataHora($data): ?string
{
    $dataFormatada = "";
    if ($data != "") {
        $dataFormatada = date("d/m/y H:i:s", strtotime($data));
    }
    return $dataFormatada;
}

function arrayAssociativo (string $keyArray, string $valueFound, array $arrayAssociativo) {
    foreach($arrayAssociativo as $key => $assinatura) {
        if ($assinatura->$keyArray === $valueFound) {
            return true;
        }
    }
    return false;
}

function zeroEsquerda(int $numero,int $quantidade = 4) {
    $numeroFormatado = "";
    if ($numero != "") {
        $numeroFormatado = str_pad($numero, $quantidade, '0', STR_PAD_LEFT);
    }
    return $numeroFormatado;
}

function alfanumericoAleatorio(int $quantidade = 6) {
    $numero = "";
    for ($i = 1; $i <=$quantidade; $i++){
        if (mt_rand(1,10) > 5 ){
            $numero.= chr(mt_rand(65,90));
        } else {
            $numero.= mt_rand(1,9);
        }
    }
    return $numero;
}

function modeloDocumentos() {
    $modelos = (new ModeloDocumento())->find()->group("id_tipoDoc")->order("nomeModelo")->fetch(true);
    return (!$modelos) ? array() :$modelos;
}

function tipoDocumentos() {
    $modelos = (new TipoDocModel())->find()->order("nomeTipoDoc")->fetch(true);
    return (!$modelos) ? array() :$modelos;
}