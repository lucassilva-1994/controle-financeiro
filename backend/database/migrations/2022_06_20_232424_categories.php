<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'categories';
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table){
            $table->uuid('id')->primary();
            $table->bigInteger('sequence');
            $table->string('name',100);
            $table->enum('type',['INCOME','EXPENSE','BOTH']);
            $table->dateTime('created_at');
            $table->foreignUuid('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->dateTime('updated_at')->nullable();
        });
    }
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
};
