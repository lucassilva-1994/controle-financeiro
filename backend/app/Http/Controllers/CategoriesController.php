<?php

namespace App\Http\Controllers;

use App\Helpers\{HelperModel,Messages};
use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoriesController extends Controller
{
    use HelperModel, Messages;
    public function index(){
        return Category::with('user','releases')->get();
    }

    public function show(Category $category){
        try {
            return $category->load('user','releases')->setHidden(['user_id']);
        } catch (\Throwable $th) {
            return $this->messageNotFound();
        }
    }

    public function create(CategoryRequest $request){
        try {
            self::setData($request->all(), Category::class);
            return $this->messageSuccess();
        } catch (\Throwable $th) {
            return $this->messageFailed();
        }
    }

    public function update(CategoryRequest $request){
        try {
            self::updateData($request->only('name','type'), Category::class,['id' => $request->id]);
            return $this->messageSuccess();
        } catch (\Throwable $th) {
            return $this->messageFailed();
        }
    }

    public function delete(Category $category){
        try {
            if($category->delete()){
                return $this->messageDeleted();
            }
        } catch (\Throwable $th) {
            return $this->messageFailed();
        }
    }
}
