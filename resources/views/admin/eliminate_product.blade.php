@extends('layouts.app_products')

@section('title', 'Delete Product')

@section('content')
<div class="bg-gray-100 relative overflow-x-auto sm:rounded-lg px-16 pt-10 pb-5">
    <h1 class="text-5xl font-bold text-center">Eliminar Producto</h1>
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 mt-4 rounded relative" role="alert">
        <h2 class="text-3xl font-bold text-center">¿ Confirma que desea eliminar este producto ?</h2>
        <br>
        <table class="w-full text-md text-left rtl:text-right text-gray-600 dark:text-gray-400">
            <thead class="text-lg text-white uppercase bg-blue-500 dark:bg-blue-500 dark:text-white">
                <tr class="text-center">
                    <th scope="col" class="px-6 py-3"><span>Imagen</span></th>
                    <th scope="col" class="px-6 py-3"><span>Código</span></th>
                    <th scope="col" class="px-6 py-3"><span>Categoria</span></th>
                    <th scope="col" class="px-6 py-3"><span>Nombre</span></th>
                    <th scope="col" class="px-6 py-3"><span>Marca</span></th>
                    <th scope="col" class="px-6 py-3"><span>Existencias</span></th>
                    <th scope="col" class="px-6 py-3"><span>Precio</span></th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-center bg-blue-200 border-2 dark:bg-blue-700 dark:border-blue-700 hover:bg-blue-300 dark:hover:bg-blue-700">
                    <td>
                        <div class="flex justify-center items-center">
                            <img src="{{ asset($products->image) }}" alt="" class="img-fluid img-thumbnail" width="80px">
                        </div>
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $products->code }}</td>
                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $products->category }}</td>
                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $products->name }}</td>
                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $products->brand }}</td>
                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $products->stock }}</td>
                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $products->price }}</td>
                </tr>
            </tbody>
        </table>
        <form class="mt-4" method="POST" action="{{ route('products.destroy', $products->id) }}">
            @csrf
            @method("DELETE")
            <div class="flex justify-center">
                <button type="submit" class="rounded-md bg-green-600 w-1/6 text-lg text-white font-bold p-2 my-3 hover:bg-green-500"><i class="fa fa-check"></i> Confirmar</button>
                &nbsp;&nbsp;&nbsp;
                <a href="{{ route('products.index') }}" class="rounded-md bg-red-600 w-1/6 text-lg text-white text-center font-bold p-2 my-3 hover:bg-red-500"><i class="fa fa-ban"></i> Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection