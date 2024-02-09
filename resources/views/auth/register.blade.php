@extends('layouts.app_inicio')

@section('title', 'Register')

@section('content')
<div class="block mx-auto my-12 p-8 bg-white w-1/3 border border-gray-400 rounded-lg shadow-lg">
    <h1 class="text-5xl font-bold text-center">Crear Cuenta</h1>
    <form class="mt-4" method="POST" action="">
        @csrf
        <input type="hidden" value="2" id="fk_type_user" name="fk_type_user">
        <input type="number" class="border border-gray-200 rounded-md bg-gray-200 w-full text-lg placeholder-gray-900 p-2 my-2 focus:bg-white" placeholder="Documento" id="document" name="document">
        @error('document')
        <p class="border border-red-500 rounded-md bg-red-100 w-full text-red-600 p-2 my-2">{{ $message }}</p>
        @enderror
        <input type="text" class="border border-gray-200 rounded-md bg-gray-200 w-full text-lg placeholder-gray-900 p-2 my-2 focus:bg-white" placeholder="Nombres" id="firstname" name="firstname">
        @error('firstname')
        <p class="border border-red-500 rounded-md bg-red-100 w-full text-red-600 p-2 my-2">{{ $message }}</p>
        @enderror
        <input type="text" class="border border-gray-200 rounded-md bg-gray-200 w-full text-lg placeholder-gray-900 p-2 my-2 focus:bg-white" placeholder="Apellidos" id="lastname" name="lastname">
        @error('lastname')
        <p class="border border-red-500 rounded-md bg-red-100 w-full text-red-600 p-2 my-2">{{ $message }}</p>
        @enderror
        <input type="email" class="border border-gray-200 rounded-md bg-gray-200 w-full text-lg placeholder-gray-900 p-2 my-2 focus:bg-white" placeholder="Correo Electrónico" id="email" name="email">
        @error('email')
        <p class="border border-red-500 rounded-md bg-red-100 w-full text-red-600 p-2 my-2">{{ $message }}</p>
        @enderror
        <input type="number" class="border border-gray-200 rounded-md bg-gray-200 w-full text-lg placeholder-gray-900 p-2 my-2 focus:bg-white" placeholder="Teléfono" id="phone" name="phone">
        @error('phone')
        <p class="border border-red-500 rounded-md bg-red-100 w-full text-red-600 p-2 my-2">{{ $message }}</p>
        @enderror
        <input type="text" class="border border-gray-200 rounded-md bg-gray-200 w-full text-lg placeholder-gray-900 p-2 my-2 focus:bg-white" placeholder="Dirección" id="address" name="address">
        @error('address')
        <p class="border border-red-500 rounded-md bg-red-100 w-full text-red-600 p-2 my-2">{{ $message }}</p>
        @enderror
        <input type="password" class="border border-gray-200 rounded-md bg-gray-200 w-full text-lg placeholder-gray-900 p-2 my-2 focus:bg-white" placeholder="Contraseña" id="password" name="password">
        @error('password')
        <p class="border border-red-500 rounded-md bg-red-100 w-full text-red-600 p-2 my-2">{{ $message }}</p>
        @enderror
        <button type="submit" class="rounded-md bg-green-600 w-full text-lg text-white font-bold p-2 my-3 hover:bg-green-500"><i class="fa fa-save"></i> Registrarse</button>
    </form>
</div>
@endsection