<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipping_Address extends Model
{
     protected $table = 'shipping_addresses';
    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'house_number',
        'street',
        'city',
        'district',
        'ward',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
