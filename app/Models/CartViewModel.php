<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartViewModel extends Model
{
    public $cart_items = array();

    public function __construct(public int $cart_id)
    {
        $this->cart_id = $cart_id;

    }

    public function add($item)
    {
         $this->cart_items[]=$item;
    }

    public function get_cart_id(){
        return $this->cartid;
    }

    public function get_cart_items():array
    {
        return $this->cart_items;
    }


}
