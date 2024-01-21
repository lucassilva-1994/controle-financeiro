<?php

namespace App\Http\Controllers;

use App\Helpers\{HelperModel,Messages};
use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoriesController extends Controller
{
    use HelperModel, Messages;
    public function index(){
        return Category::get();
    }

    public function show(string $id){
        if(Category::find($id)){
            return Category::find($id);
        }
        return $this->messageNotFound();
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

    public function delete(string $id){
        try {
            if(Category::find($id)->delete()){
                return $this->messageDeleted();
            }
        } catch (\Throwable $th) {
            return $this->messageFailed();
        }
    }
}
