<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'creditorsclients';
    public function up()
    {
        Schema::create($this->table, function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->bigInteger('sequence');
            $table->string('name');
            $table->enum('type',['CLIENTE','FORNECEDOR','AMBOS']);
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->foreignUuid('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
};
