<?php

namespace App\Http\Controllers;

use App\Models\CartProduct;
use Illuminate\Http\Request;

class CartProductController extends Controller
{
    public function index($cart)
    {
        $cartProducts = CartProduct::with('product')
            ->where('cart_id', $cart)
            ->get();

        return response()->json($cartProducts, 200);
    }

    // Agregar un producto al carrito
    public function store(Request $request, $cartId, $productId)
    {
        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartProduct = CartProduct::create([
            'cart_id' => $cartId,
            'product_id' => $productId,
            'quantity' => $validatedData['quantity'],
        ]);

        return response()->json($cartProduct, 201);
    }

    // Eliminar un producto de un carrito
    public function destroy($cartId, $productId)
    {
        $cartProduct = CartProduct::where('cart_id', $cartId)
            ->where('product_id', $productId)
            ->first();

        if (!$cartProduct) {
            return response()->json(['message' => 'Product not found in the cart'], 404);
        }

        $cartProduct->delete();
        return response()->json(null, 204);
    }

    public function show(CartProduct $cartProduct)
    {
        $cartProduct->load(['cart', 'product']);
        return response()->json($cartProduct, 200);
    }

    public function update(Request $request, CartProduct $cartProduct)
    {
        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartProduct->update($validatedData);
        return response()->json($cartProduct, 200);
    }

    
}
