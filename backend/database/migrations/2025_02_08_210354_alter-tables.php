<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $tables = ['categories', 'financial_records', 'payments', 'suppliers_and_customers'];

    public function up(): void
    {
        foreach ($this->tables as $table) {
            if (Schema::hasColumn($table, 'deleted')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropColumn('deleted');
                });
            }
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $table) {
            if (!Schema::hasColumn($table, 'deleted')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->boolean('deleted')->default(false);
                });
            }
        }
    }
};
