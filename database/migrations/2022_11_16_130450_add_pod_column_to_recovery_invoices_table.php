<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPodColumnToRecoveryInvoicesTable extends Migration
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
            $table->smallInteger('pod_available')->default(0);
            $table->smallInteger('ein_available')->default(0);
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
