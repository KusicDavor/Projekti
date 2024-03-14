<?php
namespace Controllers;
use Http\Response;
use Http\Request;
use Classes\JsonResponse;
use Interfaces\ResponseInterface;

class IndexController {
    public static function indexAction(Request $request) : ResponseInterface {
        var_dump($request);
        parse_str(Router::$request->getParameter("query"), $requestGET);
        
        $response = new Response(200, "OVO JE INDEX");
        $response->send();
        return $response;
    }

    public static function indexJsonAction(Request $request) : ResponseInterface {
        $data = ['data' => ['key' => 'value']];
        $response = new JsonResponse(200, $data);
        $response->send();
        return $response;
    }
}