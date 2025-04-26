<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'total_amount',
        'payment_method',
        'payment_status',
        'order_status',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_zipcode',
        'shipping_country',
        'shipping_phone',
        'shipping_email',
        'notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
