<?php

namespace App\Models;

use App\Domains\Auth\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionInvoice extends Model
{
    use HasFactory;

    public static $PENDING = 0;
    public static $RECOVERY_INVOICE_ATTACHED = 1;
    public static $INVOICE_CANCELLED = 2;

    protected $fillable = [
        "user_id",  "transaction_id", "rcn_no", "invoice_number", "invoice_amount", "delivery_note", "invoice_date", "dnote_date", "comments",
        "tracking_no", "tracking_date", "currency_id", "status", "file_number", "credit_note", "credit_note_amount"
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, "currency_id");
    }

    public function rcns()
    {
        return $this->hasMany(Transaction::class, "invoice_id");
    }

    public function transfers()
    {
        return $this->hasMany(TransferLog::class, "invoice_id");
    }

    public function recoveryInvoice()
    {
        return $this->belongsTo(RecoveryInvoice::class, "invoice_id");
    }

    public function scopeFilter($query, $request_data)
    {
        if (array_key_exists('clear', $request_data)) {
            return $query;
        }

        if (array_key_exists("search", $request_data) && $request_data['search']) {
            $search = $request_data['search'];
            $query = $query->where('transaction_invoices.invoice_number', $search)->orWhere('transaction_invoices.tracking_no', $search);
        }

        if (array_key_exists('status', $request_data) && $request_data['status'] && $request_data['status'] != 'Select') {
            $status = $request_data['status'];
            if ($status == TransactionInvoice::$RECOVERY_INVOICE_ATTACHED) {
                $query = $query->whereHas('recoveryInvoice');
            } 
            elseif($status == 'no_rcn'){
                $query = $query->whereDoesntHave('rcns');
            }else {
                $query = $query->where('status', $status);
            }
        }

        return $query;
    }
}
