<?php
namespace Http;
use Interfaces\ResponseInterface;
use Classes\Route;
class Router {
  private static $routes = [];
  private static $route;
  private static $request;
  private static $response;

  // metoda za dodavanje nove rute
  public function addRoutes(array $routes) {
    Router::$routes = $routes;
  }

  // metoda za resolvanje rute 
  public static function handleRequest(Request $request) {
    Router::$request = $request;
    $method = $request->getParameter('method');
    $url = $request->getParameter('url');

    foreach (Router::$routes as $route) {
      if (Router::matchRoute($url, $route) && $route->method === $method) {
        //Router::$route = $route;
        echo "tu sam";
        if(is_callable($route->callback)) {
          call_user_func($route->callback);
          return Router::$response;
        } else {
          $response = new Response(405, "Metoda ne postoji.");
          $response->send();
          return $response;
        }
      }        
    }
    $response = new Response(404, "Stranica ne postoji.");
    $response->send();
    return $response;
  }

  // za usporedbu url-a i definiranog url-a u ruti
  public static function matchRoute(string $url, Route $route): bool {
    $pattern = Router::buildPatternFromUrl($route->url);
    return preg_match($pattern, $url) === 1;
  }

  // za prepoznavanje s placeholderima
  private static function buildPatternFromUrl(string $url): string {
    return '#^' . preg_replace('#\{[^/]+\}#', '([^/]+)', $url) . '$#';
  }

  // sredi request ako je poslan GET metodom
  private function srediGETzahtjev() {
    parse_str(Router::$request->getParameter("query"), $requestGET);
    Router::$request = new Request($requestGET);
  }

  // vadi parametre iz requesta i vraća ih u stringu
  private function dohvatiParametreReq() : string {
    $ime = Router::$request->getParameter('ime');
    $spol = Router::$request->getParameter('spol');
    $dob = Router::$request->getParameter('dob');
    $content = "Ime: $ime<br>Spol: $spol<br>Dob: $dob<br>Osoba uspješno obrađena.";
    return $content;
  }

    // za putanju "/"
    public function default() {
      if (Router::$request->getParameter("method") == "GET") {
        $this->srediGETzahtjev();
      }
      Router::$response = new Response(200, $this->dohvatiParametreReq());
    }

  // za putanju "/osobe/{ime}
  public function prikaziOsobu() : ResponseInterface {
    $url = $_SERVER['REQUEST_URI'];
    $pattern = Router::buildPatternFromUrl(Router::$route->url);
    if (preg_match($pattern, $url, $matches)) {
        $parametarIme = $matches[1];
        if (Router::$request->getParameter("method") == "GET") {
          Router::srediGETzahtjev();
        }
        if (Router::$request->getParameter("ime") == $parametarIme) {
          $content = Router::dohvatiParametreReq();
        } else {
          $response = new Response(404, "Osoba ne postoji.");
          $response->send();
          return $response;
        }
      }

    $response = new Response(200, $content);
    $response->send();
    return $response;
  }
}