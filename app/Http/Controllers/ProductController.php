<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    // index
    public function index(Request $request)
    {
        // get products with pagination
        $products = Product::with('category')
            ->where('name', 'like', '%'.$request->search.'%')
            ->paginate(10);
        return view('pages.product.index', compact('products'));
    }

    // create
    public function create()
    {
        $categories = Category::all();
        return view('pages.product.create', compact('categories'));
    }

    // store
    public function store(Request $request)
    {
        $filename = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/products', $filename);

        $product = new Product;
        $product->name = $request->name;
        $product->price = (int) $request->price;
        $product->stock = (int) $request->stock;
        $product->category_id = $request->category_id;
        $product->image = $filename;
        $product->save();

        return redirect()->route('product.index')->with('success', 'Product created successfully');
    }

    // // // show
    // // public function show($id)
    // // {
    // //     return view('pages.dashboard');
    // // }

    // edit
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('pages.product.edit', compact('product', 'categories'));
    }

    // update
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($request->image) {
            $filename = time() . '.' . $request->image->extension();
            $request->image->storeAs('public/products', $filename);
        } else {
            $filename = $request->old_image;
        }

        $product->name = $request->name;
        $product->price = (int) $request->price;
        $product->stock = (int) $request->stock;
        $product->category_id = $request->category_id;
        $product->image = $filename;
        $product->update();

        return redirect()->route('product.index')->with('success', 'Product updated successfully');
    }

    // destroy
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product deleted successfully');
    }
}
