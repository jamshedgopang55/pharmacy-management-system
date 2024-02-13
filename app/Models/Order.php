<?php

namespace App\Models;

use App\Models\OrderIteam;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    public function order_items(){
        return $this->hasMany(OrderIteam::class);
    }
}
