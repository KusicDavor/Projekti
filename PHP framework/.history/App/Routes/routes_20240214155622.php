<?php
namespace Routes;
use Classes\Route;
use Http\Router;

$router = new Router();

$router->addRoute('GET', '/blogs', function () {
    echo "My route is working!";
    exit;
});

$router->matchRoute();