<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'logs';
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('sequence');
            $table->string('entity');
            $table->longText('old_values')->nullable();
            $table->longText('new_values')->nullable();
            $table->string('action');
            $table->dateTime('created_at');
            $table->foreignUuid('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
};
