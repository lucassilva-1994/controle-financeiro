<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Helpers\Model;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    use Model;
    use Helper;
    private function categories(string $id = null)
    {
        $category = Category::whereId($id)->first();
        //Retornando a soma dos valores do lançamentos vinculado a cada categoria.
        //Ordenando as categorias das que tem mais lançamentos para menos lançamentos.
        $categories = Category::with('releases')->withSum('releases','value')->withCount('releases')->orderBy('releases_count','DESC')->whereUserId($this->id())->get();
        return view('dashboard.categories', compact('categories', 'category'));
    }

    public function new()
    {
        return $this->categories();
    }

    public function edit(string $id)
    {
        return $this->categories($id);
    }

    public function create(Request $request)
    {
        $request->validate(['name' => 'required']);
        if (self::setData($request->except('_token'),Category::class)) {
            return self::redirect('success','criado');
        }
        return self::redirect('error','criar');
    }

    public function update(Request $request)
    {
        if (self::updateData($request->except('id','_token', '_method'),Category::class,['id' => $request->id]))
            return self::redirect('success','atualizado');
        return self::redirect('error','atualizar');
    }

    public function delete(string $id)
    {
        if (Category::find($id)->delete()){
            return self::redirect('success','excluido');
        }
        return self::redirect('error','excluir');
    }

    private function id()
    {
        return auth()->user()->id;
    }
}
