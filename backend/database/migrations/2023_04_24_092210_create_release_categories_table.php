<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'category_release';
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignUuid('release_id')->references('id')->on('releases')->cascadeOnDelete();
            $table->foreignUuid('category_id')->references('id')->on('categories')->cascadeOnDelete();
            $table->dateTime('created_at');
        });
    }
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
};
