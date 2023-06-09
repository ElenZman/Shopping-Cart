<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'created_at',
        'updated_at'
    ];
    public function cart_details()
    {
        return $this->belongsTo(CartDetails::class);
    }
}
