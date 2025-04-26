<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Orders are created by customers, not admins
        return redirect()->route('admin.orders.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Orders are created by customers, not admins
        return redirect()->route('admin.orders.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $order = Order::findOrFail($id);
        return view('admin.orders.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'order_status' => 'required|in:pending,processing,completed,cancelled',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
        ]);

        $order->update([
            'order_status' => $request->order_status,
            'payment_status' => $request->payment_status,
        ]);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // For e-commerce, it's usually better to cancel orders rather than delete them
        $order = Order::findOrFail($id);
        $order->update(['order_status' => 'cancelled']);

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order cancelled successfully!');
    }
}
