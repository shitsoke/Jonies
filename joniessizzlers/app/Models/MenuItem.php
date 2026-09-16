<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'description',
        'price',
        'image_path',
    ];

    public static function seedDefaultMenu(): void
    {
        if (self::count() > 0) {
            return;
        }

        self::insert([
            [
                'title' => 'All Time Favorites',
                'category' => 'all-time-favorites',
                'description' => 'Customer favorites featuring juicy, sizzling, and rich savory plates.',
                'price' => '299.00',
                'image_path' => 'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'title' => 'House of Specialties',
                'category' => 'house-of-specialties',
                'description' => 'Signature specialties with big flavor, premium ingredients, and a memorable finish.',
                'price' => '349.00',
                'image_path' => 'https://images.unsplash.com/photo-1547592180-85f173990554?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'title' => 'Seafoods',
                'category' => 'seafoods',
                'description' => 'Fresh seafood favorites loaded with flavor and grilled to perfection.',
                'price' => '399.00',
                'image_path' => 'https://images.unsplash.com/photo-1559847844-5315695dadae?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'title' => 'Dessert',
                'category' => 'dessert',
                'description' => 'Sweet, cold, and creamy treats made to finish the meal on a high note.',
                'price' => '129.00',
                'image_path' => 'https://images.unsplash.com/photo-1551024601-bec78aea704b?auto=format&fit=crop&w=900&q=80',
            ],
            [
                'title' => 'Shareable Flaming Bundles',
                'category' => 'shareable-flaming-bundles',
                'description' => 'Perfect for groups, shareable platters with dramatic sizzling presentation.',
                'price' => '599.00',
                'image_path' => 'https://images.unsplash.com/photo-1525351484163-7529414344d8?auto=format&fit=crop&w=900&q=80',
            ],
        ]);
    }
}
