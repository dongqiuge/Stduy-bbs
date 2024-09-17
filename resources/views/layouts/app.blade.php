@php use Illuminate\Support\Facades\Auth; @endphp
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'bbs') - {{ setting('site_name', 'Laravel bbs') }}</title>
    <meta name="description" content="@yield('description', setting('seo_description', 'laravel 开发者社区'))">
    <meta name="keywords" content="@yield('keyword', setting('seo_keyword', 'laravel,php,论坛,社区,开发者'))">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    @yield('styles')

</head>

<body>
<div id="app" class="{{ route_class() }}-page">

    @include('layouts._header')

    <div class="container">

        @include('shared._messages')

        @yield('content')

    </div>

    @include('layouts._footer')
</div>

@auth
    @if(app()->isLocal())
        @include('layouts._impersonate')
    @endif
@endauth

<!-- Scripts -->
<script src="{{ mix('js/app.js') }}"></script>

@yield('scripts')

</body>

</html>
