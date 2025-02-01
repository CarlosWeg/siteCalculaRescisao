<?php

if (session_status() !== PHP_SESSION_ACTIVE){
    session_start();
}

// Exibição de erros, tirar em produção
error_reporting(E_ALL);
ini_set('display_errors',1);

require_once 'vendor/autoload.php';

use Core\Router;
$oRouter = new Router();

require_once 'routes/web.php';

$sMetodo = $_SERVER['REQUEST_METHOD'];
$sUri = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);

$oRouter -> resolver($sMetodo,$sUri);