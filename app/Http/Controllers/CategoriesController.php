<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    private function categories(string $id= null){
        $category = Category::where('id',$id)->first();
        $categories = Category::where('user_id',session('user_id'))->latest('sequence')->get();
        return view('dashboard.categories',compact('categories','category'));
    }

    public function new(){
        return $this->categories();
    }

    public function edit(string $id){
        return $this->categories($id);
    }

    public function create(Request $request){
        $request->validate(['name'=>'required','type'=>'required'],
        ['name.required' => 'Nome é obrigatório','type.required'=>'Tipo é obrigatório.']);
        if(Category::createOrUpdate($request->except('_token'))):
            return redirect()->back()->with('success','Categoria cadastrada com sucesso.');
        else:
            return redirect()->back()->with('error','Falha ao cadastrar categoria');
        endif;
    }

    public function update(Request $request){
        if(Category::createOrUpdate($request->except('_token','_method'))):
            return redirect()->back()->with('success','Categoria atualizada com sucesso.');
        else:
            return redirect()->back()->with('error','Falha  ao atualizar categoria.');
        endif;
    }

    public function delete(string $id){
        if(Category::deleteCategory($id)):
            return redirect()->back()->with('success','Registro removido com sucesso.');
        else:
            return redirect()->back()->with('error','Falha ao remover registro.');
        endif;
    }
}
