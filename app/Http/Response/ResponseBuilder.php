<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ResponseBuilder{
    private int    $statusCode;
    private bool   $error;
    private string $message;
    private mixed  $data;

    public function __construct(){
        $this->statusCode = 400;
        $this->error = false;
        $this->message = "";
        $this->data = null;
    }

    public function status(int $statusCode, bool $error, $message): self{
        $this->statusCode = $statusCode;
        $this->error = $error;
        $this->message = $message;

        return $this;
    }

    public function data($data): self{
        $this->data = $data;

        return $this;
    }

    public function build(): JsonResponse{
        $responseObj = $this->getMessageObject();

        return response()->json($responseObj, $this->statusCode);
    }

    public function getMessageObject(): array{
        $response = [
            "status" => [
                "code"    => $this->statusCode,
                "error"   => $this->error,
                "message" => $this->message,
            ],
        ];
        if($this->data !== null){
            $response["data"] = $this->data;
        }

        return $response;
    }
}

