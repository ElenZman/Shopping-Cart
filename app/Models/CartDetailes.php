<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDetailes extends Model
{
    protected $table = 'cart_details';

    protected $fillable = [
        'item_id',
        'cart_id',
        'quantity'
    ];

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }


    public function items()
    {
        return $this->hasMany(Item::class);
    }


    public function incrementQuantity()
    {
        $this->quantity++;
        $this->save();
    }


}
