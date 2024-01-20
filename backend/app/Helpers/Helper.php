<?php
namespace App\Helpers;
trait Helper{
    public static function formatCurrency($value)
    {
        $value = str_replace(['R$ ', '.', ','], ['', '', '.'], $value);
        $value = number_format('' . $value, 2, '.', '');
        return $value;
    }
    
    private static function redirect($class = 'success', $event=null){
        if($class == 'success')
            return redirect()->back()->with('success',"Registro {$event} com sucesso.");
        return redirect()->back()->with('error',"Falha ao {$event} registro.");
    }
} 