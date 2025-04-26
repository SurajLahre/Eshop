<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Electronic devices and gadgets',
                'is_active' => true,
            ],
            [
                'name' => 'Clothing',
                'description' => 'Fashion and apparel',
                'is_active' => true,
            ],
            [
                'name' => 'Home & Kitchen',
                'description' => 'Home appliances and kitchen essentials',
                'is_active' => true,
            ],
            [
                'name' => 'Books',
                'description' => 'Books and literature',
                'is_active' => true,
            ],
            [
                'name' => 'Sports & Outdoors',
                'description' => 'Sports equipment and outdoor gear',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'is_active' => $category['is_active'],
            ]);
        }

        // Create subcategories for Electronics
        $electronicsId = Category::where('name', 'Electronics')->first()->id;
        $electronicsSubcategories = [
            [
                'name' => 'Smartphones',
                'description' => 'Mobile phones and accessories',
                'is_active' => true,
                'parent_id' => $electronicsId,
            ],
            [
                'name' => 'Laptops',
                'description' => 'Laptops and notebooks',
                'is_active' => true,
                'parent_id' => $electronicsId,
            ],
            [
                'name' => 'Audio',
                'description' => 'Headphones, speakers, and audio equipment',
                'is_active' => true,
                'parent_id' => $electronicsId,
            ],
        ];

        foreach ($electronicsSubcategories as $subcategory) {
            Category::create([
                'name' => $subcategory['name'],
                'slug' => Str::slug($subcategory['name']),
                'description' => $subcategory['description'],
                'is_active' => $subcategory['is_active'],
                'parent_id' => $subcategory['parent_id'],
            ]);
        }

        // Create subcategories for Clothing
        $clothingId = Category::where('name', 'Clothing')->first()->id;
        $clothingSubcategories = [
            [
                'name' => 'Men',
                'description' => 'Men\'s clothing and accessories',
                'is_active' => true,
                'parent_id' => $clothingId,
            ],
            [
                'name' => 'Women',
                'description' => 'Women\'s clothing and accessories',
                'is_active' => true,
                'parent_id' => $clothingId,
            ],
            [
                'name' => 'Kids',
                'description' => 'Children\'s clothing and accessories',
                'is_active' => true,
                'parent_id' => $clothingId,
            ],
        ];

        foreach ($clothingSubcategories as $subcategory) {
            Category::create([
                'name' => $subcategory['name'],
                'slug' => Str::slug($subcategory['name']),
                'description' => $subcategory['description'],
                'is_active' => $subcategory['is_active'],
                'parent_id' => $subcategory['parent_id'],
            ]);
        }
    }
}
