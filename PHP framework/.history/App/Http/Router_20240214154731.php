<?php
namespace Http;
use Classes\Route;
use Http\Request;
use Http\Response;
class Router {

  #[Route('/login', name: 'login')]
    public function login(): Response
    {
      $reponse = new Response();
      return 
    }

  protected $routes = [];
  public function addRoute(Route $route) {
    $this->routes[] = $route;
  }

  public function matchRoute() {
    $method = $_SERVER['REQUEST_METHOD'];
    $url = $_SERVER['REQUEST_URI'];
    if (isset($this->routes[$method])) {
        foreach ($this->routes[$method] as $routeUrl => $target) {
            // Simple string comparison to see if the route URL matches the requested URL
            if ($routeUrl === $url) {
                call_user_func($target);
            }
        }
    }
}

  public function handleRequest(Request $request)
    {
      $ime = $request->getParam('ime');
      $spol = $request->getParam('spol');
      $dob = $request->getParam('dob');
      $httpKod = 200;

      if ($spol == "M") {
        $spol = "Muškarac";
      }

      if ($dob < 18) {
        $poruka = "Osoba je maloljetna. Nije moguće obraditi osobu.";
        $httpKod = 409;
      } else {
        $poruka = "Osoba: $ime<br>Spol: $spol<br>Dob: $dob<br>Osoba uspješno obrađena.";
        $httpKod = 201;
      }
      $this->vratiPoruku($poruka, $httpKod);
  }

  private function vratiPoruku($poruka, $httpKod) {
    $response = new Response();
    $htmlContent = file_get_contents('Resources/views/poruka.html');
    $htmlContent = str_replace('$poruka', "<p>$poruka</p>", $htmlContent);
    return $response->send($httpKod, $htmlContent, "text/html");
  }
}