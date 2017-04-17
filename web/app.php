<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Application\Application;
use Application\Config\Config;
use Application\Http\Request\Parameters\Files;
use Application\Http\Request\Parameters\Get;
use Application\Http\Request\Parameters\Headers;
use Application\Http\Request\Parameters\Post;
use Application\Http\Request\Parameters\Server;
use Application\Http\Request\Parameters\Session;
use Application\Http\Request\Request;
use Application\Router\Router;
use Application\ServiceContainer\ServiceContainer;

session_start();

$config = new Config(__DIR__ . "/../app/config/config.json");
$router = new Router(__DIR__ . "/../app/config/routes.json");

$app = new Application($config, $router);

$request = new Request(
    new Headers([
        'user-agent' => $_SERVER['HTTP_USER_AGENT'],
        'secure' => isset($_SERVER['HTTPS'])
    ]),
    new Server($_SERVER),
    new Session($_SESSION),
    new Post($_POST),
    new Get($_GET),
    new Files($_FILES)
);

$response = $app->launch($request);

echo $response->getMessage();
