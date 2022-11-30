<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("invoice_id");
            $table->unsignedInteger("from_user_id");
            $table->unsignedInteger("to_user_id");
            $table->unsignedInteger("from_department_code");
            $table->unsignedInteger("to_department_code");
            $table->enum("status", ["pending", "accepted", "rejected"])->default("pending");
            $table->string("comments", 500);
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
        Schema::dropIfExists('transfer_logs');
    }
}
