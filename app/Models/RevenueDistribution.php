<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevenueDistribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_item_id',
        'account_id',
        'amount'
    ];

    public function orderItem() {
        return $this->belongsTo(OrderItem::class, 'order_item_id', 'id');
    }

    public function account() {
        return $this->belongsTo(Account::class);
    }
    
    public function newDefault()
    {
        $revenue = new self();

        return $revenue;
    }
}
