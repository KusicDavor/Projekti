<?php
namespace Controllers;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class KorisnikController {
    public static function index() {
        $loader = new FilesystemLoader('Resources/views/');
        $twig = new Environment($loader);
        $twig->render('kreiranjeKorisnika.html.twig');
    }
}