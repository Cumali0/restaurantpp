<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class MenuController extends Controller
{
    // Tüm kategorileri göster
    public function index()
    {
        $categories = Category::all();
        return view('menu.index', compact('categories'));
    }

    // Seçilen kategoriye ait ürünleri göster
    public function categoryProducts($id)
    {
        $category = Category::findOrFail($id);
        $products = Product::where('category_id', $id)->get();
        return view('menu.products', compact('category', 'products'));
    }
}
