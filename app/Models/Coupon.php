<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    protected $table = 'coupons';
    protected $fillable = [
        'client_id',
        'coupon_name',
        'coupon_desc',
        'validity_date',
        'status',
        'discount'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
