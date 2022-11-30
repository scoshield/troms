<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInColsToTransactionInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_invoices', function (Blueprint $table) {
            $table->dropColumn("transaction_id");
            $table->dropColumn("rcn_no");
            $table->unsignedInteger("currency_id")->nullable();
            $table->string('tracking_no')->nullable();
            $table->date('tracking_date')->nullable();
        });
    }
}
