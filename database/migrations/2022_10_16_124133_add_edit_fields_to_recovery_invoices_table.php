<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEditFieldsToRecoveryInvoicesTable extends Migration
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
            $table->string('edit_fields', 191)->nullable()->after('recalled_id');
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
