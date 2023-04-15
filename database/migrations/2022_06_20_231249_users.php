<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = "users";
    public function up()
    {
        Schema::create($this->table, function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->bigInteger('sequence');
            $table->string("name",255)->nullable(false);
            $table->string("email",255)->unique();
            $table->string("user", 50)->unique();
            $table->string("password", 100);
            $table->boolean('is_active')->default(0);
            $table->uuid("token")->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
};
