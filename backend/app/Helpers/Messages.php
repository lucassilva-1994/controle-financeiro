<?php
namespace App\Helpers;
trait Messages{
    public static function formatCurrency($value)
    {
        $value = str_replace(['R$ ', '.', ','], ['', '', '.'], $value);
        $value = number_format('' . $value, 2, '.', '');
        return $value;
    }

    public function messageSuccess(){
        return response()->json('Operação realizado com sucesso.');
    }

    public function messageNotFound(){
        return response()->json('Registro não encontrado.');
    }

    public function messageDeleted(){
        return response()->json('Registro excluido com sucesso.');
    }

    public function messageFailed(){
        return response()->json('Falha ao realizar a operação.');
    }
} 