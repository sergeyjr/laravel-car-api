<?php

namespace App\Http\Controllers;

use App\API\V1\Services\CarService;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function api(Request $request, CarService $carService): JsonResponse
    {
        $user = $request->user();

        // CARS
        $carsCount = $carService->getCarsCount();

        // ORDERS
        $orders = Order::where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get();

        $ordersCount = Order::where('user_id', $user->id)->count();

        // CART
        $cart = Cart::where('user_id', $user->id)
            ->with('items.car')
            ->first();

        $cartItems = [];
        $cartTotal = 0;

        if ($cart) {
            foreach ($cart->items as $item) {
                $cartItems[$item->car_id] = [
                    'id' => $item->car_id,
                    'qty' => $item->qty,
                    'price' => $item->price,
                    'name' => $item->car->title ?? null,
                ];

                $cartTotal += $item->price * $item->qty;
            }
        }

        return response()->json([
            'carsCount' => $carsCount,

            'ordersCount' => $ordersCount,
            'orders' => $orders,

            'cart' => $cartItems,
            'cartTotal' => $cartTotal,
        ]);
    }

}
