<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    /**
     * Update the user's profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('user.profile')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Show the form for changing password.
     */
    public function changePassword()
    {
        return view('user.change-password');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.profile')
            ->with('success', 'Password changed successfully!');
    }

    /**
     * Display the user's orders.
     */
    public function orders()
    {
        $orders = Auth::user()->orders()->latest()->paginate(10);
        return view('user.orders', compact('orders'));
    }

    /**
     * Display a specific order.
     */
    public function showOrder($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->with('items.product')
            ->firstOrFail();

        return view('user.order-detail', compact('order'));
    }
}
