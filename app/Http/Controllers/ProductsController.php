<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductEditRequest;
use App\Models\Products;
use App\Models\Categories;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.admin');
    }

    public function index()
    {
        $products = Products::join('categories', 'categories.id', '=', 'products.fk_category')
            ->select('products.*', 'categories.category')
            ->orderBy('name', 'asc')
            ->paginate(5);
        return view('admin.products', compact('products'));
    }

    public function search(Request $request)
    {
        $filter = $request->post('search');
        $products = Products::join('categories', 'categories.id', '=', 'products.fk_category')
            ->select('products.*', 'categories.category')
            ->where('code', '=', $filter)
            ->orderBy('name', 'asc')
            ->paginate(1);
        return view('admin.products', compact('products'));
    }

    public function create()
    {
        $categories = Categories::all();
        return view('admin.create_product', compact('categories'));
    }

    public function store(ProductCreateRequest $request)
    {
        $products = new Products;
        $products->code = $request->post('code');
        $products->fk_category = $request->post('category');
        $products->name = $request->post('name');
        $products->description = $request->post('description');
        $products->brand = $request->post('brand');
        $products->stock = $request->post('stock');
        $products->price = $request->post('price');
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $name = $request->post('code') . '.' . $ext;
            $path = public_path('images/products/' . $name);
            $url = 'images/products/' . $name;
            Image::read($file->getRealPath())
                ->resize(300, 300, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save($path);
            $products->image = $url;
        }
        $products->save();
        return redirect()->route('products.index')->with('success', 'Producto agregado exitosamente.');
    }

    public function edit($id)
    {
        $categories = Categories::all();
        $products = Products::find($id);
        return view('admin.edit_product', compact('categories', 'products'));
    }

    public function update(ProductEditRequest $request, $id)
    {
        $products = Products::find($id);
        $products->code = $request->post('code');
        $products->fk_category = $request->post('category');
        $products->name = $request->post('name');
        $products->description = $request->post('description');
        $products->brand = $request->post('brand');
        $products->stock = $request->post('stock');
        $products->price = $request->post('price');
        $products->save();
        return redirect()->route('products.index')->with('success', 'Producto actualizado exitosamente.');
    }

    public function show($id)
    {
        $products = Products::join('categories', 'categories.id', '=', 'products.fk_category')
            ->select('products.*', 'categories.category')
            ->where('products.id', '=', $id)
            ->first();
        return view('admin.eliminate_product', compact('products'));
    }

    public function destroy($id)
    {
        $products = Products::find($id);
        if ($products->delete()) {
            unlink($products->image);
        }
        return redirect()->route('products.index')->with('success', 'Producto eliminado exitosamente.');
    }
}