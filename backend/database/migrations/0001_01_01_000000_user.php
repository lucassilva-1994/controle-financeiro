<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'users';
    public function up(): void
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('sequence');
            $table->string('name',100);
            $table->string('email',100)->unique();
            $table->string('username',40)->unique()->nullable();
            $table->string('password',60)->nullable();
            $table->string('photo',100)->nullable();
            $table->string('token',100)->nullable();
            $table->boolean('active')->default(0);
            $table->dateTime('token_expires_at')->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
};
