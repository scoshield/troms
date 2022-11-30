<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRecoveryInvoiceNewCols extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recovery_invoices', function (Blueprint $table) {
            $table->unsignedInteger('invoice_id')->nullable();
            $table->date('invoice_date')->nullable();
            $table->unsignedInteger('currency_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->dropColumn('rcn_id');
        });
    }
}
