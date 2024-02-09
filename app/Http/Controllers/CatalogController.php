<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Products;
use App\Models\Categories;
use Illuminate\Http\Request;
use Intervention\Image\Laravel\Facades\Image;

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
            ->orderBy('name', 'asc')
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
            ->where('code', 'like', '%' . $filter . '%')
            ->orwhere('category', 'like', '%' . $filter . '%')
            ->orwhere('name', 'like', '%' . $filter . '%')
            ->orwhere('brand', 'like', '%' . $filter . '%')
            ->orwhere('stock', 'like', '%' . $filter . '%')
            ->orwhere('price', 'like', '%' . $filter . '%')
            ->orderBy('name', 'asc')
            ->get();
        return view('client.catalog', compact('carts', 'products'));
    }

    public function store(Request $request)
    {
        $id_product = $request->post('id_product');
        $id_user = auth()->user()->id;
        $carts = Cart::join('products', 'products.id', '=', 'carts.fk_product')
            ->select('carts.*', 'products.stock')
            ->where('fk_product', '=', $id_product)
            ->where('fk_user', '=', $id_user)
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
            ->where('fk_user', '=', $id_user)
            ->orderBy('name', 'asc')
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
        return redirect()->route('catalog.cart')->with('warning', 'Producto eliminado del carrito de compras.');
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
        return redirect()->route('catalog.cart')->with('success', 'Producto actualizado en el carrito de compras.');
    }
}