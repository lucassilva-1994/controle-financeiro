<?php
namespace App\Helpers;

trait HelperMessage{
    private static function success($message = 'Operação realizada com sucesso.'){
        return response()->json(['message' => $message], 200);
    }

    private static function error($message = 'Falha ao realizar a operação.'){
        return response()->json(['message' => $message], 400);
    }
}