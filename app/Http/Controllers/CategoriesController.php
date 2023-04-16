<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    private function categories(string $id= null){
        $category = Category::where('id',$id)->first();
        $categories = Category::where('user_id',session('user_id'))->latest('sequence')->get();
        return view('categories.categories',compact('categories','category'));
    }

    public function new(){
        return $this->categories();
    }

    public function edit(string $id){
        return $this->categories($id);
    }

    public function create(Request $request){
        return Category::createOrUpdate($request->except('token'));
    }

    public function update(Request $request){
        return Category::createOrUpdate($request->except('token'));
    }

    public function delete(string $id){
        return Category::deleteCategory($id);
    }
}
