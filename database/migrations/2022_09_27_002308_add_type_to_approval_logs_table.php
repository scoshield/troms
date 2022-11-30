<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToApprovalLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('approval_logs', 'type')) {
            Schema::table('approval_logs', function (Blueprint $table) {
                $table->string('type', 32)->nullable();
            });
        }
    }
}
