<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'financial_plans_items';
    public function up(): void
    {
        Schema::create($this->table, function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->integer('sequence');
            $table->boolean('checked')->default(0);
            $table->string('name', 150);
            $table->double('amount', 10,2)->nullable();
            $table->double('qtd',4,2)->nullable();
            $table->string('unit',10)->nullable();
            $table->date('due_date')->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
            $table->foreignUuid('financial_plan_id')->index()->references('id')->on('financial_plans')->cascadeOnDelete();
            $table->foreignUuid('user_id')->index()->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
};
