<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Analogue extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'analogue_id',
    ];
}
