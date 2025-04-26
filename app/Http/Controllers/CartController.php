<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display the cart contents.
     */
    public function index()
    {
        $sessionId = Session::getId();
        $cartItems = [];
        $total = 0;

        if (Auth::check()) {
            $cartItems = Cart::where('user_id', Auth::id())
                ->with('product.images')
                ->get();
        } else {
            $cartItems = Cart::where('session_id', $sessionId)
                ->with('product.images')
                ->get();
        }

        foreach ($cartItems as $item) {
            $total += $item->product->price * $item->quantity;
        }

        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $sessionId = Session::getId();
        $userId = Auth::check() ? Auth::id() : null;

        // Check if the product is already in the cart
        $cartItem = Cart::where('product_id', $product->id)
            ->where(function($query) use ($sessionId, $userId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->first();

        if ($cartItem) {
            // Update quantity if the product is already in the cart
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            // Add new item to the cart
            Cart::create([
                'session_id' => $sessionId,
                'user_id' => $userId,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Product added to cart successfully!');
    }

    /**
     * Update the quantity of a cart item.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::findOrFail($id);
        $sessionId = Session::getId();
        $userId = Auth::check() ? Auth::id() : null;

        // Ensure the cart item belongs to the current user or session
        if (($userId && $cartItem->user_id == $userId) ||
            (!$userId && $cartItem->session_id == $sessionId)) {
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
            return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
        }

        return redirect()->route('cart.index')->with('error', 'Unable to update cart!');
    }

    /**
     * Remove an item from the cart.
     */
    public function remove($id)
    {
        $cartItem = Cart::findOrFail($id);
        $sessionId = Session::getId();
        $userId = Auth::check() ? Auth::id() : null;

        // Ensure the cart item belongs to the current user or session
        if (($userId && $cartItem->user_id == $userId) ||
            (!$userId && $cartItem->session_id == $sessionId)) {
            $cartItem->delete();
            return redirect()->route('cart.index')->with('success', 'Item removed from cart!');
        }

        return redirect()->route('cart.index')->with('error', 'Unable to remove item!');
    }

    /**
     * Clear all items from the cart.
     */
    public function clear()
    {
        $sessionId = Session::getId();
        $userId = Auth::check() ? Auth::id() : null;

        if ($userId) {
            Cart::where('user_id', $userId)->delete();
        } else {
            Cart::where('session_id', $sessionId)->delete();
        }

        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully!');
    }
}
