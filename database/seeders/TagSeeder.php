<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            ['name' => 'New Arrival',     'type' => 'badge', 'order_column' => 1],
            ['name' => 'Best Seller',     'type' => 'badge', 'order_column' => 2],
            ['name' => 'Featured',        'type' => 'badge', 'order_column' => 3],
            ['name' => 'Sale',            'type' => 'badge', 'order_column' => 4],
            ['name' => 'Limited Edition', 'type' => 'badge', 'order_column' => 5],
            ['name' => 'Trending',        'type' => 'badge', 'order_column' => 6],
            ['name' => 'Eco Friendly',    'type' => 'badge', 'order_column' => 7],
            ['name' => 'Premium',         'type' => 'badge', 'order_column' => 8],
            ['name' => 'Clearance',       'type' => 'badge', 'order_column' => 9],
            ['name' => 'Exclusive',       'type' => 'badge', 'order_column' => 10],
        ];

        foreach ($tags as $tag) {
            $created = Tag::findOrCreate($tag['name'], $tag['type']);
            $created->order_column = $tag['order_column'];
            $created->save();
        }
    }
}
