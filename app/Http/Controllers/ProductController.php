<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
public function index(Request $request)
{
$query = Product::with('category');

// Filtreleme
if($request->name) $query->where('name','like','%'.$request->name.'%');
if($request->category) $query->where('category_id',$request->category);
if($request->min_price) $query->where('price','>=',$request->min_price);
if($request->max_price) $query->where('price','<=',$request->max_price);

$products = $query->paginate(12);
$categories = Category::pluck('name','id');

return view('admin.products.index',compact('products','categories'));
}

public function store(Request $request)
{
$request->validate([
'name'=>'required|string|max:255',
'price'=>'required|numeric|min:0',
'category_id'=>'required|exists:categories,id',
'image'=>'nullable|image|max:2048'
]);

$product = new Product();
$product->name = $request->name;
$product->description = $request->description;
$product->price = $request->price;
$product->category_id = $request->category_id;

if($request->hasFile('image')){
$path = $request->file('image')->store('products','public');
$product->image = $path;
}

$product->save();

return response()->json(['success'=>true,'message'=>'Ürün eklendi']);
}

public function edit($id)
{
$product = Product::findOrFail($id);
return response()->json($product);
}

public function update(Request $request,$id)
{
$product = Product::findOrFail($id);

$request->validate([
'name'=>'required|string|max:255',
'price'=>'required|numeric|min:0',
'category_id'=>'required|exists:categories,id',
'image'=>'nullable|image|max:2048'
]);

$product->name = $request->name;
$product->description = $request->description;
$product->price = $request->price;
$product->category_id = $request->category_id;

if($request->hasFile('image')){
if($product->image) Storage::disk('public')->delete($product->image);
$path = $request->file('image')->store('products','public');
$product->image = $path;
}

$product->save();

return response()->json(['success'=>true,'message'=>'Ürün güncellendi']);
}

public function destroy($id)
{
$product = Product::findOrFail($id);
if($product->image) Storage::disk('public')->delete($product->image);
$product->delete();

return response()->json(['success'=>true,'message'=>'Ürün silindi']);
}
}
