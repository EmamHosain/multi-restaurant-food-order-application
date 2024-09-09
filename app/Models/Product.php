<?php

namespace App\Models;

use App\Models\City;
use App\Models\Menu;
use App\Models\Client;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'admin_id',
        'name',
        'slug',
        'category_id',
        'city_id',
        'menu_id',
        'code',
        'qty',
        'size',
        'price',
        'discount_price',
        'image',
        'client_id',
        'most_popular',
        'best_seller',
        'status'
    ];

    // admin relationship
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
    // Category Relationship
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // City Relationship
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    // Menu Relationship
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    // Client Relationship
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
