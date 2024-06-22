<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'payments';
    public function up(): void
    {
       Schema::create($this->table, function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->integer('sequence');
            $table->string('name',40);
            $table->enum('type',['INCOME','EXPENSE','BOTH'])->default('EXPENSE');
            $table->string('description',100)->nullable();
            $table->boolean('is_calculable')->default(true);
            $table->boolean('deleted')->default(0);
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
            $table->foreignUuid('user_id')->references('id')->on('users')->cascadeOnDelete();
       });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
};
