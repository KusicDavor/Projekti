<?php
namespace Controllers;
use Exception;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Http\Response;
use Interfaces\ResponseInterface;
use Database\Connection;
use Http\Request;
use Classes\User;
use TypeError;

class UserController {

    // glavna stranica, vraća popis korisnika
    public static function index(Request $request) : ResponseInterface {
        $loader = new FilesystemLoader('Resources/views/');
        $twig = new Environment($loader);
        $response = new Response(200, "");

        // osigurava da se nakon brisanja prikaže /users, a ne IndexController metoda
        $url_parts = parse_url($_SERVER['REQUEST_URI']);
        $path = $url_parts['path'];
        if (strpos($path, 'delete') == false) {
            $id = $request->getParameter("id");
            if (isset($id)) {
                try {
                    return IndexController::indexAction($request);
                } catch (Exception $e) {
                    $response->setContent($e->getMessage());
                    return $response;
                }
            }
        }

        $limit = $request->getParameter("limit");
        $limit = isset($limit) && is_numeric($limit) ? (int) $limit : 5;
        $users = self::returnAllResults($limit);
        $htmlContent = $twig->render('users.html.twig', ['users' => $users]);
        $response->setContent($htmlContent);
        return $response;
    }

    //vrati sve korisnike kao JSON response
    public static function returnJsonUsers(Request $request) : ResponseInterface {
        return IndexController::indexJsonAction($request);
    }

    // prikazuje 
    public static function showUserDetail(Request $request) : ResponseInterface {
        $loader = new FilesystemLoader('Resources/views/');
        $twig = new Environment($loader);
        $htmlContent = $twig->render('korisnikGreska.html.twig');
        $response = new Response(404, $htmlContent);

        $url = $_SERVER['REQUEST_URI'];
        $pattern = "/\/users\/(\d+)/";

        if (preg_match($pattern, $url, $matches)) {
            $id = $matches[1];
            $user = self::returnSingleResult($id);
            
            if (!empty($user)) {
                $response->setStatusCode(200);
                $htmlContent = $twig->render('user.html.twig', ['user' => $user]);
            }
        }
        
        $response->setContent($htmlContent);
        return $response;
    }

    public static function deleteKorisnika(Request $request) : ResponseInterface {
        $id = $request->getParameter('id');
        $user = User::find($id);
        $user->attributes = ['id' => $id];
        $user->delete();
        return self::index($request);
    }
    
    public static function createKorisnika() : ResponseInterface {
        $loader = new FilesystemLoader('Resources/views/');
        $twig = new Environment($loader);
        $response = new Response(200, "");
        $htmlContent = $twig->render('kreiranjeKorisnika.html.twig');
        $response->setContent($htmlContent);
        return $response;
    }

    public static function saveKorisnika(Request $request) : ResponseInterface {
        $connection = Connection::getInstance();
        $connection->connect();
        $ime = $request->getParameter('ime');
        $spol = $request->getParameter('spol');
        $dob =  $request->getParameter('dob');
        $user = new User($ime, $spol, $dob);
        $user->save();
        return self::index($request);
     }

    public static function returnSingleResult(int $id) {
        $connection = Connection::getInstance();
        $connection->connect();
        $query = "SELECT * FROM users WHERE id = :value";
        $params = [':value' => $id];
        $user = $connection->fetchAssoc($query, $params);
        return $user;
     }
    
     public static function returnAllResults(?int $limit = null) {
        $connection = Connection::getInstance();
        $connection->connect();
        $query = "SELECT * FROM users WHERE deleted_at IS NULL";
        $users = $connection->fetchAssocAll($query, $limit);
        return $users;
    }
}