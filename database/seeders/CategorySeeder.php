<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create root categories
        $electronics = Category::create([
            'name' =>['en' => 'Electronics','ar' => 'الإلكترونيات'],
             'status' => true]);
        $fashion = Category::create([
            'name' =>[
            'en' => 'Fashion',
            'ar' => 'الموضة'
        ], 'status' => true]);

        // Create child categories for Electronics
        $phones = Category::create([
            'name' =>[
            'en' => 'Phones',
            'ar' => 'الهاتف'
        ], 'status' => true, 'parent_id' => $electronics->id]);
        $laptops = Category::create([
            'name' =>[
            'en' => 'Laptops',
            'ar' => 'أجهزة الكمبيوتر'
        ], 'status' => true, 'parent_id' => $electronics->id]);

        // Create child categories for Fashion
        $mensClothing = Category::create([
            'name' =>[
            'en' => "Men's Clothing",
            'ar' => "ملابس الرجال"
        ], 'status' => true, 'parent_id' => $fashion->id]);
        $womensClothing = Category::create([
            'name' =>[
            'en' => "Women's Clothing",
            'ar' => "ملابس النساء"
        ], 'status' => true, 'parent_id' => $fashion->id]);
    }
}
