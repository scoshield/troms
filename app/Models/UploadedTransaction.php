<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadedTransaction extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'rcn_no');
    }
}
