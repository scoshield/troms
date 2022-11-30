<?php

namespace App\Models;

use App\Domains\Auth\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalLevel extends Model
{
    use HasFactory;

    const HIGHEST_WEIGHT =4;
    const APPROVAL_WEIGHTS = [
        0 => "Clerk",
        1 => "1st Level Approver COM",
        2 => "OPs Control",
        3 => "Transport Manager",
        4 => "HOD",
        5 => "HBU - Final Level Approver",
    ];

    protected $fillable = [
        "user_id", "weight", "can_mark_as_approved", "departments"
    ];

    protected $casts = [
        'departments' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }
}
