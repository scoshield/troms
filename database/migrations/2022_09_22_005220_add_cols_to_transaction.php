<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsToTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedInteger('currency_id')->nullable();
            $table->string("file_no")->nullable();
            $table->string("trailer_no")->nullable();
            $table->string("container_no")->nullable();
            $table->double("agreed_rate")->nullable();
        });
    }
}
