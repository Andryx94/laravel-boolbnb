<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Boolbnb') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.0/moment.min.js" integrity="sha512-Izh34nqeeR7/nwthfeE0SI3c8uhFSnqxV0sI9TvTcXiFJkMd6fB644O64BRq2P/LA/+7eRvCw4GmLsXksyTHBg==" crossorigin="anonymous"></script>
    <script src="https://js.braintreegateway.com/web/dropin/1.24.0/js/dropin.min.js"></script>
    <script src="https://static.opentok.com/v2/js/opentok.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
      var angoliaId = "{{config('services.angolia.id')}}";
      var angoliaKey = "{{config('services.angolia.key')}}";
    </script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />

    <!-- Stili -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
</head>
<body>

    <div id="app" class="site_wrapper">
      <nav class="navbar-home navbar navbar-fixed-top navbar-expand-md navbar-light bg-white shadow-sm  fixed-top">
          <div class="container-fluid">
              {{-- Logo --}}
              <a class="navbar-brand" href="{{asset("/")}}">
                <img class="ms_logo"src="{{asset('img/boolbnb-logo.png')}}" alt="">
                <img class="ms_logo_white"src="{{asset('img/boolbnb-logo-white.png')}}" alt="">
              </a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                  <span class="navbar-toggler-icon"></span>
              </button>

              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <!-- Navbar sinistra -->
                  <ul class="navbar-nav mr-auto">
                  </ul>

                  <!-- Navbar destra -->
                  <ul class="navbar-nav ml-auto">
                      <!-- Link autenticazione -->
                      @guest
                        {{-- Diventa un Host --}}
                        <li class="nav-item">
                            <a class="nav-link nav-right" href="{{ route('register') }}">{{ __('Diventa un host') }}</a>
                        </li>
                        {{-- Globo lingue --}}
                          <li class="nav-item dropdown prova">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fas fa-globe"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                              <a class="nav-link"><i class="fas fa-globe"></i> Italiano IT</a>
                              <a class="nav-link">€ Euro</a>
                            </div>
                          </li>
                          {{-- Login/Registrazione --}}
                          <li class="button-login nav-item dropdown">

                            <a id="navbarDropdown" class="nav-link " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fas fa-bars"></i>
                                <i class="user-login fas fa-user-circle"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                              @if (Route::has('register'))
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Iscriviti') }}</a>
                            @endif
                            </div>
                          </li>

                      @else
                        {{-- Quando si è loggato --}}
                          {{-- Globo lingue --}}
                          <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fas fa-globe"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                              <a class="nav-link"><i class="fas fa-globe"></i> Italiano IT</a>
                              <a class="nav-link">€ Euro</a>
                            </div>
                          </li>
                          {{-- Menu Utente --}}
                          <li class="button-login nav-item dropdown">
                              {{-- <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                  {{ Auth::user()->firstname }}
                              </a> --}}
                              <a id="navbarDropdown" class="nav-link " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                  <i class="fas fa-bars"></i>
                                  <i class="user-login fas fa-user-circle"></i>
                                  {{ Auth::user()->firstname }}
                              </a>

                              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('admin.apartments.index') }}">
                                    Ciao, {{ Auth::user()->firstname }}!
                                </a>

                                <a class="dropdown-item" href="{{ route('admin.apartments.index') }}">
                                    I tuoi appartamenti
                                </a>

                                <a class="dropdown-item" href="{{ route('admin.apartments.create') }}">
                                    Aggiungi appartamenti
                                </a>

                                <a class="dropdown-item" href="{{ route('admin.sponsorships.index') }}">
                                    Sponsorizza appartamenti
                                </a>

                                <a class="dropdown-item" href="{{ route('admin.statistics.index') }}">
                                    Statistiche
                                </a>

                                <a class="dropdown-item" href="{{ route('admin.messages.index') }}">
                                    Messaggi
                                    <span class="badge badge-pill badge-info">Info</span>
                                </a>

                                  <a class="dropdown-item" href="{{ route('logout') }}"
                                     onclick="event.preventDefault();
                                                   document.getElementById('logout-form').submit();">
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

      {{-- Main --}}
        <main class="py-4">
            @yield('content')
        </main>

        {{-- Footer --}}
        @include('partials.footer')
    </div>
</body>
</html>
