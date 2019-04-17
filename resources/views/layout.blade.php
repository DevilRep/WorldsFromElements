<!DOCTYPE html>
<html>
<head>
    <title>Worlds from Elements - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div id="app">
        @yield('content')
    </div>
</body>
<script src="/js/app.js"></script>
</html>