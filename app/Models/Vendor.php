<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table = 'vendors';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'email',
        'name',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'vendor_id', 'id');
    }
}
