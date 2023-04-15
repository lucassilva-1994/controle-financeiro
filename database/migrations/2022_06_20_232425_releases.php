<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create("releases", function(Blueprint $table){
            $table->uuid("id")->primary();
            $table->bigInteger("sequence");
            $table->string("description", 255);
            $table->longText('details')->nullable();
            $table->decimal("value",14,2);
            $table->date("date");
            $table->enum("type", ["RECEITA","DESPESA"]);
            $table->boolean("is_active")->default(0);
            $table->dateTime("created_at");
            $table->dateTime("updated_at");
            $table->foreignUuid("user_id")->references("id")->on("users")->onDelete("cascade");
            $table->foreignUuid("category_id")->references("id")->on("categories")->onDelete("cascade");
        });
    }
    public function down()
    {
        Schema::dropIfExists("releases");
    }
};
