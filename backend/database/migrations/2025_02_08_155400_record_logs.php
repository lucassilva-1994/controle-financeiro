<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'record_logs';
    public function up(): void
    {
        Schema::create($this->table, function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->integer('sequence');
            $table->uuidMorphs('entity');
            $table->longText('content')->nullable();
            $table->json('old_values')->nullable();
            $table->json('current_values')->nullable();
            $table->ipAddress('ip');
            $table->enum('action',['CREATE','UPDATE','DELETE']);
            $table->foreignUuid('executed_by')->references('id')->on('users')->cascadeOnDelete();
            $table->dateTime('executed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
};
