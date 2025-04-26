<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category', 'images')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'sku' => 'required|string|max:100|unique:products',
            'is_active' => 'boolean',
            'featured' => 'boolean',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Create product
        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'quantity' => $request->quantity,
            'sku' => $request->sku,
            'is_active' => $request->has('is_active'),
            'featured' => $request->has('featured'),
            'category_id' => $request->category_id,
        ]);

        // Handle image uploads
        if ($request->hasFile('images')) {
            $isPrimary = true; // First image is primary
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'is_primary' => $isPrimary,
                ]);

                $isPrimary = false; // Subsequent images are not primary
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('category', 'images')->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::with('images')->findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'sku' => 'required|string|max:100|unique:products,sku,' . $product->id,
            'is_active' => 'boolean',
            'featured' => 'boolean',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Update product
        $product->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'quantity' => $request->quantity,
            'sku' => $request->sku,
            'is_active' => $request->has('is_active'),
            'featured' => $request->has('featured'),
            'category_id' => $request->category_id,
        ]);

        // Handle image uploads
        if ($request->hasFile('images')) {
            // If there are no existing images, set the first new one as primary
            $isPrimary = $product->images->isEmpty();

            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'is_primary' => $isPrimary,
                ]);

                $isPrimary = false; // Subsequent images are not primary
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);

        // Delete associated images from storage
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image);
            $image->delete();
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    /**
     * Delete a product image.
     */
    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);
        $productId = $image->product_id;

        // Delete the image file from storage
        Storage::disk('public')->delete($image->image);

        // If this was the primary image, set another image as primary if available
        if ($image->is_primary) {
            $nextImage = ProductImage::where('product_id', $productId)
                ->where('id', '!=', $id)
                ->first();

            if ($nextImage) {
                $nextImage->update(['is_primary' => true]);
            }
        }

        $image->delete();

        return redirect()->back()->with('success', 'Image deleted successfully!');
    }
}
