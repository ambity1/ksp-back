<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'name', 'articul', 'price', 'store', 'barcode', 'description', 'id_1с',
    ];
    protected $timestamp = false;

}
