<?php
namespace Routes;
use Classes\Route;
use Http\Router;

$routes = [];
$router = new Router();
$route = new Route('GET', '/', [Router::class, 'handleRequest']);


$router -> addRoutes($route);