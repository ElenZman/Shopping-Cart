<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Item;
use App\Models\Vendor;
use App\Models\Category;
use App\Models\CartDetailes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CartController;

class ItemController extends Controller
{
    public function create(Request $request)
    {

        $val = $request->validate(
            [
                'title' => 'required|max:255',
                'price' => 'required|min:2'
            ]
        );

        $item = new Item();
        $item->title = $val['title'];
        $item->vendor_id = $request->vendor;
        $item->category_id = $request->category;
        $item->description = $request->description;
        $item->price = $val['price'];
        $item->image = $request->image;

        $item->save();

        return redirect()->route('add_item')->with('success', 'Товар успешно сосздан');
    }

    public function addItem()
    {
        $vendors = new Vendor();
        $categories = new Category();

        return view('additem')->with('vendors', $vendors->all())->with('categories', $categories->all());
    }

    public function index()
    {
        $cart = null;

        if (Auth::check()) {
            if (!session()->has('cart-id')) {
                $cart = Cart::where('user_id', Auth::user()->id)->latest()->first();
                session()->put('cart-id', $cart->id);
            }
            if (!session()->has('cart-items')) {
                $cart_controller = new CartController();
                $cart_to_view = $cart_controller->get_cart(Auth::user()->id);
                session()->put('cart-items', $cart_to_view);
            }

        }
        return view('/welcome', ['data' => Item::all()]);
    }
}
