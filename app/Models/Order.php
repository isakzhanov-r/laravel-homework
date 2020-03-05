<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $dates = [
        'delivery_at',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'status',
        'client_email',
        'partner_id',
        'delivery_at',
    ];

    protected $casts = [
        'delivery_at' => 'datetime',
    ];

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')
            ->withPivot([
                'quantity',
                'price',
            ]);
    }
}
