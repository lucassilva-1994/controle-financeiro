<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'releases';
    public function up()
    {
        Schema::create($this->table, function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->bigInteger('sequence');
            $table->string('description', 255);
            $table->longText('details')->nullable();
            $table->decimal('value',14,2);
            $table->date('date');
            $table->enum('status',['PENDING','PAID']);
            $table->date('due_date')->nullable();
            $table->enum('type', ['INCOME','EXPENSE']);
            $table->boolean('deleted')->default(0);
            $table->foreignUuid('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignUuid('category_id')->references('id')->on('categories')->cascadeOnDelete();
            $table->foreignUuid('payment_id')->references('id')->on('payments')->cascadeOnDelete();
            $table->foreignUuid('client_creditor_id')->nullable()->references('id')->on('clients_creditors')->cascadeOnDelete();
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
        });
    }
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
};
