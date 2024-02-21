@extends('layouts.app_payments')

@section('title', 'Payments')

@section('content')
@if ($carts > 0)
<div class="row px-16">
    <h1 class="text-5xl font-bold text-center pt-10 pb-10">¿Como Quieres Pagar?</h1>
    <div class="text-2xl font-bold text-center">
        <h1>Detalle de tu Compra</h1>
    </div>
    <div class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-center pt-5 pb-5">
        <div class="text-2xl font-normal text-center">
            <h1>Productos ({{ $carts }})&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;${{ $total }}</h1>
        </div>
    </div>
    <div class="text-center pt-5 pb-5">
        <a href="{{ route('payments.paypal') }}" type="button" class="rounded-md bg-blue-600 w-auto text-lg text-white font-bold p-2 my-3 hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-300">
            <img src="images/paypal.png" alt="" width="200px"/>
        </a>
        &nbsp;&nbsp;&nbsp;
        <a href="{{ route('payments.mercadopago') }}" type="button" class="rounded-md bg-blue-600 w-auto text-lg text-white font-bold p-2 my-3 hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-300">
            <img src="images/mercadopago.jpg" alt="" width="200px"/>
        </a>
    </div>
    <div class="text-center">
        @if ($message = Session::get('danger'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">{{ $message }}</strong>
        </div>
        @endif
    </div>
</div>
@else
<div class="row px-16">
    <h1 class="text-5xl font-bold text-center pt-10 pb-5">Descubre mas Productos</h1>
    <div class="text-center">
        @if ($message = Session::get('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">{{ $message }}</strong>
        </div>
        @endif
    </div>
    <div class="text-center pt-5">
        <a href="{{ route('catalog.index') }}" type="button" class="rounded-md bg-blue-600 w-auto text-lg text-white text-center font-bold p-2 my-3 hover:bg-blue-500 focus:ring-4 focus:outline-none focus:ring-blue-300"><i class="fa fa-store"> Descubrir Productos</i></a>
    </div>
</div>
@endif
@endsection