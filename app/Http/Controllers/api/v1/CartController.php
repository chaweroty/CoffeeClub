<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with('products')->get();
        return response()->json($carts, 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'total' => 'required|numeric|min:0',
            'user_id' => 'required|exists:users,id',
        ]);

        $cart = Cart::create($validatedData);
        return response()->json($cart, 201);
    }

    public function show(Cart $cart)
    {
        $cart->load('products');
        return response()->json($cart, 200);
    }

    public function update(Request $request, Cart $cart)
    {
        $validatedData = $request->validate([
            'total' => 'numeric|min:0',
        ]);

        $cart->update($validatedData);
        return response()->json($cart, 200);
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();
        return response()->json(null, 204);
    }
}