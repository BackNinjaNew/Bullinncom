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
                <a href="{{ route('products.create') }}" type="button" class="rounded-md bg-blue-600 w-full text-lg text-white font-bold py-2 px-4 hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-300"><i class="fa fa-plus"></i> Agregar Producto</a>
            </div>
            <div class="relative w-1/6">
                <input type="number" id="search" name="search" class="block p-2.5 w-full z-20 font-bold text-sm text-gray-900 bg-white rounded-lg border-s-gray-200 border-s-2 border border-gray-500 focus:ring-blue-500 focus:border-blue-500" placeholder="Buscar Código..." required>
                <button type="submit" class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-blue-600 rounded-e-lg border border-blue-600 hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                    <span class="sr-only">Search</span>
                </button>
            </div>
        </div>
    </form>
    <div class="text-center">
        @if ($message = Session::get('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">{{ $message }}</strong>
        </div>
        @elseif ($message = Session::get('warning'))
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">{{ $message }}</strong>
        </div>
        @elseif ($message = Session::get('danger'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">{{ $message }}</strong>
        </div>
        @endif
    </div>
    <div class="bg-gray-100 relative overflow-x-auto sm:rounded-lg pt-5 pb-10">
        <table class="w-full text-md text-left rtl:text-right text-gray-600">
            <thead class="text-lg text-white uppercase bg-blue-500">
                <tr class="text-center">
                    <th scope="col" class="px-6 py-3"><span>Imagen</span></th>
                    <th scope="col" class="px-6 py-3"><span>Código</span></th>
                    <th scope="col" class="px-6 py-3"><span>Categoria</span></th>
                    <th scope="col" class="px-6 py-3"><span>Nombre</span></th>
                    <th scope="col" class="px-6 py-3"><span>Marca</span></th>
                    <th scope="col" class="px-6 py-3"><span>Existencias</span></th>
                    <th scope="col" class="px-6 py-3"><span>Precio</span></th>
                    <th scope="col" class="px-6 py-3"><span>Acciones</span></th>
                    <th scope="col" class="px-6 py-3"><span>Estado</span></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $item)
                <tr class="text-center bg-blue-300 border-2 hover:bg-blue-400">
                    <td>
                        <div class="flex justify-center items-center">
                            <a data-modal-target="imgModal-{{ $item->id }}" data-modal-toggle="imgModal-{{ $item->id }}" class="bg-white">
                                <img src="{{ asset($item->image) }}" alt="" class="img-fluid img-thumbnail" width="80px">
                            </a>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-900">{{ $item->code }}</td>
                    <td class="px-6 py-4 font-bold text-gray-900">{{ $item->category }}</td>
                    <td class="px-6 py-4 font-bold text-gray-900">{{ $item->name }}</td>
                    <td class="px-6 py-4 font-bold text-gray-900">{{ $item->brand }}</td>
                    <td class="px-6 py-4 font-bold text-gray-900">{{ $item->stock }}</td>
                    <td class="px-6 py-4 font-bold text-gray-900">{{ $item->price }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('products.edit', $item->id) }}" type="button" class="rounded-md bg-yellow-500 w-9 text-lg text-white text-center font-bold p-2 my-3 hover:bg-yellow-400 focus:ring-4 focus:outline-none focus:ring-yellow-300"><i class="fa fa-edit"></i></a>
                        &nbsp;&nbsp;&nbsp;
                        @if (!$item->sold && $item->state == 'Activo')
                        <button data-modal-target="deleteModal-{{ $item->id }}" data-modal-toggle="deleteModal-{{ $item->id }}" class="rounded-md bg-red-600 w-9 text-lg text-white text-center font-bold p-2 my-3 hover:bg-red-500 focus:ring-4 focus:outline-none focus:ring-red-300"><i class="fa fa-trash-alt"></i></button>
                        @else
                        <button data-modal-target="deleteModal-{{ $item->id }}" data-modal-toggle="deleteModal-{{ $item->id }}" class="rounded-md bg-red-400 w-9 text-lg text-white text-center font-bold p-2 my-3" disabled><i class="fa fa-trash-alt"></i></button>
                        @endif
                        &nbsp;&nbsp;&nbsp;
                    </td>
                    <td class="px-6 py-4">
                        <form method="POST" action="{{ route('products.activate') }}">
                            @csrf
                            <input type="hidden" value="{{ $item->id }}" id="id_product" name="id_product">
                            @if ($item->state == 'Activo')
                            <button type="submit" name="inactivate" class="rounded-md bg-green-600 w-9 text-lg text-white text-center font-bold p-2 my-3 hover:bg-green-500 focus:ring-4 focus:outline-none focus:ring-green-300"><i class="fa fa-eye"></i></button>
                            @else
                            <button type="submit" name="activate" class="rounded-md bg-red-600 w-9 text-lg text-white text-center font-bold p-2 my-3 hover:bg-red-500 focus:ring-4 focus:outline-none focus:ring-red-300"><i class="fa fa-eye-slash"></i></button>
                            @endif
                        </form>
                    </td>
                </tr>
                <div id="imgModal-{{ $item->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                        <div class="relative bg-white rounded-lg shadow">
                            <div class="flex items-center justify-center p-4 md:p-5 border-b rounded-t">   
                                <img src="{{ asset($item->image) }}" alt="" width="200px"/>
                            </div>
                            <div class="p-4 md:p-5 space-y-4">
                                <h3 class="text-center text-3xl font-semibold text-gray-900">{{ $item->name }}</h3>
                                <p class="text-justify leading-relaxed text-gray-700">{{ $item->description }}</p>
                            </div>
                            <div class="flex items-center justify-center p-4 md:p-5 border-t border-gray-200 rounded-b">
                                <button data-modal-hide="imgModal-{{ $item->id }}" type="button" class="text-white bg-blue-600 hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-center text-sm px-4 py-2.5"><i class="fa fa-undo"></i> Regresar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="deleteModal-{{ $item->id }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-lg shadow">
                            <div class="p-4 md:p-5 text-center">
                                <div class="flex justify-center items-center">
                                    <img src="{{ asset($item->image) }}" alt="" class="img-fluid img-thumbnail" width="100px">
                                </div>
                                <h3 class="mb-5 pt-5 text-2xl font-bold text-gray-700">{{ $item->name }}</h3>
                                <h3 class="mb-5 text-lg font-semibold text-red-700">¿Confirma que desea eliminar este producto?</h3>
                                <form class="mt-4" method="POST" action="{{ route('products.destroy', $item->id) }}">
                                @csrf
                                @method("DELETE")
                                    <button type="submit" class="text-white bg-red-600 hover:bg-red-500 w-auto focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center me-2"><i class="fa fa-trash-alt"></i>&nbsp;Eliminar</button>
                                    <button data-modal-hide="deleteModal-{{ $item->id }}" type="button" class="text-white bg-gray-600 hover:bg-gray-500 w-auto focus:ring-4 focus:outline-none focus:ring-gray-300 rounded-lg border border-gray-300 text-sm font-medium px-5 py-2.5 hover:text-white focus:z-10"><i class="fa fa-ban"></i> Cancelar</button>
                                </form>
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
    <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-center pb-5">
        <div>
            <a href="{{ route('products.create') }}" type="button" class="rounded-md bg-blue-600 w-full text-lg text-white font-bold py-2 px-4 hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-300"><i class="fa fa-plus"></i> Agregar Producto</a>
        </div>
    </div>
    @endif
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
@endsection