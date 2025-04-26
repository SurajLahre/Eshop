<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index()
    {
        $featuredProducts = Product::where('featured', true)
            ->where('is_active', true)
            ->with('images')
            ->take(8)
            ->get();

        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->take(6)
            ->get();

        return view('home', compact('featuredProducts', 'categories'));
    }
}
