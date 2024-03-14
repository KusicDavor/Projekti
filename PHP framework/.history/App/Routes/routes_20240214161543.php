<?php
namespace Routes;
use Http\Request;
use Http\Router;
use Classes\Route;

$router = new Router();

$router->addRoute('GET', '/blogs', function () {
    $r = new Router();
    $r->vratiPoruku("ovo radi", 200)
    echo "My route is working!";
    exit;
});

$router->addRoute('GET', '/', function () {
    $request = new Request($_REQUEST);
    $this->handleRequest($request);
    exit;
});


$router->matchRoute();