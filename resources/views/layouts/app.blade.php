<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('MyShop') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js">
      </script>
        @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css'])

</head>

<body class="w-100 mx-auto">
    <header>
        <div class="row">
            <x-auth-bar />
        </div>
        <div class="row mx-auto" style="width: 80%">
            <div class="col-8">
                <x-nav-bar />
            </div>
            <div class="col-4">
                @auth
                    @if (Auth::user()->role !== 'admin')
                        <x-cart />
                    @endif
                @endauth
            </div>
        </div>
    </header>
    <main class="py-4">
      <div id="alerts" class="w-75 mx-auto">
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if (session('failure'))
            <div class="alert alert-warning" role="alert">
                {{ session('failure') }}
            </div>
        @endif
      </div>
        @yield('content')
    </main>
    @yield('scripts')
</body>

</html>
