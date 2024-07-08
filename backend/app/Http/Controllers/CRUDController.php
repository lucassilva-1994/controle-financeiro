<?php

namespace App\Http\Controllers;

use App\Traits\ModelTrait;
use Illuminate\Support\Facades\DB;

class CRUDController extends Controller
{
    use ModelTrait;

    private $model;
    private $request;
    private $relationships;
    private $fields;
    private $withCount;
    private $withSum;

    public function __construct($model, $request, $relationships = [], $fields = [], $withCount = [], $withSum = [])
    {
        $this->model = $model;
        $this->request = $request;
        $this->relationships = $relationships;
        $this->fields = $fields;
        $this->withCount = $withCount;
        $this->withSum = $withSum;
    }

    public function show()
    {
        $query = $this->model::query();
        if (request()->has('search')) {
            $search = str_replace(',', '.', request()->search);
            $query->where(function ($query) use ($search) {
                foreach ($this->fields as $key => $value) {
                    if (is_array($value)) {
                        if (method_exists($this->model, $key)) {
                            $query->orWhereHas($key, function ($query) use ($search, $value) {
                                $query->where(function ($query) use ($search, $value) {
                                    foreach ($value as $property) {
                                        $query->orWhere($property, 'like', "%$search%");
                                    }
                                });
                            });
                        }
                    } else {
                        $query->orWhere($value, 'like', "%$search%");
                    }
                }
            });
        }
        if (!empty($this->withCount)) {
            $query->withCount($this->withCount);
        }
        if (!empty($this->withSum)) {
            foreach ($this->withSum as $relation => $column) {
                $query->withSum($relation, $column);
            }
        }
        return response()->json([
            'pages' => ceil($query->paginate()->total() / request()->query('perPage', 15)),
            'total' => $query->paginate()->total(),
            'itens' => $query->paginate(request()->query('perPage', 15))->load($this->relationships)
        ]);
    }

    public function showWithoutPagination()
    {
        $fields = request()->has('fields') ? explode(',', str_replace(["[", "]", "'", '"'], '', request()->fields)) : ['*'];
        $relationships = request()->has('relationships') ? explode(',', request()->relationships) : [];
        $query = $this->model::select($fields)->with($relationships);
        if (request()->has('additional_filter')) {
            $additionalFilter = request()->additional_filter;
            
            foreach ($additionalFilter as $condition) {
                $query->orWhere($condition[0], $condition[1], $condition[2]);
            }
        }
        return $query->orderBy('name', 'asc')->get();
    }

    public function showById(string $id)
    {
        return $this->model::findOrFail($id)->load($this->relationships);
    }

    public function store()
    {
        $data = self::createRecord($this->model, app($this->request)->all());
        if (app($this->request)->categories) {
            foreach (app($this->request)->categories as $category) {
                DB::table('category_financial_record')->insert([
                    'category_id' => $category,
                    'financial_record_id' => $data->getData()->data->id
                ]);
            }
        }
        return $data;
    }

    public function update(string $id)
    {
        $data = self::updateRecord($this->model, app($this->request)->all(), ['id' => $id]);
        if (app($this->request)->categories) {
            $existingCategories = DB::table('category_financial_record')
                ->where('financial_record_id', $id)
                ->pluck('category_id')
                ->toArray();
    
            $categoriesToRemove = array_diff($existingCategories, app($this->request)->categories);
            $categoriesToAdd = array_diff(app($this->request)->categories, $existingCategories);
            if ($categoriesToRemove) {
                DB::table('category_financial_record')
                    ->where('financial_record_id', $id)
                    ->whereIn('category_id', $categoriesToRemove)
                    ->delete();
            }
            foreach ($categoriesToAdd as $category) {
                DB::table('category_financial_record')->insert([
                    'category_id' => $category,
                    'financial_record_id' => $id
                ]);
            }
        }
        return $data;
    }
    

    public function delete(string $id)
    {
        return self::markAsDeleted($this->model, ['id' => $id]);
    }
}
