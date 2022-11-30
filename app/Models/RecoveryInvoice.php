<?php

namespace App\Models;

use App\Domains\Auth\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecoveryInvoiceStatus
{
    public const CANCELLED = 'cancelled';
    public const PARTIALLY_APPROVED = 'partially_approved';
    public const APPROVED = 'approved';
    public const REJECTED = 'rejected';
}

class RecoveryInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id', 'invoice_amount', 'edit_fields', 'invoice_number', 'comments', 'currency_id', 'invoice_date', 'user_id', "status", "level", "recalled_id", "pod_available", "ein_available"
    ];

    public function invoice()
    {
        return $this->belongsTo(TransactionInvoice::class, 'invoice_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function recalled()
    {
        return $this->belongsTo(ApprovalLog::class, 'recalled_id');
    }

    public function approvalLogs()
    {
        return $this->hasMany(ApprovalLog::class, 'recovery_id');
    }

    public function scopeFilter($query, $request_data)
    {   
        
        if (array_key_exists('clear', $request_data)) {
            return $query;
        }

        if (array_key_exists("search", $request_data) && $request_data['search']) {
            $search = $request_data['search'];
            $query = $query->where('invoice_number', $search)->orWhere('invoice_amount', $search);
        }

        if (array_key_exists('status', $request_data) && $request_data['status'] && $request_data['status'] != 'Select') {
            $status = $request_data['status'];
            if ($status == TransactionInvoice::$RECOVERY_INVOICE_ATTACHED) {
                $query = $query->whereHas('recoveryInvoice');
            }else{
                $query = $query->where('status', $status); 
            } 
            // if($status == 'rejected') {
            //     $query = $query->whereIn('status', ['reject']);
            // }
            // if($status != 'rejected') {
            //     $query = $query->where('status', $status);
            // }
        }

        return $query;
    }

    public function level()
    {
        return $this->belongsTo(ApprovalLevel::class, "level");
    }
}
