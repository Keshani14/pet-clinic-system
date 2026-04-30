<?php

// Start the session before any output or routing
session_start();

require_once "../core/Controller.php";
require_once "../core/Database.php";
require_once "../core/Auth.php";          // RBAC helper — available to all controllers

$url = $_GET['url'] ?? 'home/index';
$url = explode('/', $url);

$controllerName = ucfirst($url[0]) . "Controller";
$method         = $url[1] ?? 'index';

$controllerFile = "../app/controllers/$controllerName.php";

if (!file_exists($controllerFile)) {
    http_response_code(404);
    die("<h2>404 — Page not found.</h2>");
}

require_once $controllerFile;

if (!method_exists($controllerName, $method)) {
    http_response_code(404);
    die("<h2>404 — Action not found.</h2>");
}

$controller = new $controllerName();
$controller->$method();