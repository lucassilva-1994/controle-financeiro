<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create("releases", function(Blueprint $table){
            $table->bigIncrements("id_release");
            $table->string("description", 255)->nullable(false);
            $table->longText('details')->nullable();
            $table->decimal("value",14,2);
            $table->date("date");
            $table->enum("type", ["RECEITA","DESPESA"]);
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("category_id");
            $table->enum("status", ["ATIVO", "INATIVO"])->default("ATIVO");
            $table->timestamps();
            $table->foreign("user_id")->references("id_user")->on("users")->onDelete("cascade");
            $table->foreign("category_id")->references("id_category")->on("categories")->onDelete("cascade");
        });
    }
    public function down()
    {
        Schema::dropIfExists("releases");
    }
};
