<?php

namespace App\Traits;

use function Pest\Laravel\json;

trait ApiResponses
{
    protected function ok($message,$data = []){
        return $this->success($message,$data);
    }
    protected function success($message, $data = [],$statusCode = 200){
        return response()->json([
            'data'=> $data,
            'message'=> $message,
            'status' => $statusCode
        ],$statusCode);
    }
    protected function error($message, $statusCode ){
        return response()->json([
            'message'=> $message,
            'status' => $statusCode
        ],$statusCode);
    }
}
