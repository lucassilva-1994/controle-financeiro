<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;

class CategoryController extends CRUDController
{
    public function __construct() {
        parent::__construct(
            Category::class, 
            CategoryRequest::class,
            ['user','logs'],
            ['name','type','description'],
            ['financialRecords'],
            ['financialRecords' => 'amount']);
    }

    public function showWithoutPagination()
    {
        if (request()->has('type')) {
            if (request()->type === 'EXPENSE') {
                request()->merge(['additional_filter' => [['type', '=', 'EXPENSE'], ['type', '=', 'BOTH']]]);
            } elseif (request()->type === 'INCOME') {
                request()->merge(['additional_filter' => [['type', '=', 'INCOME'], ['type', '=', 'BOTH']]]);
            }
        }
        return parent::showWithoutPagination();
    }
}
