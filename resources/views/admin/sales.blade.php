@extends('layouts.app_products')

@section('title', 'Sales')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css"/>
<div class="row px-16">
    <h1 class="text-5xl font-bold text-center pt-10 pb-10">Ventas</h1>
    @if (count($sales) > 0)
    <form method="POST" action="{{ route('products.search_sell') }}">
        @csrf
        <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-center pb-5">
            <div class="relative w-1/3">
                <input type="text" id="search" name="search" class="block p-2.5 w-full z-20 font-bold text-sm text-gray-900 bg-white rounded-lg border-s-gray-200 border-s-2 border border-gray-500 focus:ring-blue-500 focus:border-blue-500" placeholder="Buscar Factura..." required>
                <button type="submit" class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-blue-600 rounded-e-lg border border-blue-600 hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                    <span class="sr-only">Search</span>
                </button>
            </div>
        </div>
    </form>
    <div class="bg-gray-100 relative overflow-x-auto sm:rounded-lg pt-5 pb-10">
        <table class="w-full text-md text-left rtl:text-right text-gray-600">
            <thead class="text-lg text-white uppercase bg-blue-500">
                <tr class="text-center">
                    <th scope="col" class="px-6 py-3"><span>Número Factura</span></th>
                    <th scope="col" class="px-6 py-3"><span>Cantidad Productos</span></th>
                    <th scope="col" class="px-6 py-3"><span>Total Compra</span></th>
                    <th scope="col" class="px-6 py-3"><span>Fecha Compra</span></th>
                    <th scope="col" class="px-6 py-3"><span>Detalle</span></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $item)
                <tr class="text-center bg-blue-300 border-2 hover:bg-blue-400">
                    <td class="px-6 py-1 font-bold text-gray-900">{{ $item->invoice }}</td>
                    <td class="px-6 py-1 font-bold text-gray-900">{{ $item->amount }}</td>
                    <td class="px-6 py-1 font-bold text-gray-900">${{ $item->total }}</td>
                    <td class="px-6 py-1 font-bold text-gray-900">{{ $item->created_at }}</td>
                    <td class="px-6 py-1">
                        <a href="{{ route('products.detail_sell', $item->invoice) }}" type="button" class="rounded-md bg-green-600 w-9 text-lg text-white text-center font-bold p-2 my-3 hover:bg-green-500 focus:ring-4 focus:outline-none focus:ring-green-300"><i class="fa fa-eye"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <div class="row">
            <div class="col-md-12">
                {{ $sales->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
    @else
    <h1 class="text-xl font-bold text-center pt-5 pb-10">No se encontraron resultados...</h1>
    @endif
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
@endsection