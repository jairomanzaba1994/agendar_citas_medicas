<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('img/icono.ico') }}">

    <!-- Estilos de bootstrap -->
    <link href="{{ mix('vendor/twbs/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Estilos css generales -->
    <link href="{{ asset('css/base/css/general.css') }}" rel="stylesheet">
    <link href="{{ asset('css/base/css/menu.css') }}" rel="stylesheet">
    <link href="{{ asset('css/base/css/footer.css') }}" rel="stylesheet">

    <!-- Estilos cambiantes -->
    @yield('styles')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
</head>

<body>
    <div class="container-fluid">
        <!-- Incluir menú -->
        <div class="container-fluid">
            @include('layouts.menu')
        </div>

        <div class="container-fluid">
            <section class="section">
                @yield('content')
            </section>
        </div>

        <!-- Incluir footer -->
        <div class="container-fluid">
            @include('layouts.pie')
        </div>
    </div>

    <!-- Scripts de bootstrap -->
    @yield('scripts')
</body>

</html>
