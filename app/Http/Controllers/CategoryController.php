<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::pluck('name', 'id');
        return view('admin.categories.index', compact('categories'));
    }
}
