<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'files';
    public function up(): void
    {
        Schema::create($this->table, function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->integer('sequence');
            $table->string('name',100);
            $table->string('path');
            $table->foreignUuid('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignUuid('financial_record_id')->references('id')->on('financial_records')->cascadeOnDelete();
            $table->dateTime('created_at');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
};
