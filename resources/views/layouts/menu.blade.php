<header class="header">
    <div class="menu">
        <div class="logo">
            <a href="{{ url('/') }}"><img src="{{ asset('img/logo.png') }}" alt="Logo" width="75px" ></a>
        </div>
        <ul class="d-flex" style="display: inline-flex;">
            <li><a href="{{ route('login') }}" class="login">Acceder</a></li>
            <li><a href="{{ route('register') }}" class="create">Crear cuenta</a></li>
        </ul>
    </div>
</header>
