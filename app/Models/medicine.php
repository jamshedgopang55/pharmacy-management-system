<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class medicine extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'generic_name',
        'buying_price',
        'selling_price',
        'stock_type',
        'stock',
        'category_id',
    ];
}
