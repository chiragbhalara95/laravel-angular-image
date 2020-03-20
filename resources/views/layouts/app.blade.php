<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - Admmin</title>
    {{-- Application CSS File --}}
    <link rel="stylesheet" href="{{url('/css/app.css')}}">

    {{-- Application JS Files --}}
    <script src="{{url('/js/app.js')}}"></script>
    <script src="{{url('/js/angular.min.js')}}"></script>
    <script src="{{url('/js/toastr.min.js')}}"></script>
    <script src="{{url('/js/ProductController.js')}}"></script>
    <script src="{{ asset('js/packages/dirPagination.js') }}"></script>

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>

</head>

<body ng-app="App">

    @yield('content')
</body>
</html>