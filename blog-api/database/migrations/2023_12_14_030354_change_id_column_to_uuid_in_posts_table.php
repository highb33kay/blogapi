<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('posts', function (Blueprint $table) {
        $table->uuid('id')->default(DB::raw('UUID()'))->change();
    });
}

public function down()
{
    Schema::table('posts', function (Blueprint $table) {
        $table->id()->change();
    });
}
};
