<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToRecoveryInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recovery_invoices', function (Blueprint $table) {
            //
            $table->smallInteger('doc_printed')->default(0)->nullable();
            $table->date('invoiced_date')->nullable();
            $table->unsignedInteger('final_user')->nullable();
            $table->string('final_comments')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recovery_invoices', function (Blueprint $table) {
            //
        });
    }
}
