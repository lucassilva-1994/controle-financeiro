<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create("users", function(Blueprint $table){
            $table->bigIncrements("id_user");
            $table->string("name",255)->nullable(false);
            $table->string("email",255)->unique()->nullable(false);
            $table->string("user", 50)->unique()->nullable(false);
            $table->string("password", 255)->nullable(false);
            $table->enum("status", ['ATIVO','INATIVO'])->default('INATIVO');
            $table->string("token");
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists("users");
    }
};
