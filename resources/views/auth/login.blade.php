@extends('layouts.app_inicio')

@section('title', 'Login')

@section('content')
<div class="block mx-auto my-12 p-8 bg-white w-1/3 border border-gray-400 rounded-lg shadow-lg">
    <h1 class="text-5xl font-bold text-center">Iniciar Sesión</h1>
    <form class="mt-4" method="POST" action="">
        @csrf
        <input type="email" class="border border-gray-200 rounded-md bg-gray-200 w-full text-lg placeholder-gray-400 p-2 my-2 focus:bg-white" placeholder="Correo Electrónico" id="email" name="email">
        <input type="password" class="border border-gray-200 rounded-md bg-gray-200 w-full text-lg placeholder-gray-400 p-2 my-2 focus:bg-white" placeholder="Contraseña" id="password" name="password">
        @error('message')
        <p class="border border-red-500 rounded-md bg-red-100 w-full text-red-600 p-2 my-2">{{ $message }}</p>
        @enderror
        <button type="submit" class="rounded-md bg-blue-600 w-full text-lg text-white font-bold p-2 my-3 hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-300"><i class="fa fa-sign-in-alt"></i> Ingresar</button>
    </form>
</div>
@endsection