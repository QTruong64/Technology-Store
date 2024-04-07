<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportDetail extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function ImportDetailToProduct()
    {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }
}
