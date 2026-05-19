<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    /**
     * Оформление заказа из корзины
     */
    public function checkout(Request $request)
    {
        $user = $request->user();

        return DB::transaction(function () use ($request, $user) {

            // 1. получаем корзину
            $cart = Cart::where('user_id', $user->id)
                ->with('items')
                ->first();

            if (!$cart || $cart->items->isEmpty()) {
                return response()->json([
                    'message' => 'Корзина пуста'
                ], 422);
            }

            // 2. создаём заказ
            $order = Order::create([
                'user_id' => $user->id,
                'total' => $cart->items->sum(fn($item) => $item->price * $item->qty),
                'status' => OrderStatus::PendingPayment->value,
                'comment' => $request->input('comment'),
            ]);

            // 3. переносим товары в order_items
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'car_id' => $item->car_id,
                    'qty' => $item->qty,
                    'price' => $item->price,
                ]);
            }

            // 4. очищаем корзину
            $cart->items()->delete();

            return response()->json([
                'message' => 'Заказ успешно создан',
                'order' => $order->load('items')
            ]);
        });
    }

    public function index(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->with('items')
            ->latest()
            ->get();

        return response()->json($orders);
    }

    public function show(Request $request, $id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->with('items')
            ->firstOrFail();

        return response()->json($order);
    }

}
