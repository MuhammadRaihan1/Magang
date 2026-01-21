<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="auth-page">
    <div class="auth-wrap">
        <div class="auth-grid">

            <div class="auth-left">
                <img src="{{ $leftImage ?? asset('images/logo.png') }}" class="auth-illus" alt="Illustration">
            </div>

            <div class="auth-right">
                <div class="auth-panel">
                    <div class="auth-panel-inner">
                        @yield('content')
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>
