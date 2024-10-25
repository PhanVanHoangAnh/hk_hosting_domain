<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemDemo extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_item_id',
        'demo_order_item_id'
    ];

    public function OrderItem()
    {
        return $this->belongsTo(OrderItem::class, 'demo_order_item_id');
    }
}
