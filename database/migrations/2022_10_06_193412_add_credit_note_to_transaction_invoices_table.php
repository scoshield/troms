<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreditNoteToTransactionInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_invoices', function (Blueprint $table) {
            //
            $table->string('credit_note', 100)->nullable()->after('delivery_note');
            $table->integer('credit_note_amount')->nullable()->after('credit_note');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction_invoices', function (Blueprint $table) {
            //
        });
    }
}
