<?php

namespace App\Models;

use App\Domains\Auth\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RecoveryInvoice;

class ApprovalLog extends Model
{
    use HasFactory;

    public static  $APPROVED = 'approved';
    public static  $REJECTED = 'rejected';
    public static  $EDITED = 'edited';

    protected $table = 'approval_logs';

    protected $fillable = [
        "recovery_id", "user_id", "comments", "weight", "is_approved", "type", "reason_code"
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function recalled()
    {
        return $this->belongsTo(RecoveryInvoice::class, 'recalled_id');
    }

    public function level()
    {
        return $this->belongsTo(ApprovalLevel::class, "weight", "weight");
    }

    public function reason()
    {
        return $this->belongsTo(ReasonCode::class, "reason_code");
    }
}
