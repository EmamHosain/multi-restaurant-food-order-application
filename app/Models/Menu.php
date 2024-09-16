<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;
    protected $table = 'menus';
    protected $fillable = [
        'menu_name',
        'image',
        'client_id',
        'slug'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
