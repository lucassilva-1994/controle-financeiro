<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = "files";
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->bigInteger('sequence');
            $table->string('name',100);
            $table->string('path',200);
            $table->dateTime('created_at');
            $table->foreignUuid('release_id')->references('id')->on('releases')->onDelete('cascade');
            $table->foreignUuid('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
};
