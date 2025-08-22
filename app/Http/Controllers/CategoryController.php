<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $mode = $request->get('mode', 'index'); // index, create, edit
        $category = null;
        $categories = Category::orderBy('id', 'desc')->get();

        if ($mode === 'edit') {
            $id = $request->get('category');
            if (!$id) return redirect()->route('admin.categories.index');
            $category = Category::findOrFail($id);
        }

        return view('admin.categories.index', compact('mode', 'categories', 'category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Category::create([
            'name' => $request->name
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori başarıyla eklendi.');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update([
            'name' => $request->name
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori başarıyla güncellendi.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori başarıyla silindi.');
    }
}
