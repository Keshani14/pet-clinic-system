<?php

require_once "../core/Controller.php";
require_once "../core/Database.php";

$url = $_GET['url'] ?? 'home/index';
$url = explode('/', $url);

$controllerName = ucfirst($url[0]) . "Controller";
$method = $url[1] ?? 'index';

require_once "../app/controllers/$controllerName.php";

$controller = new $controllerName();
$controller->$method();