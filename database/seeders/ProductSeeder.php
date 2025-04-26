<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Smartphones products
        $smartphonesCategory = Category::where('name', 'Smartphones')->first();

        $smartphones = [
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'Apple iPhone 15 Pro with 256GB storage',
                'price' => 999.99,
                'quantity' => 50,
                'sku' => 'IP15P-256',
                'is_active' => true,
                'featured' => true,
            ],
            [
                'name' => 'Samsung Galaxy S23',
                'description' => 'Samsung Galaxy S23 with 128GB storage',
                'price' => 799.99,
                'quantity' => 75,
                'sku' => 'SGS23-128',
                'is_active' => true,
                'featured' => true,
            ],
            [
                'name' => 'Google Pixel 8',
                'description' => 'Google Pixel 8 with 128GB storage',
                'price' => 699.99,
                'quantity' => 60,
                'sku' => 'GP8-128',
                'is_active' => true,
                'featured' => false,
            ],
        ];

        foreach ($smartphones as $phone) {
            $product = Product::create([
                'name' => $phone['name'],
                'slug' => Str::slug($phone['name']),
                'description' => $phone['description'],
                'price' => $phone['price'],
                'quantity' => $phone['quantity'],
                'sku' => $phone['sku'],
                'is_active' => $phone['is_active'],
                'featured' => $phone['featured'],
                'category_id' => $smartphonesCategory->id,
            ]);

            // Add a product image
            ProductImage::create([
                'image' => 'products/'.Str::slug($phone['name']).'.jpg',
                'is_primary' => true,
                'product_id' => $product->id,
            ]);
        }

        // Laptops products
        $laptopsCategory = Category::where('name', 'Laptops')->first();

        $laptops = [
            [
                'name' => 'MacBook Pro 16"',
                'description' => 'Apple MacBook Pro 16" with M2 Pro chip',
                'price' => 2499.99,
                'quantity' => 30,
                'sku' => 'MBP16-M2P',
                'is_active' => true,
                'featured' => true,
            ],
            [
                'name' => 'Dell XPS 15',
                'description' => 'Dell XPS 15 with Intel Core i7',
                'price' => 1799.99,
                'quantity' => 45,
                'sku' => 'DXPS15-I7',
                'is_active' => true,
                'featured' => false,
            ],
            [
                'name' => 'Lenovo ThinkPad X1',
                'description' => 'Lenovo ThinkPad X1 Carbon with Intel Core i5',
                'price' => 1499.99,
                'quantity' => 55,
                'sku' => 'LTP-X1-I5',
                'is_active' => true,
                'featured' => false,
            ],
        ];

        foreach ($laptops as $laptop) {
            $product = Product::create([
                'name' => $laptop['name'],
                'slug' => Str::slug($laptop['name']),
                'description' => $laptop['description'],
                'price' => $laptop['price'],
                'quantity' => $laptop['quantity'],
                'sku' => $laptop['sku'],
                'is_active' => $laptop['is_active'],
                'featured' => $laptop['featured'],
                'category_id' => $laptopsCategory->id,
            ]);

            // Add a product image
            ProductImage::create([
                'image' => 'products/'.Str::slug($laptop['name']).'.jpg',
                'is_primary' => true,
                'product_id' => $product->id,
            ]);
        }

        // Men's clothing products
        $menCategory = Category::where('name', 'Men')->first();

        $menClothing = [
            [
                'name' => 'Classic Fit Dress Shirt',
                'description' => 'Men\'s classic fit dress shirt in white',
                'price' => 49.99,
                'quantity' => 100,
                'sku' => 'M-CFDS-W',
                'is_active' => true,
                'featured' => true,
            ],
            [
                'name' => 'Slim Fit Jeans',
                'description' => 'Men\'s slim fit jeans in dark blue',
                'price' => 59.99,
                'quantity' => 85,
                'sku' => 'M-SFJ-DB',
                'is_active' => true,
                'featured' => false,
            ],
            [
                'name' => 'Casual Blazer',
                'description' => 'Men\'s casual blazer in navy',
                'price' => 129.99,
                'quantity' => 40,
                'sku' => 'M-CB-N',
                'is_active' => true,
                'featured' => false,
            ],
        ];

        foreach ($menClothing as $clothing) {
            $product = Product::create([
                'name' => $clothing['name'],
                'slug' => Str::slug($clothing['name']),
                'description' => $clothing['description'],
                'price' => $clothing['price'],
                'quantity' => $clothing['quantity'],
                'sku' => $clothing['sku'],
                'is_active' => $clothing['is_active'],
                'featured' => $clothing['featured'],
                'category_id' => $menCategory->id,
            ]);

            // Add a product image
            ProductImage::create([
                'image' => 'products/'.Str::slug($clothing['name']).'.jpg',
                'is_primary' => true,
                'product_id' => $product->id,
            ]);
        }

        // Women's clothing products
        $womenCategory = Category::where('name', 'Women')->first();

        $womenClothing = [
            [
                'name' => 'Floral Print Dress',
                'description' => 'Women\'s floral print summer dress',
                'price' => 79.99,
                'quantity' => 70,
                'sku' => 'W-FPD',
                'is_active' => true,
                'featured' => true,
            ],
            [
                'name' => 'High-Waisted Jeans',
                'description' => 'Women\'s high-waisted skinny jeans',
                'price' => 69.99,
                'quantity' => 90,
                'sku' => 'W-HWJ',
                'is_active' => true,
                'featured' => false,
            ],
            [
                'name' => 'Cashmere Sweater',
                'description' => 'Women\'s cashmere sweater in beige',
                'price' => 149.99,
                'quantity' => 35,
                'sku' => 'W-CS-B',
                'is_active' => true,
                'featured' => true,
            ],
        ];

        foreach ($womenClothing as $clothing) {
            $product = Product::create([
                'name' => $clothing['name'],
                'slug' => Str::slug($clothing['name']),
                'description' => $clothing['description'],
                'price' => $clothing['price'],
                'quantity' => $clothing['quantity'],
                'sku' => $clothing['sku'],
                'is_active' => $clothing['is_active'],
                'featured' => $clothing['featured'],
                'category_id' => $womenCategory->id,
            ]);

            // Add a product image
            ProductImage::create([
                'image' => 'products/'.Str::slug($clothing['name']).'.jpg',
                'is_primary' => true,
                'product_id' => $product->id,
            ]);
        }
    }
}
