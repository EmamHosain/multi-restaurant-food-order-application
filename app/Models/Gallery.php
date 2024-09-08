<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    protected $table = 'galleries';
    protected $fillable = [
        'client_id',
        'image',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
