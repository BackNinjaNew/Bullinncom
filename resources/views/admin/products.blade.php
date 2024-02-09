@extends('layouts.app_products')

@section('title', 'Products')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css"/>
<div class="row px-16">
    <h1 class="text-5xl font-bold text-center pt-10 pb-10">Lista de Productos</h1>
    @if (count($products) > 0)
    <form method="POST" action="{{ route('products.search') }}">
        @csrf
        <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between pb-5">
            <div>
                <a href="{{ route('products.create') }}" class="rounded-md bg-green-600 w-full text-lg text-white font-bold py-2 px-4 hover:bg-green-500"><i class="fa fa-plus"></i> Agregar Producto</a>
            </div>
            <div class="relative w-1/6">
                <input type="number" id="search" name="search" class="block p-2.5 w-full z-20 font-bold text-sm text-gray-900 bg-white rounded-lg border-s-gray-200 border-s-2 border border-gray-500 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-s-gray-500 dark:border-gray-600 dark:placeholder-gray-500 dark:text-white dark:focus:border-blue-500" placeholder="Buscar Código..." required>
                <button type="submit" class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-blue-600 rounded-e-lg border border-blue-600 hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-600 dark:focus:ring-blue-500">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                    <span class="sr-only">Search</span>
                </button>
            </div>
        </div>
    </form>
    <div>
        @if ($message = Session::get('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">{{ $message }}</strong>
        </div>
        @endif
    </div>
    <div class="bg-gray-100 relative overflow-x-auto sm:rounded-lg pt-5 pb-10">
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
                    <th scope="col" class="px-6 py-3"><span>Acciones</span></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $item)
                <tr class="text-center bg-blue-200 border-2 dark:bg-blue-700 dark:border-blue-700 hover:bg-blue-300 dark:hover:bg-blue-700">
                    <td>
                        <div class="flex justify-center items-center">
                            <a data-modal-target="default-modal-{{ $item->id }}" data-modal-toggle="default-modal-{{ $item->id }}" class="bg-white rounded-t-lg" type="button">
                                <img src="{{ asset($item->image) }}" alt="" class="img-fluid img-thumbnail" width="80px">
                            </a>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $item->code }}</td>
                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $item->category }}</td>
                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $item->name }}</td>
                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $item->brand }}</td>
                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $item->stock }}</td>
                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $item->price }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('products.edit', $item->id) }}" class="rounded-md bg-yellow-400 w-full text-lg text-white text-center font-bold p-2 my-3 hover:bg-yellow-300"><i class="fa fa-edit"></i></a>
                        &nbsp;&nbsp;&nbsp;
                        <a href="{{ route('products.show', $item->id) }}" class="rounded-md bg-red-600 w-full text-lg text-white text-center font-bold p-2 my-3 hover:bg-red-500"><i class="fa fa-trash-alt"></i></a>
                    </td>
                </tr>
                <!-- Main modal -->
                <div id="default-modal-{{ $item->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <!-- Modal header -->
                            <div class="flex items-center justify-center p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-3xl font-semibold text-gray-900 dark:text-white">{{ $item->name }}</h3>
                            </div>
                            <div class="flex items-center justify-center p-4 md:p-5 border-b rounded-t dark:border-gray-600">   
                                <img src="{{ asset($item->image) }}" alt="" width="200px"/>
                            </div>
                            <!-- Modal body -->
                            <div class="p-4 md:p-5 space-y-4">
                                <p class="text-center leading-relaxed text-gray-700 dark:text-gray-400 text-xl"><strong>Descripción:</strong></p>
                                <p class="text-justify leading-relaxed text-gray-700 dark:text-gray-400">{{ $item->description }}</p>
                            </div>
                            <!-- Modal footer -->
                            <div class="flex items-center justify-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                                <button data-modal-hide="default-modal-{{ $item->id }}" type="button" class="text-white bg-blue-600 hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-center text-sm px-4 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-600 dark:focus:ring-blue-500"><i class="fa fa-undo"></i> Regresar</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
        <br>
        <div class="row">
            <div class="col-md-12">
                {{ $products->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
    @else
    <h1 class="text-xl font-bold text-center pt-5 pb-10">No se encontraron resultados...</h1>
    <form method="POST" action="{{ route('products.search') }}">
        @csrf
        <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-center pb-5">
            <div>
                <a href="{{ route('products.create') }}" class="rounded-md bg-green-600 w-full text-lg text-white font-bold py-2 px-4 hover:bg-green-500"><i class="fa fa-plus"></i> Agregar Producto</a>
            </div>
        </div>
    </form>
    @endif
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
@endsection