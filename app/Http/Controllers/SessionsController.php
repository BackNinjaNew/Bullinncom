<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['only' => ['create', 'store']]);
        $this->middleware('auth', ['only' => ['destroy']]);
    }

    public function create() {
        return view('auth.login');
    }

    public function store() {
        if(auth()->attempt(request(['email', 'password'])) == false) {
            return back()->withErrors(['message' => 'Correo electrónico o contraseña incorrectos.']);
        } else {
            if(auth()->user()->fk_type_user == 1) {
                return redirect()->route('products.index');
            } else {
                return redirect()->route('catalog.index');
            }
        }
    }

    public function destroy() {
        auth()->logout();
        return redirect()->to('/');
    }
}