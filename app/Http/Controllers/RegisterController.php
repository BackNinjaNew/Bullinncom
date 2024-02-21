<?php

namespace App\Http\Controllers;

use App\Models\User;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function create() {
        return view('auth.register');
    }

    public function store() {
        $user = User::create(request(['fk_type_user', 'document', 'firstname', 'lastname', 'email', 'phone', 'address', 'password']));
        auth()->login($user);
        return redirect()->route('catalog.index');
    }
}