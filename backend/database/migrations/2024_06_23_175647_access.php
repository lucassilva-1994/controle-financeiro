<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'accesses';
    public function up(): void
    {
        Schema::create($this->table, function(BluePrint $table){
            $table->uuid('id')->primary();
            $table->integer('sequence');
            $table->ipAddress('ip_address');
            $table->string('city',100);
            $table->string('browser',50);
            $table->string('platform',50);
            $table->dateTime('created_at');
            $table->foreignUuid('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
};
