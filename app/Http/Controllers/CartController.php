<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function index(Request $request)
    {
        $cart = Cart::where('user_id', $request->user()->id)
            ->with(['items' => function ($query) {
                $query->orderBy('created_at', 'asc');
            }])
            ->first();

        if (!$cart) {
            return response()->json([]);
        }

        return $cart->items->map(function ($item) {
            return [
                'id' => $item->car_id,
                'qty' => $item->qty,
                'price' => $item->price,
                'name' => $item->car->title ?? null,
                'photo_url' => $item->car->photo_url ?? null,
            ];
        });
    }

    public function add(Request $request)
    {
        $user = $request->user();

        $car = Car::findOrFail($request->id);

        $cart = Cart::firstOrCreate([
            'user_id' => $user->id
        ]);

        $item = CartItem::where('cart_id', $cart->id)
            ->where('car_id', $request->id)
            ->first();

        if ($item) {
            $item->qty += $request->qty ?? 1;
            $item->price = $car->price;
            $item->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'car_id' => $request->id,
                'qty' => $request->qty ?? 1,
                'price' => $car->price
            ]);
        }

        return response()->json([
            'message' => 'added'
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $cart = Cart::firstOrCreate([
            'user_id' => $user->id
        ]);

        $car = Car::findOrFail($request->id);

        $item = CartItem::where('cart_id', $cart->id)
            ->where('car_id', $car->id)
            ->first();

        if ($item) {
            $item->qty = max(1, $request->qty);
            $item->price = $car->price;
            $item->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->id,
                'car_id' => $car->id,
                'qty' => max(1, $request->qty),
                'price' => $car->price
            ]);
        }

        return response()->json([
            'ok' => true
        ]);
    }

    public function remove(Request $request)
    {
        $cart = Cart::where('user_id', $request->user()->id)->first();

        if (!$cart) {
            return response()->json([]);
        }

        CartItem::where('cart_id', $cart->id)
            ->where('car_id', $request->id)
            ->delete();

        return response()->json(['ok' => true]);
    }

    public function clear(Request $request)
    {
        $cart = Cart::where('user_id', $request->user()->id)->first();

        if ($cart) {
            CartItem::where('cart_id', $cart->id)->delete();
        }

        return response()->json([]);
    }

}

