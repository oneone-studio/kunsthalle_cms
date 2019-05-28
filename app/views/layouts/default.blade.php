<!DOCTYPE html>
<html lang="en">
<head>
    @include('includes.head')
</head>
<body ng-controller="MainCtrl">
<div class="container" style="width:84%;">

    <header class="row">
        @include('includes.header')
    </header>

    <div id="main" class="row">
            @include('includes.sidebar')

            @yield('content')

    </div>

    <footer class="row">
        @include('includes.footer')
    </footer>

</div>
</body>
</html>