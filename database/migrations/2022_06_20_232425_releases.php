<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('releases', function(Blueprint $table){
            $table->uuid('id')->primary();
            $table->bigInteger('sequence');
            $table->string('description', 255);
            $table->longText('details')->nullable();
            $table->decimal('value',14,2);
            $table->date('date');
            $table->enum('status_pay',['ABERTO','QUITADO']);
            $table->date('due_date')->nullable();
            $table->enum('type', ['ENTRADA','SAIDA']);
            $table->boolean('is_active')->default(1);
            $table->dateTime('created_at');
            $table->dateTime('updated_at')->nullable();
            $table->foreignUuid('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignUuid('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreignUuid('payment_id')->references('id')->on('payments')->onDelete('cascade');
            $table->foreignUuid('creditorsclients_id')->nullable()->references('id')->on('creditorsclients')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('releases');
    }
};
