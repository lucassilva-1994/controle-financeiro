<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = "accesses";
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->bigInteger('sequence');
            $table->dateTime('created_at');
            $table->ipAddress("ip_address");
            $table->foreignUuid("user_id")->references("id")->on("users")->onDelete("cascade");
        });
    }
    public function down()
    {

    }
};
