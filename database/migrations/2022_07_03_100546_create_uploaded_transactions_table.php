<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadedTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploaded_transactions', function (Blueprint $table) {
            $table->id();
            $table->text("com")->nullable();
            $table->text("purchasing_order_no")->nullable();
            $table->text("rcn_no")->nullable();
            $table->text("cancelled_on")->nullable();
            $table->text("po_type")->nullable();
            $table->text("tro_status")->nullable();
            $table->text("status_date")->nullable();
            $table->text("status_author")->nullable();
            $table->text("tro_comments")->nullable();
            $table->text("unique_ref_of_loopssc")->nullable();
            $table->text("priority_on")->nullable();
            $table->text("tro_type")->nullable();
            $table->text("branch_code" )->nullable();
            $table->text("department_code")->nullable();
            $table->text("tracking_file_no" )->nullable();
            $table->text("order_n" )->nullable();
            $table->text("import_export")->nullable();
            $table->text("file_type")->nullable();
            $table->text("planned_quantity_20")->nullable();
            $table->text("planned_quantity_40")->nullable();
            $table->text("planned_quantity_bulk_and_parcel")->nullable();
            $table->text("planned_weight_kgs" )->nullable();
            $table->text("goods_description" )->nullable();
            $table->text("goods_description_tro")->nullable();
            $table->text( "parcel_seal_no" )->nullable();
            $table->text("parcel_bulk_container_no" )->nullable();
            $table->text("real_customer" )->nullable();
            $table->text("consignee_shipper")->nullable();
            $table->text("loading_country")->nullable();
            $table->text("loading_place" )->nullable();
            $table->text("unloading_country" )->nullable();
            $table->text("unloading_place" )->nullable();
            $table->text("transporter_name" )->nullable();
            $table->text("transporter_nationality")->nullable();
            $table->text("type_of_equipment" )->nullable();
            $table->text("vector" )->nullable();
            $table->text("trailer" )->nullable();
            $table->text("carrier_contact")->nullable();
            $table->text( "estimated_rate" )->nullable();
            $table->text("currency")->nullable();
            $table->text("advance")->nullable();
            $table->text("advance_amount" )->nullable();
            $table->text("type_of_routing" )->nullable();
            $table->text("escort_on" )->nullable();
            $table->text("dangerous_on")->nullable();
            $table->text("dangerous_goods" )->nullable();
            $table->text("controlled_temp_on" )->nullable();
            $table->text("temperature" )->nullable();
            $table->text("po_instructions" )->nullable();
            $table->text("rcn_instructions" )->nullable();
            $table->text("advance_reference_actual" )->nullable();
            $table->text("total_advance_actual" )->nullable();
            $table->text("invoice_reference_actual" )->nullable();
            $table->text("total_invoice_actual" )->nullable();
            $table->text("shunting_ended_on" )->nullable();
            $table->text( "end_of_shunting_date" )->nullable();
            $table->text("anomaly_quantity")->nullable();
            $table->text("anomaly_weight_kgs")->nullable();
            $table->text("gtp" )->nullable();
            $table->text("author_gtp" )->nullable();
            $table->text("gtp_comment" )->nullable();
            $table->text("plan_code" )->nullable();
            $table->text("corridor_departure" )->nullable();
            $table->text("corridor_destination")->nullable();
            $table->text("file_date" )->nullable();
            $table->text("ata_date")->nullable();
            $table->text("ready_for_dispatch_date" )->nullable();
            $table->text("tro_date" )->nullable();
            $table->text("tro_author" )->nullable();
            $table->text("loading_date" )->nullable();
            $table->text("loading_author")->nullable();
            $table->text("departure_date" )->nullable();
            $table->text("departure_author" )->nullable();
            $table->text("arrival_date" )->nullable();
            $table->text("arrival_author" )->nullable();
            $table->text("unloading_date" )->nullable();
            $table->text("unloading_author")->nullable();
            $table->text("transit_time_departure_arrival")->nullable();
            $table->text("transit_time_loading_unloading" )->nullable();
            $table->text("interchange_shipping_date")->nullable();
            $table->text("of_completed_interchange_shipping" )->nullable();
            $table->text("printing_on")->nullable();
            $table->text("printing_date" )->nullable();
            $table->text("printing_user")->nullable();
            $table->text("internal_comment")->nullable();
            $table->text("external_comment")->nullable();
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
        Schema::dropIfExists('uploaded_transactions');
    }
}
