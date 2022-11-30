<?php

use App\Models\RcnApprovalLog;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateApprovalLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('transaction_invoices', 'invoice_id')) {
            Schema::table('transaction_invoices', function (Blueprint $table) {
                $table->unsignedInteger('invoice_id')->nullable();
            });
        }

        if (Schema::hasTable('rcn_approval_logs')) {
            Schema::dropIfExists('rcn_approval_logs');

            Schema::create('approval_logs', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger("recovery_id");
                $table->unsignedInteger("user_id");
                $table->text("comments")->nullable();
                $table->integer("weight");
                $table->boolean("is_approved");
                $table->timestamps();
            });
        }
    }
}
