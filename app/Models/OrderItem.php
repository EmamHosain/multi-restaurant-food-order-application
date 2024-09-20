<?php

namespace App\Models;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id',
        'order_id',
        'product_id',
        'client_id',
        'qty',
        'price',
    ];

    /**
     * The order that the item belongs to.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * The product associated with the order item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
