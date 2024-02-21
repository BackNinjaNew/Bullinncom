<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title') - Bullinncom</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.0.1/tailwind.min.css"/>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    </head>
    <body class="bg-gray-100 text-gray-800">
        <nav class="flex py-5 bg-black text-white">
            <ul class="w-1/2 px-16 mr-auto flex justify-start pt-1">
                <li>
                    <p class="text-2xl font-bold"><a href='/bullinncom/public/catalog'>Bullinncom</a></p>
                </li>
                <li class="mx-4">
                    <a href="{{ route('catalog.index') }}" class=" font-semibold py-2 px-4 text-center text-2xl"><i class="fa fa-home"></i></a>
                </li>
                <li>
                    <a href="{{ route('catalog.shopping') }}" class="font-semibold border-2 border-white py-2 px-4 rounded-md hover:bg-white hover:text-black"><i class="fa fa-shopping-bag"></i> Mis Compras</a>
                </li>
            </ul>
            <ul class="w-1/2 px-16 ml-auto flex justify-end pt-1">
                <li>
                    <p class="text-xl">Bienvenido <b><em>{{ auth()->user()->firstname }}</em></b></p>
                </li>
                <li class="mx-6">
                    <a href="{{ route('catalog.cart') }}" class="font-semibold border-2 border-white py-2 px-4 rounded-md hover:bg-white hover:text-black"><i class="fa fa-shopping-cart"></i> {{ $carts }}</a>
                </li>
                <li>
                    <a href="{{ route('login.destroy') }}" class="font-semibold border-2 border-white py-2 px-4 rounded-md hover:bg-white hover:text-black"><i class="fa fa-sign-out-alt"></i> Cerrar Sesión</a>
                </li>
            </ul>
        </nav>
        @yield('content')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    </body>
</html>