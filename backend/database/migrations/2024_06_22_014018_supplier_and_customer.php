<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'suppliers_and_customers';
    public function up(): void
    {
        Schema::create($this->table, function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->integer('sequence');
            $table->string('name', 60);
            $table->enum('type', ['SUPPLIER', 'CUSTOMER', 'BOTH'])->default('BOTH');
            $table->string('description',100)->nullable();
            $table->string('email',100)->nullable();
            $table->string('phone',15)->nullable();
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
