<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Products;
use App\Models\Sales;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('auth.client');
    }

    public function index()
    {
        $id_user = auth()->user()->id;
        $carts = Cart::where('fk_user', '=', $id_user)->sum('amount');
        $products = Products::join('categories', 'categories.id', '=', 'products.fk_category')
            ->select('products.*', 'categories.category')
            ->where('products.state', '=', 'Activo')
            ->where('products.stock', '>', 0)
            ->orderBy('products.name', 'asc')
            ->get();
        return view('client.catalog', compact('carts', 'products'));
    }

    public function search(Request $request)
    {
        $id_user = auth()->user()->id;
        $carts = Cart::where('fk_user', '=', $id_user)->sum('amount');
        $filter = $request->post('search');
        $products = Products::join('categories', 'categories.id', '=', 'products.fk_category')
            ->select('products.*', 'categories.category')
            ->where('products.state', '=', 'Activo')
            ->where('products.stock', '>', 0)
            ->where(function($query) use ($filter) {
                $query
                ->where('products.code', 'like', '%' . $filter . '%')
                ->orwhere('categories.category', 'like', '%' . $filter . '%')
                ->orwhere('products.name', 'like', '%' . $filter . '%')
                ->orwhere('products.brand', 'like', '%' . $filter . '%')
                ->orwhere('products.stock', 'like', '%' . $filter . '%')
                ->orwhere('products.price', 'like', '%' . $filter . '%');
            })
            ->orderBy('products.name', 'asc')
            ->get();
        return view('client.catalog', compact('carts', 'products'));
    }

    public function store(Request $request)
    {
        $id_product = $request->post('id_product');
        $id_user = auth()->user()->id;
        $carts = Cart::join('products', 'products.id', '=', 'carts.fk_product')
            ->select('carts.*', 'products.stock')
            ->where('products.state', '=', 'Activo')
            ->where('products.stock', '>', 0)
            ->where('carts.fk_product', '=', $id_product)
            ->where('carts.fk_user', '=', $id_user)
            ->first();
        $alert = 'success';
        $message = 'Producto agregado al carrito de compras.';
        if ($carts == null) {
            Cart::create(['fk_product' => $id_product, 'fk_user' => $id_user, 'amount' => 1]);
        } else {
            $amount = $carts->amount;
            $stock = $carts->stock;
            if ($amount >= $stock) {
                $alert = 'warning';
                $message = 'Alcanzaste el limite de compra para este producto.';
            } else {
                $amount += 1;
                Cart::where('fk_product', '=', $id_product)->where('fk_user', '=', $id_user)->update(['amount' => $amount]);
            }
        }
        return redirect()->route('catalog.index')->with($alert, $message);
    }

    public function cart()
    {
        $id_user = auth()->user()->id;
        $carts = Cart::where('fk_user', '=', $id_user)->sum('amount');
        $products = Products::join('categories', 'categories.id', '=', 'products.fk_category')
            ->join('carts', 'carts.fk_product', '=', 'products.id')
            ->select('products.*', 'categories.category', 'carts.amount')
            ->where('products.state', '=', 'Activo')
            ->where('products.stock', '>', 0)
            ->where('carts.fk_user', '=', $id_user)
            ->orderBy('products.name', 'asc')
            ->get();
        $total = 0;
        foreach ($products as $item) {
            $total += ($item->amount * $item->price);
        }
        return view('client.cart_products', compact('carts', 'products', 'total'));
    }

    public function destroy($id)
    {
        $carts = Cart::select()->where('fk_product', '=', $id)->first();
        $carts->delete();
        return redirect()->route('catalog.cart');
    }

    public function amount(Request $request)
    {
        $id_product = $request->post('id_product');
        $amount = $request->post('amount');
        $id_user = auth()->user()->id;
        if (isset($_POST['minus'])) {
            $amount -= 1;
        }
        if (isset($_POST['plus'])) {
            $amount += 1;
        }
        Cart::where('fk_product', '=', $id_product)->where('fk_user', '=', $id_user)->update(['amount' => $amount]);
        return redirect()->route('catalog.cart');
    }

    public function shopping()
    {
        $id_user = auth()->user()->id;
        $carts = Cart::where('fk_user', '=', $id_user)->sum('amount');
        $sales = Sales::select('invoice', 'created_at')
            ->distinct('invoice')
            ->where('fk_user', '=', $id_user)
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
        return view('client.shopping', compact('carts', 'sales'));
    }

    public function search_buys(Request $request)
    {
        $filter = $request->post('search');
        $id_user = auth()->user()->id;
        $carts = Cart::where('fk_user', '=', $id_user)->sum('amount');
        $sales = Sales::select('invoice', 'created_at')
            ->distinct('invoice')
            ->where('fk_user', '=', $id_user)
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
        return view('client.shopping', compact('carts', 'sales'));
    }

    public function detail_buys($invoice)
    {
        $id_user = auth()->user()->id;
        $carts = Cart::where('fk_user', '=', $id_user)->sum('amount');
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
        return view('client.detail_buys', compact('carts', 'sales', 'invoice', 'total'));
    }
}