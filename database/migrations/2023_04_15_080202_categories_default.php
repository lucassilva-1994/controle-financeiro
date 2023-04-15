<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = "categories_default";
    public function up()
    {
        Schema::create($this->table, function(Blueprint $table){
            $table->string("name");
            $table->enum("type",["ENTRADA","SAIDA","AMBOS"]);
        });
    }
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
};
