<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToRecoveryInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('recovery_invoices', 'user_id')) {
            Schema::table('recovery_invoices', function (Blueprint $table) {
                $table->unsignedInteger('user_id')->nullable();
            });
        }
    }
}
