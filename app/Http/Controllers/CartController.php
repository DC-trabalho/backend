<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        $items = $cart->items()->with('product', 'variation')->get();

        return inertia('Cart', ['items' => $items]);
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'variation_id' => 'required|exists:variations,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Auth::check()
            ? Cart::firstOrCreate(['user_id' => Auth::id()])
            : Cart::firstOrCreate(['session_id' => session()->getId()]);

        $item = $cart->items()->firstOrNew([
            'product_id' => $validated['product_id'],
            'variation_id' => $validated['variation_id'],
        ]);

        $item->quantity += $validated['quantity'];
        $item->save();

        return response()->json(['message' => 'Produto adicionado ao carrinho!']);
    }

    public function update(Request $request)
    {
        $request->validate([
            'cartItemId' => 'required|exists:cart_items,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = CartItem::findOrFail($request->cartItemId);
        
        $cartItem->update([
            'quantity' => $request->quantity
        ]);

        return redirect()->route('cart');
    }

    public function remove(Request $request)
    {
        $request->validate([
            'cartItemId' => 'required|exists:cart_items,id',
        ]);

        $cartItem = CartItem::findOrFail($request->cartItemId);

        $cartItem->delete();

        return redirect()->route('cart');
    }
}
