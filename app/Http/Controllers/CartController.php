<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Cart;
use App\Models\Item;
use App\Models\User;
use App\Models\CartDetailes;
use Illuminate\Http\Request;
use App\Models\CartViewModel;
use FFI\Exception as FFIException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function cart(Request $request)
    {
        if (Auth::check()) {
            if (!$request->session()->has('cart-id')) {
                $cart = Cart::where('user_id', Auth::user()->id)->latest()->first();
                $request->session()->put('cart-id', $cart->id);
            }
            if (!$request->session()->has('cart-items')) {
                $cart_to_view = $this->get_cart(Auth::user()->id);
                $request->session()->put('cart-items', $cart_to_view);
            }

            return view('cart-full-view');
        }
    }

    public function get_cart($user_id): array
    {

        //получение корзины из бд, если нет - создаем
        $cart = Cart::where('user_id', $user_id)->latest()->first(); //Проверить лучший метод
        $cart_id = null;
        if ($cart) {
            $cart_id = $cart->id;
            session()->put('cart-id', $cart_id);
        } else {
            $cart = new Cart();
            $cart->user_id = $user_id;
            $cart->save();
            $cart_id =  $cart->id;
            session()->put('cart-id', $cart_id);
        }

        //получаем все товары, связанные с этой корзиной
        $cart_items = CartDetailes::where('cart_id', $cart_id)->get();

        $cart_to_view = [];
        if ($cart_items) {
            foreach ($cart_items as $product) {
                $item = Item::find($product->item_id);
                $cart_to_view[] = array(
                    "product_id" => $item->id,
                    "product_name" => $item->title,
                    "price" => $item->price,
                    "image" => $item->image,
                    "quantity" => $product->quantity,
                );
            }
            return $cart_to_view;
        } else {
            return [];
        }
    }

    public function add_to_cart($id, Request $request)
    {
        if (Auth::check()) {
            try {
                $item = Item::findOrFail($id);
            } catch (Exception $ex) {

                return redirect('/')->with('failure', 'Данный товар отсутсвует в магазине');
            }

            if ($request->session()->has('cart_id')) {
                $cart_id = $request->session()->get('cart_id');
            } else {

                $cart = Cart::where('user_id', Auth::user()->id)->latest()->first();
                $cart_id = $cart->id;
            }

            //проверяем,  есть ли такой товар в корзине
            $cart_details = CartDetailes::where('cart_id', $cart_id)->firstWhere('item_id', $item->id);

            /*********************************************************************************
            как вариант, берем корзину из сессии и обращаемся к бд, только чтобы увеличить кол-во
            $cart_id = session()->get('cart-id');
            $cart = session()->get('cart-items');
            if (count($cart) > 0) {
                foreach ($cart as $item) {
                    if ($id === $item['product_id']) {
                        $quantity = $item['quantity']++;
                        CartDetailes::where('cart_id', $cart_id)->where('item_id', $item['product_id'])->update(['quantity' => $quantity]);
                    }
                }
            }
            *****************************************************************/

            //увеличиваем кол-во, если такой товар имеется в корзине
            if ($cart_details) {
                //метод модели
                $cart_details->incrementQuantity();
            } else {
                //новый, если товара нет
                $cart_details = CartDetailes::create([
                    'cart_id' => $cart_id,
                    'item_id' => $id,
                    'quantity' => 1
                ]);
            }

            //возвращаем в сессию обновленную карзину
            $cart_to_view = $this->get_cart(Auth::user()->id);
            $request->session()->put('cart-items', $cart_to_view);

            return redirect('/')->with('success', 'Товар успешно добавлен в корзину');
        } else {
            return redirect('/')->with('failure', 'Что бы совершать покупки Вам необходимо зарегистрироваться');
        }
    }

    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            if ($request->session()->has('cart-id')) {
                $cart_id = $request->session()->get('cart-id');
            } else {

                $cart = Cart::where('user_id', Auth::user()->id)->latest()->first();
                $cart_id = $cart->id;
            }
        }
        CartDetailes::where('cart_id', $cart_id)->where('item_id', $request->id)->update(['quantity' => $request->quantity]);

        $cart_to_view = $this->get_cart(Auth::user()->id);

        session()->put('cart-items', $cart_to_view);
        session()->flash('success', 'Товар успешно удален из корзины');
    }

    public function remove(Request $request)
    {
        if ($request->id) {

            if ($request->session()->has('cart-id')) {
                $cart_id = $request->session()->get('cart-id');
            } else {

                $cart = Cart::where('user_id', Auth::user()->id)->latest()->first();
                $cart_id = $cart->id;
            }

            CartDetailes::where('cart_id', $cart_id)->where('item_id', $request->id)->delete();

            $cart_to_view = $this->get_cart(Auth::user()->id);

            session()->put('cart-items', $cart_to_view);
            session()->flash('success', 'Товар успешно удален из корзины');
        }
    }
}
