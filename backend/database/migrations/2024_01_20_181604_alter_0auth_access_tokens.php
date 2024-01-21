<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table = 'oauth_access_tokens';
    public function up()
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->uuid('user_id')->change();
        });
    }
};
