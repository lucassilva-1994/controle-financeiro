<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'financial_records';
    public function up(): void
    {
        Schema::create($this->table, function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->integer('sequence');
            $table->string('description',100);
            $table->decimal('amount', 10, 2);
            $table->date('financial_record_date');
            $table->date('financial_record_due_date')->default(now()->toDateString());
            $table->enum('payment_status', ['PENDING', 'PAID', 'OVERDUE'])->default('PENDING');
            $table->enum('type', ['INCOME', 'EXPENSE'])->default('EXPENSE');
            $table->boolean('deleted')->default(0);
            $table->integer('installment_number')->default(1);
            $table->integer('installment_total')->default(1);
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
            $table->longText('details')->nullable();
            $table->foreignUuid('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignUuid('payment_id')->references('id')->on('payments');
            $table->foreignUuid('supplier_customer_id')->nullable()->references('id')->on('suppliers_and_customers');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists($this->table);
    }
};
