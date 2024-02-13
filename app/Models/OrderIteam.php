<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderIteam extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'medicine_id',
        'iteam_price',
        'qty',
        'total_price'
    ];
}
