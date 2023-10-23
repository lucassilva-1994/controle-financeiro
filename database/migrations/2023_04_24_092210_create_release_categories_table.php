<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = "releases_categories";
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->bigInteger('sequence');
            $table->foreignUuid('release_id')->references('id')->on('releases')->onDelete('cascade');
            $table->foreignUuid('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->dateTime('created_at');
        });
    }
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
};
