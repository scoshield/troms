<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrier extends Model
{
    use HasFactory;

    protected $fillable = [
        "name", "address", "tel", "po_box", "town", "country", "kra_pin", "email", "transporter_name"
    ];
}
