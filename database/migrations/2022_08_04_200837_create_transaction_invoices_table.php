<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *  "invoice_number", "invoice_amount", "delivery_note", "invoice_date", "dnote_date", "comments"
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("transaction_id");
            $table->string("rcn_no");
            $table->string("invoice_number");
            $table->double("invoice_amount");
            $table->text("delivery_note");
            $table->date("invoice_date");
            $table->date("dnote_date")->nullable();
            $table->text("comments")->nullable();
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
        Schema::dropIfExists('transaction_invoices');
    }
}
