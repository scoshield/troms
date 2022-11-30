<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeFieldNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agents', function (Blueprint $table) {
            $table->string("email")->nullable()->change();
            $table->string("tel")->nullable()->change();
        });

        Schema::table('carriers', function (Blueprint $table) {
            $table->string("email")->nullable()->change();
            $table->string("tel")->nullable()->change();
            $table->string("kra_pin")->nullable()->change();
        });

        Schema::table('shippers', function (Blueprint $table) {
            $table->string("email")->nullable()->change();
            $table->string("tel")->nullable()->change();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->string("status")->nullable()->change();
            $table->date("date")->nullable()->change();
        });

        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropUnique(["number"]);
        });
    }
}
