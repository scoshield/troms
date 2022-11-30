<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToRecoveryInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('recovery_invoices', 'status')) {
            Schema::table('recovery_invoices', function (Blueprint $table) {
                $table->string('status', 32)->nullable();
            });
        }

        if (!Schema::hasColumn('transaction_invoices', 'file_number')) {
            Schema::table('transaction_invoices', function (Blueprint $table) {
                $table->string('file_number', 32)->nullable();
            });
        }
    }
}
