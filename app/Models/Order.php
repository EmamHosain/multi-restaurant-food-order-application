<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'address',
        'payment_type',
        'payment_method',
        'transaction_id',
        'currency',
        'amount',
        'total_amount',
        'order_number',
        'invoice_no',
        'order_date',
        'order_month',
        'order_year',
        'confirmed_date',
        'processing_date',
        'shipped_date',
        'delivered_date',
        'status',
    ];

    /**
     * The user who placed the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
