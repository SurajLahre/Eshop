<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display the shop homepage with featured products.
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
            ->with('children')
            ->get();

        return view('shop.index', compact('featuredProducts', 'categories'));
    }

    /**
     * Display all products with optional filtering.
     */
    public function products(Request $request)
    {
        $query = Product::where('is_active', true)->with('images', 'category');

        // Filter by category if provided
        if ($request->has('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Filter by search term if provided
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sort products
        $sort = $request->sort ?? 'newest';
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->paginate(12);
        $categories = Category::where('is_active', true)->get();

        return view('shop.products', compact('products', 'categories'));
    }

    /**
     * Display a specific product.
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with('images', 'category')
            ->firstOrFail();

        $relatedProducts = collect();

        if ($product->category_id) {
            $relatedProducts = Product::where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->where('is_active', true)
                ->with('images')
                ->take(4)
                ->get();
        }

        return view('shop.product', compact('product', 'relatedProducts'));
    }

    /**
     * Display products by category.
     */
    public function category($slug)
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $products = Product::where('category_id', $category->id)
            ->where('is_active', true)
            ->with('images')
            ->paginate(12);

        $categories = Category::where('is_active', true)->get();

        return view('shop.category', compact('category', 'products', 'categories'));
    }
}
