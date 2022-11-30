<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        "carrier_id", "number", "trailer",
    ];

    public function carrier()
    {
        return $this->belongsTo(Carrier::class);
    }
}
