<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CargoType;
use App\Models\Carrier;
use App\Models\Consignee;
use App\Models\Destination;
use App\Models\Shipper;
use App\Models\Transaction;
use App\Models\Vehicle;
use App\Models\Agent;
use App\Models\Currency;

class Transaction extends Model
{
    use HasFactory;

    public static $PENDING = 0;
    public static $INVOICE_ATTACHED = 1;
    public static $INVOICE_MATCHED = 2;
    public static $AMOUNT_NOT_EQUAL = 3;

    public static $PARTIALLY_APPROVED = 4;
    public static $APPROVED = 5;
    public static $CANCELLED = 6;

    public static $MANUAL_TRANSACTION = "manual";
    public static $SOURCE_TYPE_UPLOADED = "upload";


    protected $fillable = [
        "agent_departure", "agent_destination", "carrier", "shipper", "consignee",
        "vehicle", "date", "tracking_no", "marks", "cargo_type", "cargo_desc", "quantity",
        "weight", "remarks",  "rcn_no", "customs_no", "notes", "status", "amount", "source_type",
        "invoice_id", "file_no", "trailer_no", "container_no", "agreed_rate", "currency_id",
        "recovery_invoice_id", "department_code", "department_com", "purchase_order_no"
    ];

    public function vehicleR()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle');
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_departure');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, "department_code", "code");
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class, 'agent_destination');
    }

    public function carrierR()
    {
        return $this->belongsTo(Carrier::class, 'carrier');
    }

    public function shipperR()
    {
        return $this->belongsTo(Shipper::class, 'shipper');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function consigneeR()
    {
        return $this->belongsTo(Consignee::class, 'consignee');
    }

    public function cargoTypeR()
    {
        return $this->belongsTo(CargoType::class, 'cargo_type');
    }

    public function approvalLogs()
    {
        return $this->hasMany(RcnApprovalLog::class, "rcn_id");
    }

    public function transactionInvoice()
    {
        return $this->belongsTo(TransactionInvoice::class, "invoice_id");
    }

    public function recoveryInvoice()
    {
        return $this->hasOne(RecoveryInvoice::class, "rcn_id");
    }

    public function uploadTrx()
    {
        return $this->belongsTo(UploadedTransaction::class, "rcn_no");
    }

    public function scopeFilter($query, $request_data)
    {
        if (array_key_exists('clear', $request_data)) {
            return $query;
        }

        if (array_key_exists("search", $request_data) && $request_data['search']) {
            $search = $request_data['search'];
            $query = $query->where('rcn_no', $search)->orWhere("tracking_no", $search);
        }

        if (array_key_exists('type', $request_data) && $request_data['type'] && $request_data['type'] != 'Select') {
            $type = $request_data['type'];
            if($type == 'is_null')
            {
                $query = $query->whereNull("invoice_id");
            }elseif($type = 'not_null')
            {
                $query = $query->whereNotNull("invoice_id");
            }
        }

        if (array_key_exists('status', $request_data) && $request_data['status'] && $request_data['status'] != 'Select') {
            $status = $request_data['status'];
            if ($status == Transaction::$INVOICE_ATTACHED) {
                $query = $query->whereHas('transactionInvoice');
            } else {
                $query = $query->where('status', $status);
            }
        }

        return $query;
    }
}
