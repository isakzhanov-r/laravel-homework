<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $table = 'partners';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'email',
        'name',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'partner_id', 'id');
    }
}
