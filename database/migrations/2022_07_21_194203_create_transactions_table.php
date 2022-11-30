<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *  
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("agent_departure");
            $table->unsignedInteger("agent_destination");
            $table->unsignedInteger("carrier");
            $table->unsignedInteger("shipper");
            $table->unsignedInteger("consignee");
            $table->unsignedInteger("vehicle");
            $table->date("date");
            $table->string("tracking_no");
            $table->text("marks");
            $table->unsignedInteger("cargo_type");
            $table->text("cargo_desc");
            $table->unsignedInteger("quantity");
            $table->unsignedInteger("weight");
            $table->text("remarks");
            $table->string("rcn_no", 1024);
            $table->string("customs_no", 1024);
            $table->string("notes", 1024);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
