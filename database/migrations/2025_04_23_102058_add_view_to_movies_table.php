<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddViewToMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('movies', function (Blueprint $table) {
        $table->unsignedBigInteger('view')->default(0);
    });
}

public function down()
{
    Schema::table('movies', function (Blueprint $table) {
        $table->dropColumn('view');
    });
}

}
