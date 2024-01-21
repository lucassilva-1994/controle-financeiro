<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'users';
    public function up()
    {
        Schema::create($this->table, function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->bigInteger('sequence');
            $table->string('name',100)->nullable(false);
            $table->string('email',100)->unique();
            $table->string('username', 50)->unique();
            $table->string('password', 60)->nullable();
            $table->boolean('active')->default(0);
            $table->uuid('token')->nullable();
            $table->dateTime('expires_token')->nullable();
            $table->string('photo',200)->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
        });
    }
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
};
