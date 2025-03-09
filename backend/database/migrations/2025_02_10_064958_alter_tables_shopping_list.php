<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'shopping_list_items';

    public function up(): void
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->date('payment_date')->nullable()->after('unit');
        });
    }

    public function down(): void
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->dropColumn('payment_date');
        });
    }
};
