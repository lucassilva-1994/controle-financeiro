<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    public function delete(string $id){
        $file = File::find($id);
        Storage::delete($file->path);
        $file->delete();
        return redirect()->back()->with('success','Excluido com sucesso.');
    }

    public function download(string $id){
        $file = File::find($id);
        return Storage::download($file->path,$file->name);
    }
}
