<?php

// Create a blank image
$width = 800;
$height = 600;
$image = imagecreatetruecolor($width, $height);

// Set background color to light gray
$bg_color = imagecolorallocate($image, 240, 240, 240);
imagefill($image, 0, 0, $bg_color);

// Set text color to dark gray
$text_color = imagecolorallocate($image, 50, 50, 50);

// Add some text
$text = "Sample Product Image";
$font_size = 5;
$text_width = imagefontwidth($font_size) * strlen($text);
$text_height = imagefontheight($font_size);
$x = ($width - $text_width) / 2;
$y = ($height - $text_height) / 2;
imagestring($image, $font_size, $x, $y, $text, $text_color);

// Save the image
$product_image_path = 'storage/app/public/products/sample_product.jpg';
imagejpeg($image, $product_image_path);

// Create a category image
$category_image_path = 'storage/app/public/categories/sample_category.jpg';
imagejpeg($image, $category_image_path);

// Free memory
imagedestroy($image);

echo "Test images created at:\n";
echo "- $product_image_path\n";
echo "- $category_image_path\n";
