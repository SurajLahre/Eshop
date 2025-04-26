<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function index()
    {
        // Redirect to cart if it's empty
        $sessionId = Session::getId();
        $userId = Auth::check() ? Auth::id() : null;

        $cartItems = [];
        $total = 0;

        if ($userId) {
            $cartItems = Cart::where('user_id', $userId)
                ->with('product.images')
                ->get();
        } else {
            $cartItems = Cart::where('session_id', $sessionId)
                ->with('product.images')
                ->get();
        }

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty. Please add products before checkout.');
        }

        foreach ($cartItems as $item) {
            $total += $item->product->price * $item->quantity;
        }

        return view('checkout.index', compact('cartItems', 'total'));
    }

    /**
     * Process the checkout and create an order.
     */
    public function process(Request $request)
    {
        // Validate checkout form
        $request->validate([
            'shipping_address' => 'required|string|max:255',
            'shipping_city' => 'required|string|max:100',
            'shipping_state' => 'required|string|max:100',
            'shipping_zipcode' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:100',
            'shipping_phone' => 'required|string|max:20',
            'shipping_email' => 'required|email|max:100',
            'payment_method' => 'required|in:credit_card,paypal',
            'notes' => 'nullable|string',
        ]);

        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Please login to complete your order.');
        }

        $userId = Auth::id();
        $cartItems = Cart::where('user_id', $userId)
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty. Please add products before checkout.');
        }

        // Calculate total amount
        $totalAmount = 0;
        foreach ($cartItems as $item) {
            $totalAmount += $item->product->price * $item->quantity;
        }

        // Create order
        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'user_id' => $userId,
            'total_amount' => $totalAmount,
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
            'order_status' => 'pending',
            'shipping_address' => $request->shipping_address,
            'shipping_city' => $request->shipping_city,
            'shipping_state' => $request->shipping_state,
            'shipping_zipcode' => $request->shipping_zipcode,
            'shipping_country' => $request->shipping_country,
            'shipping_phone' => $request->shipping_phone,
            'shipping_email' => $request->shipping_email,
            'notes' => $request->notes,
        ]);

        // Create order items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'total' => $item->product->price * $item->quantity,
            ]);
        }

        // Clear the cart
        Cart::where('user_id', $userId)->delete();

        // Redirect to thank you page
        return redirect()->route('checkout.complete', ['order' => $order->id])
            ->with('success', 'Your order has been placed successfully!');
    }

    /**
     * Display the order completion page.
     */
    public function complete(Order $order)
    {
        // Ensure the order belongs to the authenticated user
        if (Auth::id() != $order->user_id) {
            return redirect()->route('home')
                ->with('error', 'You are not authorized to view this order.');
        }

        return view('checkout.complete', compact('order'));
    }
}
