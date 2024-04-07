<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function OrderToCus()
    {
        return $this->belongsTo('App\Models\OrderCustomer', 'cusId', 'id');
    }
    public function OrderToDetail()
    {
        return $this->hasMany('App\Models\OrderDetail', 'orderId', 'id');
    }
    public function OrderToDiscount()
    {
        return $this->belongsTo('App\Models\Discount', 'discountId', 'id');
    }
}