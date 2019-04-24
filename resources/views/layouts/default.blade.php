<!DOCTYPE html>
<html>
<head>
    @include('includes.head')
</head>
<body>
    <div id="app">
        @yield('content')
    </div>
    <footer>
        @include('includes.footer')
    </footer>
</body>
@include('includes.scripts')
</html>