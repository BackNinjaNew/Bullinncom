<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductEditRequest;
use App\Models\Cart;
use App\Models\Products;
use App\Models\Categories;
use App\Models\Sales;
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
        foreach($products as $item) {
            if (Sales::select()->where('fk_product', '=', $item->id)->first()) {
                $item->sold = true;
            } else {
                $item->sold = false;
            }
        }
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
        foreach($products as $item) {
            if (Sales::select()->where('fk_product', '=', $item->id)->first()) {
                $item->sold = true;
            } else {
                $item->sold = false;
            }
        }
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
        $products->state = $request->post('state');
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
        return redirect()->route('products.index')->with('warning', 'Producto actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $carts = Cart::select()->where('fk_product', '=', $id)->get();
        if (count($carts) > 0) {
            Cart::where('fk_product', '=', $id)->delete();
        }
        $products = Products::find($id);
        if ($products->delete()) {
            unlink($products->image);
        }
        return redirect()->route('products.index')->with('danger', 'Producto eliminado exitosamente.');
    }

    public function activate(Request $request)
    {
        $id_product = $request->post('id_product');
        $carts = Cart::select()->where('fk_product', '=', $id_product)->get();
        if (count($carts) > 0) {
            Cart::where('fk_product', '=', $id_product)->delete();
        }
        if (isset($_POST['activate'])) {
            $activate = 'Activo';
        }
        if (isset($_POST['inactivate'])) {
            $activate = 'Inactivo';
        }
        Products::where('id', '=', $id_product)->update(['state' => $activate]);
        return redirect()->route('products.index');
    }

    public function sales()
    {
        $sales = Sales::select('invoice', 'created_at')
            ->distinct('invoice')
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        foreach ($sales as $item) {
            $amount = Sales::select()->where('invoice', '=', $item->invoice)->sum('amount');
            $item->amount = $amount;
            $products = Sales::join('products', 'products.id', '=', 'sales.fk_product')
                ->select('products.price', 'sales.amount')
                ->where('sales.invoice', '=', $item->invoice)
                ->get();
            $total = 0;
            foreach ($products as $product) {
                $total += ($product->amount * $product->price);
            }
            $item->total = $total;
        }
        return view('admin.sales', compact('sales'));
    }

    public function search_sell(Request $request)
    {
        $filter = $request->post('search');
        $sales = Sales::select('invoice', 'created_at')
            ->distinct('invoice')
            ->where('invoice', '=', $filter)
            ->orderBy('created_at', 'desc')
            ->paginate(1);
        foreach ($sales as $item) {
            $amount = Sales::select()->where('invoice', '=', $item->invoice)->sum('amount');
            $item->amount = $amount;
            $products = Sales::join('products', 'products.id', '=', 'sales.fk_product')
                ->select('products.price', 'sales.amount')
                ->where('sales.invoice', '=', $item->invoice)
                ->get();
            $total = 0;
            foreach ($products as $product) {
                $total += ($product->amount * $product->price);
            }
            $item->total = $total;
        }
        return view('admin.sales', compact('sales'));
    }

    public function detail_sell($invoice)
    {
        $sales = Sales::join('products', 'products.id', '=', 'sales.fk_product')
            ->join('categories', 'categories.id', '=', 'products.fk_category')
            ->select('sales.*', 'products.*', 'categories.category')
            ->where('sales.invoice', '=', $invoice)
            ->orderBy('products.name', 'asc')
            ->get();
        $total = 0;
        foreach ($sales as $item) {
            $total += ($item->amount * $item->price);
        }
        return view('admin.detail_sell', compact('sales', 'invoice', 'total'));
    }
}