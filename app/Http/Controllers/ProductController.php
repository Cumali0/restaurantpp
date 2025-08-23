<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Ürün listeleme
    public function index(Request $request)
    {
        $categories = Category::pluck('name','id');

        $query = Product::with('category');

        if ($request->filled('name')) {
            $query->where('name', 'like', "%{$request->name}%");
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->paginate(12)->withQueryString();

        return view('admin.products.index', compact('products', 'categories'));
    }

    // Yeni ürün ekleme
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        if($request->hasFile('image')){
            $data['img'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($data);

        return response()->json([
            'success' => 'Ürün kaydedildi!',
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'category_id' => $product->category_id,
                'category_name' => $product->category->name,
                'img' => $product->img
            ]
        ]);
    }

    // Ürün güncelleme
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        if($request->hasFile('image')){
            // Eski resmi sil
            if($product->img && Storage::disk('public')->exists($product->img)){
                Storage::disk('public')->delete($product->img);
            }
            $data['img'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return response()->json([
            'success' => 'Ürün güncellendi!',
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'category_id' => $product->category_id,
                'category_name' => $product->category->name,
                'img' => $product->img
            ]
        ]);
    }

    // Ürün silme
    public function destroy(Product $product)
    {
        if($product->img && Storage::disk('public')->exists($product->img)){
            Storage::disk('public')->delete($product->img);
        }

        $product->delete();

        return response()->json(['success' => 'Ürün silindi!']);
    }



    // Tüm kategorileri göster
    public function showMenu()
    {
        $categories = Category::all();
        return view('menu.index', compact('categories'));
    }

    // Belirli kategoriye ait ürünler
    public function categoryProducts($id)
    {
        $category = Category::findOrFail($id);
        $products = Product::where('category_id', $id)->get();

        // Burada artık menu.products view kullanılacak
        return view('menu.products', compact('category', 'products'));
    }
}
