<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'category_financial_record';
    public function up(): void
    {
       Schema::create($this->table, function(Blueprint $table){
            $table->foreignUuid('financial_record_id')->references('id')->on('financial_records');
            $table->foreignUuid('category_id')->references('id')->on('categories');
       });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
};
