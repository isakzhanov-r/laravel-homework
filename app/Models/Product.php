<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'price',
        'vendor_id',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'id', 'vendor_id');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class,'order_products')
            ->withPivot([
                'quantity',
                'price',
            ]);
    }
}
