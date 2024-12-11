<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    {{-- Character Set Declaration --}}
    <meta charset="utf-8">

    {{-- Viewport Meta Tag --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Meta title --}}
    @hasSection('meta_title')
        <title>@yield('meta_title') | {{ config('app.name') }}</title>
    @else
        <title>{{ config('app.name') }}</title>
    @endif

    {{-- Canonical Tag --}}
    <link href="{{ url()->current() }}" rel="canonical">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}}">

    {{-- Font awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" />

    {{-- jQuery --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js" type="text/javascript"></script>

    {{-- CDN --}}
    @stack('cdn-header')

    {{-- SCSS, JS --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-target="#navbarSupportedContent" data-bs-toggle="collapse" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div id="navbarSupportedContent" class="collapse navbar-collapse">
                    <ul class="navbar-nav me-auto"></ul>
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true" role="button" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" class="d-none" action="{{ route('logout') }}" method="POST">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            <div class="container-fluid">
            @yield('content')
            </div>
        </main>
    </div>
    @stack('modals')
    @stack('cdn-footer')
    @stack('scripts')
    <script type="text/javascript">
        let blocks = document.getElementsByClassName('col-auto-width');

        Array.from(blocks).forEach((element) => {
            let childs = element.getElementsByTagName('div');
            let length = childs.length;
            let div = childs[0];

            if (length === 1) {
                div.className = 'col-lg-12 col-lg-12 col-xl-12';
            } else if (length === 2) {
                div.className = 'col-lg-12 col-lg-6 col-xl-6';
                div = div.nextElementSibling;
                div.className = 'col-lg-12 col-lg-6 col-xl-6';
            } else {
                for (let i = 0; i < length; i++) {
                    if (!div) {
                        continue;
                    }

                    className = ['col-12'];

                    if (i === length - 1) {
                        className.push('col-lg-12')
                    } else {
                        className.push('col-lg-6')
                    }

                    className.push('col-xl-3')

                    div.className = className.join(' ');
                    div = div.nextElementSibling;
                }
            }
        });
    </script>
</body>
</html>
