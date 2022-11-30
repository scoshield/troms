<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeleteAtToConsigneeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consignees', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('agents', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('cargo_types', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('carriers', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('clients', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('destinations', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('shippers', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('vehicles', function (Blueprint $table) {
            $table->softDeletes();
        });
    }
}
