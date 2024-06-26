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
            ['user'],
            ['name','type','description'],
            ['financialRecords'],
            ['financialRecords' => 'amount']);
    }
}
