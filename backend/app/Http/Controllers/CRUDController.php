<?php

namespace App\Http\Controllers;

use App\Helpers\HelperModel;

class CRUDController extends Controller
{
    use HelperModel;

    private $model;
    private $request;
    private $relationships;

    public function __construct($model, $request, $relationships = []) {
        $this->model = $model;
        $this->request = $request;
        $this->relationships = $relationships;
    }

    public function show(){
        return $this->model::get()->load($this->relationships);
    }

    public function showById(string $id){
        return $this->model::findOrFail($id)->load($this->relationships);
    }

    public function store(){
        return self::createRecord($this->model,app($this->request)->all());
    }

    public function update(string $id){
        return self::updateRecord($this->model, app($this->request)->all(),['id' => $id]);
    }

    public function delete(string $id){
        return self::markAsDeleted($this->model, ['id' => $id]);
    }
}
