<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'item', 'opening_stock', 'sdis', 'sios', 'sohn', 'price_unit', 'total'
    ];
}
