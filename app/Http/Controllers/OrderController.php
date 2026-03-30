<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\CartItem;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = $request->user()->orders()->with('items.product')->latest()->get();
        return Inertia::render('Orders/Index', ['orders' => $orders]);
    }

    public function store(Request $request)
    {
        $cartItems = $request->user()->cartItems()->with('product')->get();
        if ($cartItems->isEmpty()) {
            return redirect()->back()->withErrors(['cart' => 'Cart is empty.']);
        }

        DB::transaction(function() use ($request, $cartItems) {
            $totalAmount = $cartItems->sum(function($item) {
                return $item->quantity * $item->product->price;
            });

            $order = $request->user()->orders()->create([
                'status' => 'Pending',
                'total_amount' => $totalAmount
            ]);

            foreach ($cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price
                ]);
            }

            $request->user()->cartItems()->delete();
        });

        return redirect()->route('orders.index');
    }

    public function update(Request $request, Order $order)
    {
        if ($order->user_id !== $request->user()->id) abort(403);

        $request->validate([
            'status' => 'required|in:Pending,Completed,Cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->back();
    }
}
