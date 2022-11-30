<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToTransactionInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            Schema::table('transaction_invoices', function (Blueprint $table) {
                $table->unsignedInteger("user_id");
            });
        } catch (Exception $e) {
            echo $e->message;
        }
    }
}
