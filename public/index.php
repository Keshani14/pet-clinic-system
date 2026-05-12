<?php

// Start the session before any output or routing
session_start();

// Configuration
define('APP_DEBUG', true); // Toggle for development

if (APP_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

require_once "../core/Controller.php";
require_once "../core/Database.php";
require_once "../core/Auth.php";
require_once "../core/DbValidator.php";

// Run database health check
DbValidator::validate();

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

// The rest of the URL segments are parameters (e.g., admin/approve/5)
$params = array_slice($url, 2);

call_user_func_array([$controller, $method], $params);