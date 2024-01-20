<?php

namespace App\Observers;

use App\Helpers\Model;
use App\Models\{Category,Log};

class CategoryObserver
{
    use Model;
    /**
     * Handle the Category "created" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function created(Category $category)
    {
        self::setData([
            'entity' => 'Category',
            'new_values' => json_encode($category),
            'action' => 'create',
            'user_id' => $category->user_id,
        ],Log::class);
    }

    /**
     * Handle the Category "updated" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function updated(Category $category)
    {
        self::setData([
            'entity' => 'Category',
            'old_values' => json_encode($category->getOriginal()),
            'new_values' => json_encode($category),
            'action' => 'create',
            'user_id' => $category->user_id,
        ],Log::class);
    }

    /**
     * Handle the Category "deleted" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function deleted(Category $category)
    {
        self::setData([
            'entity' => 'Category',
            'old_values' => json_encode($category->getOriginal()),
            'new_values' => json_encode($category->getOriginal()),
            'action' => 'create',
            'user_id' => $category->user_id,
        ],Log::class);
    }

    /**
     * Handle the Category "restored" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function restored(Category $category)
    {
        //
    }

    /**
     * Handle the Category "force deleted" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function forceDeleted(Category $category)
    {
        //
    }
}
