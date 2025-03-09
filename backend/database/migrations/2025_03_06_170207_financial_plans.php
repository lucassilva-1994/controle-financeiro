<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'financial_plans';
    public function up(): void
    {
        Schema::create($this->table, function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->integer('sequence');
            $table->string('name',40);
            $table->longText('description',150)->nullable();
            $table->enum('plan_type',['SHOPPING_LIST','BUDGET']);
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
            $table->foreignUuid('user_id')->index()->references('id')->on('users')->cascadeOnDelete();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
};
