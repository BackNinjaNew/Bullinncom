@extends('layouts.app_catalog')

@section('title', 'Shopping Cart')

@section('content')
<div class="row px-16">
    <h1 class="text-5xl font-bold text-center pt-10 pb-10">Carrito de Compras</h1>
    @if (count($products) > 0)
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
    <div class="bg-gray-100 relative overflow-x-auto sm:rounded-lg pt-5 pb-10">
        <table class="w-full text-md text-left rtl:text-right text-gray-600 dark:text-gray-400">
            <thead class="text-lg text-white uppercase bg-blue-500 dark:bg-blue-500 dark:text-white">
                <tr class="text-center">
                    <th scope="col" class="px-6 py-3"><span>Imagen</span></th>
                    <th scope="col" class="px-6 py-3"><span>Código</span></th>
                    <th scope="col" class="px-6 py-3"><span>Categoria</span></th>
                    <th scope="col" class="px-6 py-3"><span>Nombre</span></th>
                    <th scope="col" class="px-6 py-3"><span>Marca</span></th>
                    <th scope="col" class="px-6 py-3"><span>Cantidad</span></th>
                    <th scope="col" class="px-6 py-3"><span>Precio</span></th>
                    <th scope="col" class="px-6 py-3"><span>Subtotal</span></th>
                    <th scope="col" class="px-6 py-3"><span>Eliminar</span></th>
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
                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">
                        <form method="POST" action="{{ route('catalog.amount') }}">
                            @csrf
                            <input type="hidden" value="{{ $item->id }}" id="id_product" name="id_product">
                            <input type="hidden" value="{{ $item->amount }}" id="amount" name="amount">
                            @if ($item->amount <= 1)
                            <button type="submit" name="minus" class="rounded-md bg-gray-400 w-9 text-lg text-white text-center font-bold p-2 my-3 hover:bg-gray-400" disabled><i class="fa fa-minus"></i></button>
                            @else
                            <button type="submit" name="minus" class="rounded-md bg-gray-600 w-9 text-lg text-white text-center font-bold p-2 my-3 hover:bg-gray-500"><i class="fa fa-minus"></i></button>
                            @endif
                            &nbsp;&nbsp;&nbsp;{{ $item->amount }}&nbsp;&nbsp;&nbsp;
                            @if ($item->amount >= $item->stock)
                            <button type="submit" name="plus" class="rounded-md bg-gray-400 w-9 text-lg text-white text-center font-bold p-2 my-3 hover:bg-gray-400" disabled><i class="fa fa-plus"></i></button>
                            @else
                            <button type="submit" name="plus" class="rounded-md bg-gray-600 w-9 text-lg text-white text-center font-bold p-2 my-3 hover:bg-gray-500"><i class="fa fa-plus"></i></button>
                            @endif
                        </form>
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">${{ $item->price }}</td>
                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">${{ $item->amount * $item->price }}</td>
                    <td class="px-6 py-4">
                        <form method="POST" action="{{ route('catalog.destroy', $item->id) }}">
                            @csrf
                            @method("DELETE")
                            <button type="submit" class="rounded-md bg-red-600 w-9 text-lg text-white text-center font-bold p-2 my-3 hover:bg-red-500"><i class="fa fa-trash-alt"></i></button>
                        </form>
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
            <tfooter>
                <tr class="text-center text-lg text-white uppercase bg-blue-500 dark:bg-blue-500 dark:text-white">
                    <td></td><td></td><td></td><td></td><td></td><td></td>
                    <td class="px-6 py-3 font-bold"><span>Total<span></td>
                    <td class="px-6 py-3 font-bold"><span>${{ $total }}<span></td>
                    <td></td>
                </tr>
            </tfooter>
        </table>
    </div>
    @else
    <h1 class="text-xl font-bold text-center pt-5 pb-5">No se encontraron resultados...</h1>
    @endif
</div>
@endsection