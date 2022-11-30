<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domains\Auth\Models\User;

class TransferLog extends Model
{
    use HasFactory;

    protected $fillable = [
        "invoice_id", "from_user_id", "to_user_id", "from_department_code", "to_department_code", "status", "comments"
    ];

    public function recipient()
    {
        return $this->belongsTo(User::class, "to_user_id");
    }

    public function sender()
    {
        return $this->belongsTo(User::class, "from_user_id");
    }
}
