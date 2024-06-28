<?php
namespace App\Helpers;

trait HelperMessage{
    private static function success($message = 'Operação realizada com sucesso.') {
        return ['message' => $message, 'status' => 200];
    }

    private static function error($message = 'Falha ao realizar a operação.') {
        return ['message' => $message, 'status' => 400];
    }
}