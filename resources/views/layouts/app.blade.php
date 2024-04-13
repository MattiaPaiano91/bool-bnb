<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="icon" type="image/jpg" href="{{ asset('img/loghi/boolairbnb-favicon.PNG') }}" />
        <title>@yield('page-title') | {{ config('app.name', 'BoolBnb') }}</title>

        <!-- Scripts -->
        @vite('resources/js/app.js')
    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-bool bg-white ">
                <div class="container bg-white ">
                    <div class="box-img-logo">
                        <img src="{{ asset('img/loghi/boolbnb-rosa-sfondobianco-150px.JPG') }}" class=" h-100 w-100 " alt="">
                    </div>
                    {{-- <a class="navbar-brand" href="#">BoolBnb</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button> --}}
                    <div class="collapse navbar-collapse mx-4 " id="navbarText">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="icon-link text-black text-decoration-none hov-underline "   href="{{ route('admin.dashboard') }}">
                                    Dashboard
                                    <svg class="bi" aria-hidden="true"><use xlink:href="#arrow-right"></use></svg>
                                  </a>
                            </li>
                            <li class="nav-item">
                                <a class="icon-link text-black text-decoration-none hov-underline"  href="{{ route('admin.apartments.index') }}">
                                    Appartamenti
                                    <svg class="bi" aria-hidden="true"><use xlink:href="#arrow-right"></use></svg>
                                  </a>

                            </li>
                        </ul>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit" class="btn btn-outline-danger">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </nav>
        </header>

        <main class="py-4">
            <div class="container">
                @yield('main-content')
            </div>
        </main>
    </body>
</html>
<style>
     .hov-underline {
        position: relative;
        display: inline-block;
        font-size: 1.2  rem;
        //padding-bottom: 3px;
        cursor: pointer;
        border-bottom: 2px solid transparent;
        transition: border-color 0.3s ease; /* Aggiungi una transizione fluida per l'effetto hover */
        &:hover{
            transform: scale(1.1);
        }
    }
    /* Animazione per la sottolineatura */
    .hov-underline::after {
    content: '';
        position: absolute;
        left: 0;
        bottom: 0;
        width: 0; /* Inizia senza larghezza */
        height: 2px; /* Altezza della sottolineatura */
        background-color: #EB5A63; 
        transition: width 0.3s ease; /* Aggiungi una transizione fluida per l'animazione */
        transform: scale(1.1);
    }
    .hov-underline:hover::after {
        width: 80%; /* Espandi la larghezza al 100% durante l'hover */
        
    }
</style>