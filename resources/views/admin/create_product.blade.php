@extends('layouts.app_products')

@section('title', 'Add Product')

@section('content')
<div class="block mx-auto my-12 p-8 bg-white w-1/3 border border-gray-400 rounded-lg shadow-lg">
    <h1 class="text-5xl font-bold text-center">Agregar Producto</h1>
    <form class="mt-4" method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" value="Activo" id="state" name="state">
        <input type="number" class="border border-gray-200 rounded-md bg-gray-200 w-full text-lg placeholder-gray-400 p-2 my-2 focus:bg-white" placeholder="Código" id="code" name="code">
        @error('code')
        <p class="border border-red-500 rounded-md bg-red-100 w-full text-red-600 p-2 my-2">{{ $message }}</p>
        @enderror
        <select class="border border-gray-200 rounded-md bg-gray-200 w-full text-lg placeholder-gray-400 p-2 my-2 focus:bg-white" id="category" name="category">
            <option value="">Seleccione Categoria...</option>
            @foreach ($categories as $item)
                <option value="{{ $item->id }}"> {{ $item->category }} </option>
            @endforeach
        </select>
        @error('category')
        <p class="border border-red-500 rounded-md bg-red-100 w-full text-red-600 p-2 my-2">{{ $message }}</p>
        @enderror
        <input type="text" class="border border-gray-200 rounded-md bg-gray-200 w-full text-lg placeholder-gray-400 p-2 my-2 focus:bg-white" placeholder="Nombre" id="name" name="name">
        @error('name')
        <p class="border border-red-500 rounded-md bg-red-100 w-full text-red-600 p-2 my-2">{{ $message }}</p>
        @enderror
        <textarea rows="3" class="border border-gray-200 rounded-md bg-gray-200 w-full text-lg placeholder-gray-400 p-2 my-2 focus:bg-white text-justify" placeholder="Descripción" id="description" name="description"></textarea>
        @error('description')
        <p class="border border-red-500 rounded-md bg-red-100 w-full text-red-600 p-2 my-2">{{ $message }}</p>
        @enderror
        <input type="text" class="border border-gray-200 rounded-md bg-gray-200 w-full text-lg placeholder-gray-400 p-2 my-2 focus:bg-white" placeholder="Marca" id="brand" name="brand">
        @error('brand')
        <p class="border border-red-500 rounded-md bg-red-100 w-full text-red-600 p-2 my-2">{{ $message }}</p>
        @enderror
        <input type="number" class="border border-gray-200 rounded-md bg-gray-200 w-full text-lg placeholder-gray-400 p-2 my-2 focus:bg-white" placeholder="Existencias" id="stock" name="stock">
        @error('stock')
        <p class="border border-red-500 rounded-md bg-red-100 w-full text-red-600 p-2 my-2">{{ $message }}</p>
        @enderror
        <input type="number" class="border border-gray-200 rounded-md bg-gray-200 w-full text-lg placeholder-gray-400 p-2 my-2 focus:bg-white" placeholder="Precio" id="price" name="price">
        @error('price')
        <p class="border border-red-500 rounded-md bg-red-100 w-full text-red-600 p-2 my-2">{{ $message }}</p>
        @enderror
        <input type="file" class="rounded-md w-full text-lg placeholder-gray-200 p-2 my-2" id="image" name="image">
        @error('image')
        <p class="border border-red-500 rounded-md bg-red-100 w-full text-red-600 p-2 my-2">{{ $message }}</p>
        @enderror
        <div class="flex justify-center">
            <button type="submit" class="rounded-md bg-blue-600 w-full text-lg text-white font-bold p-2 my-3 hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-300"><i class="fa fa-save"></i> Guardar</button>
            &nbsp;&nbsp;&nbsp;
            <a href="{{ route('products.index') }}" class="rounded-md bg-red-600 w-full text-lg text-white text-center font-bold p-2 my-3 hover:bg-red-500 focus:ring-4 focus:outline-none focus:ring-red-300"><i class="fa fa-ban"></i> Cancelar</a>
        </div>
    </form>
</div>
@endsection