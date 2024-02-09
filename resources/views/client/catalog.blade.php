@extends('layouts.app_catalog')

@section('title', 'Products Catalog')

@section('content')
<div class="conm px-16">
    <h1 class="text-5xl font-bold text-center pt-10 pb-10">Catalogo de Productos</h1>
    @if (count($products) > 0)
    <form method="POST" action="{{ route('catalog.search') }}">
        @csrf
        <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-center pb-5">
            <div class="relative w-1/3">
                <input type="search" id="search" name="search" class="block p-2.5 w-full z-20 text-sm font-bold text-gray-900 bg-white rounded-lg border-s-gray-200 border-s-2 border border-gray-500 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-s-gray-500 dark:border-gray-600 dark:placeholder-gray-500 dark:text-white dark:focus:border-blue-500" placeholder="Buscar..." required>
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
        @elseif ($message = Session::get('warning'))
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">{{ $message }}</strong>
        </div>
        @endif
    </div>
    <div class="flex flex-wrap justify-normal">
        @foreach ($products as $item)
        <div class="w-1/5 p-4 mb-4">
            <div class="w-full max-w-sm bg-white border border-gray-400 rounded-lg shadow dark:bg-gray-700 dark:border-gray-700">
                <div class="flex justify-center items-center mb-4">
                    <a data-modal-target="default-modal-{{ $item->id }}" data-modal-toggle="default-modal-{{ $item->id }}" class="bg-white rounded-t-lg pt-4" type="button">
                        <img src="{{ asset($item->image) }}" alt="" width="220px"/>
                    </a>
                </div>
                <div class="px-4 pb-4">
                    <h5 class="text-3xl font-semibold mb-4 tracking-tight text-center text-gray-900 dark:text-white"> {{ $item->name }} </h5>
                    <h5 class="text-md font-semibold mb-4 tracking-tight text-center text-gray-900 dark:text-white"> {{ $item->stock }} Disponibles</h5>
                    <div class="flex items-center justify-between">
                        <span class="text-2xl font-bold text-gray-900 dark:text-white">${{ $item->price }} </span>
                        <form method="POST" action="{{ route('catalog.store') }}">
                            @csrf
                            <input type="hidden" value="{{ $item->id }}" id="id_product" name="id_product">
                            <button type="submit" class="text-white bg-blue-600 hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-center text-2xl px-4 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-600 dark:focus:ring-blue-500">
                                <i class="fa fa-cart-plus"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
    </div>
    @else
    <h1 class="text-xl font-bold text-center pt-5 pb-5">No se encontraron resultados...</h1>
    @endif
</div>
@endsection