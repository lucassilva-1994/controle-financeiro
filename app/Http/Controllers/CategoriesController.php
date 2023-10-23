<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    private function categories(string $id = null)
    {
        $category = Category::whereId($id)->first();
        $categories = Category::whereUserId($this->id())->get();
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

    private function redirect($session, $message){
        return redirect()->back()->with($session,$message);
    }

    public function create(Request $request)
    {
        $request->validate(
            ['name' => 'required', 'type' => 'required'],
            ['name.required' => 'Nome é obrigatório', 'type.required' => 'Tipo é obrigatório.']
        );
        if (Category::createOrUpdate($request->except('_token'))) {
            return $this->redirect('success','Categoria cadastrada com sucesso.');
        }
        return $this->redirect('error', 'Falha ao cadastrar categoria');
    }

    public function update(Request $request)
    {
        if (Category::createOrUpdate($request->except('_token', '_method'))){
            return $this->redirect('success','Categoria atualizada com sucesso.');
        }
        return $this->redirect('error','Falha  ao atualizar categoria.');
    }

    public function delete(string $id)
    {
        if (Category::forDelete($id)){
            return $this->redirect('success','Registro removido com sucesso.');
        }
        return $this->redirect('error','Falha ao remover registro.');
    }

    private function id()
    {
        return auth()->user()->id;
    }
}
