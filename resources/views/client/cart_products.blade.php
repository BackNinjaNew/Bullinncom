@extends('layouts.app_catalog')

@section('title', 'Shopping Cart')

@section('content')
<div class="row px-16">
    <h1 class="text-5xl font-bold text-center pt-10 pb-10">Carrito de Compras</h1>
    @if (count($products) > 0)
    <div class="bg-gray-100 relative overflow-x-auto sm:rounded-lg pt-5 pb-10">
        <table class="w-full text-md text-left rtl:text-right text-gray-600">
            <thead class="text-lg text-white uppercase bg-blue-500">
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
                    <td class="px-6 py-4 font-bold text-gray-900">
                        <form method="POST" action="{{ route('catalog.amount') }}">
                            @csrf
                            <input type="hidden" value="{{ $item->id }}" id="id_product" name="id_product">
                            <input type="hidden" value="{{ $item->amount }}" id="amount" name="amount">
                            @if ($item->amount <= 1)
                            <button type="submit" name="minus" class="rounded-md bg-gray-400 w-9 text-lg text-white text-center font-bold p-2 my-3" disabled><i class="fa fa-minus"></i></button>
                            @else
                            <button type="submit" name="minus" class="rounded-md bg-gray-600 w-9 text-lg text-white text-center font-bold p-2 my-3 hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-gray-300"><i class="fa fa-minus"></i></button>
                            @endif
                            &nbsp;&nbsp;&nbsp;{{ $item->amount }}&nbsp;&nbsp;&nbsp;
                            @if ($item->amount >= $item->stock)
                            <button type="submit" name="plus" class="rounded-md bg-gray-400 w-9 text-lg text-white text-center font-bold p-2 my-3" disabled><i class="fa fa-plus"></i></button>
                            @else
                            <button type="submit" name="plus" class="rounded-md bg-gray-600 w-9 text-lg text-white text-center font-bold p-2 my-3 hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-gray-300"><i class="fa fa-plus"></i></button>
                            @endif
                        </form>
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-900">${{ $item->price }}</td>
                    <td class="px-6 py-4 font-bold text-gray-900">${{ $item->amount * $item->price }}</td>
                    <td class="px-6 py-4">
                        <form method="POST" action="{{ route('catalog.destroy', $item->id) }}">
                            @csrf
                            @method("DELETE")
                            <button type="submit" class="rounded-md bg-red-600 w-9 text-lg text-white text-center font-bold p-2 my-3 hover:bg-red-500 focus:ring-4 focus:outline-none focus:ring-red-300"><i class="fa fa-trash-alt"></i></button>
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
                @endforeach
            </tbody>
            <tfooter>
                <tr class="text-center text-lg text-black uppercase bg-gray-300">
                    <td></td><td></td><td></td><td></td><td></td><td></td>
                    <td class="px-6 py-3 font-bold"><span>Total<span></td>
                    <td class="px-6 py-3 font-bold"><span>${{ $total }}<span></td>
                    <td></td>
                </tr>
            </tfooter>
        </table>
        <div class="text-center pt-5 pb-5">
            <a href="{{ route('payments.index') }}" type="button" class="rounded-md bg-blue-600 w-60 text-lg text-white font-bold p-2 my-3 hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-300"><i class="fa fa-dollar-sign"> Realizar Pago</i></a>
        </div>
    </div>
    @else
    <div class="text-center">
        <h1 class="text-xl font-bold text-center pt-5 pb-5">¡Empieza un carrito de compras!</h1>
        <a href="{{ route('catalog.index') }}" type="button" class="rounded-md bg-blue-600 w-auto text-lg text-white text-center font-bold p-2 my-3 hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-300"><i class="fa fa-store"> Descubrir Productos</i></a>
    </div>
    @endif
</div>
@endsection