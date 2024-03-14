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
  public static function handleRequest(Request $request) : ResponseInterface {
    Router::$request = $request;
    Router::$response = new Response(200, "");
    $method = $request->getParameter('method');
    $url = $request->getParameter('url');
    $postoji = 0;

    foreach (Router::$routes as $route) {
      if (Router::matchRoute($url, $route) && $route->method === $method) {
        Router::$route = $route;
        //if(is_callable($route->callback)) {
          $postoji = 1;
          var_dump($route->callback);
          echo  (__NAMESPACE__.'\\'.$route->callback->url);
          call_user_func( (__NAMESPACE__.'\\'.$route->callback), $request);
        // } else {
        //   $postoji = 2;
        //   Router::$response->setStatusCode(405);
        //   Router::$response->setContent("Metoda ne postoji.");
        // }
      }        
    }

    if ($postoji == 0) {
      Router::$response->setStatusCode(404);
      Router::$response->setContent("Stranica ne postoji.");
    }

    Router::$response->send();
    return Router::$response;
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
  private static function srediGETzahtjev() {
    parse_str(Router::$request->getParameter("query"), $requestGET);
    Router::$request = new Request($requestGET);
  }

  // vadi parametre iz requesta i vraća ih u stringu
  private static function dohvatiParametreReq() : string {
    $ime = Router::$request->getParameter('ime');
    $spol = Router::$request->getParameter('spol');
    $dob = Router::$request->getParameter('dob');
    $content = "Ime: $ime<br>Spol: $spol<br>Dob: $dob<br>Osoba uspješno obrađena.";
    return $content;
  }

    // za putanju "/"
    public static function default() {
      if (Router::$request->getParameter("method") == "GET") {
        Router::srediGETzahtjev();
      }
      Router::$response = new Response(200, Router::dohvatiParametreReq());
    }

  // za putanju "/osobe/{ime}
  public static function prikaziOsobu() {
    $url = $_SERVER['REQUEST_URI'];
    $pattern = Router::buildPatternFromUrl(Router::$route->url);
    Router::$response = new Response(200, "");
    if (preg_match($pattern, $url, $matches)) {
        $parametarIme = $matches[1];
        if (Router::$request->getParameter("method") == "GET") {
          Router::srediGETzahtjev();
        }
        if (Router::$request->getParameter("ime") == $parametarIme) {
          Router::$response->setContent(Router::dohvatiParametreReq());
        } else {
          Router::$response->setStatusCode(404);
          Router::$response->setContent("Osoba ne postoji.");
        }
      }
  }
}