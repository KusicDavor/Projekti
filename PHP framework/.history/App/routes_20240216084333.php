<?php
use Classes\Route;
use Http\Router;

$router = new Router();
$router -> add

global $routes;
$routes = [];
$route = new Route('GET', '/login', Router::handle($request));
$route1 = new Route('POST', '/', Router::handle($request));

function getRoutes() {
    global $routes;
    return $routes;
}