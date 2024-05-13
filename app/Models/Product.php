<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'name', 'articulate', 'price', 'barcode', 'description', 'id_1с', 'state'
    ];
    protected $timestamp = false;

}
