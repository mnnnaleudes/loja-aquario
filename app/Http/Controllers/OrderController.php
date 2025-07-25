<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return auth()->user()->orders()->with('items.product')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $order = auth()->user()->orders()->create([
            'status' => 'pendente',
        ]);

        foreach ($validated['items'] as $item) {
            $product = Product::find($item['product_id']);
            $order->items()->create([
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'price' => $product->price,
            ]);
        }

        return $order->load('items.product');
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order); // se quiser garantir que só o dono veja
        return $order->load('items.product');
    }

}
