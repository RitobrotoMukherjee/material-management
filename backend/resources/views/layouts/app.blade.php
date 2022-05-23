<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <meta name="description" content="MM Sunglobal">
    <meta name="author" content="Ritobroto Mukherjee">
    <meta name="keyword" content="Booster, Technology, Web Development, Flutter Development">
    <meta property="og:title" content="MM Sunglobal" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ config('app.asset_url') }}/favicon.ico">
    <!-- Favicons -->
    <link href="{{ config('app.asset_url') }}/favicon.ico" rel="icon">

    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
    <link href="{{ config('app.asset_url') }}/css/login.css" rel="stylesheet">
    @yield('css')<!-- all css in child views -->
</head>

<body oncontextmenu=' false' class='snippet-body'>
    @yield('content')
    
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js'></script>
    @yield('scripts')<!-- all scripts in child views -->
</body>

</html>

