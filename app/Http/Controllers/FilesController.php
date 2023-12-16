<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\File;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    use Helper;
    public function delete(string $id){
        $file = File::find($id);
        Storage::delete($file->path);
        $file->delete();
        return self::redirect('success','excluido');
    }

    public function download(string $id){
        $file = File::find($id);
        return Storage::download($file->path,$file->name);
    }
}
