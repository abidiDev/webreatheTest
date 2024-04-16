<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Webreathe') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <!-- En-tête -->
        <header class="header" style="background-color: #4CAF50; color: #fff; padding: 20px;">
            <div class="container">
                <h1>{{ config('app.name', 'Webreathe') }}</h1>
                <p>S'immerger dans l'air pur, avec Webreathe.</p>
            </div>
        </header>

        <!-- Barre de navigation -->
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <!-- Marque et bouton de basculement pour la navigation mobile -->
                <a class="navbar-brand" href="{{ url('/') }}" style="color: #4CAF50;">
                    {{ config('app.name', 'Webreathe') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Liens de navigation -->
                    <ul class="navbar-nav me-auto">
                        <!-- Ajoutez des liens vers les différentes sections de votre site -->
                    </ul>

                    <!-- Liens de navigation à droite -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Liens d'authentification -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}" style="color: #4CAF50;">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}" style="color: #4CAF50;">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre style="color: #4CAF50;">
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" style="color: #4CAF50;">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Contenu principal -->
        <main class="py-4">
            @yield('content')
        </main>

        <!-- Footer de pages -->
        <footer class="footer bg-secondary text-light py-3" style="opacity: 0.9;">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <h5>Webreathe</h5>
                        <p>123 Rue de l'Entreprise</p>
                        <p>Ville, Pays</p>
                    </div>
                    <div class="col-md-4">
                        <h5>Contact</h5>
                        <p>Téléphone : +123456789</p>
                        <p>Email : info@example.com</p>
                    </div>
                    <div class="col-md-4">
                        <p>&copy; {{ date('Y') }} Webreathe. Tous droits réservés.</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
