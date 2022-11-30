<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRcnApprovalLogsTable extends Migration
{
    /**
     * Run the migrations.
     *  "rcn_id", "user_id", "comments",
     * @return void
     */
    public function up()
    {
        Schema::create('rcn_approval_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("rcn_id");
            $table->unsignedInteger("user_id");
            $table->text("comments")->nullable();
            $table->integer("weight");
            $table->boolean("is_approved");
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
        Schema::dropIfExists('rcn_approval_logs');
    }
}
