<?php

namespace App\Http\Controllers;

use App\Helpers\HelperModel;

class CRUDController extends Controller
{
    use HelperModel;

    private $model;
    private $request;
    private $relationships;
    private $fields;

    public function __construct($model, $request, $relationships = [], $fields = []) {
        $this->model = $model;
        $this->request = $request;
        $this->relationships = $relationships;
        $this->fields = $fields;
    }

    public function show(){
        $query = $this->model::query();
        if(request()->has('search')){
            $search = request()->search;
            foreach($this->fields as $field){
                $query->orWhere($field,'like', "%$search%");
            }
        }
        return response()->json([
            'pages' => ceil($query->paginate()->total() / request()->query('perPage', 15)),
            'total' => $query->paginate()->total(),
            'itens' => $query->paginate(request()->query('perPage', 15))->load($this->relationships)
        ]);
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
