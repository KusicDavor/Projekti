<?php
namespace Classes;
use Interfaces\ResponseInterface;
class JsonResponse implements ResponseInterface {
    private int $statusCode;
    private array $data;

    public function __construct(int $statusCode, array $data) {
        $this->statusCode = $statusCode;
        $this->data = $data;
    }

    public function send() {
        http_response_code($this->statusCode);
        header('Content-Type: application/json');
        echo json_encode($this->data);
    }
}