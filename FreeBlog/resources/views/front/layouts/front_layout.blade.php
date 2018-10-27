<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('/img/system32/icon.png') }}">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>{{ isset($title_page)?$title_page:env('APP_NAME') }}</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <link href="{{ asset('plugins/materialize/css/materialize.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ asset('plugins/font-awesome/css/font-awesome.min.css')  }}">
    @yield('imported_css')
    @yield('meta')
    <meta name="google" value="notranslate">
</head>
<body>
    <main>            
        @yield('content')        
    </main>
    @include('front.layouts.partials._footer')
</body>
    <!--   Core JS Files   -->
    <script src="{{ asset('plugins/materialize/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('plugins/materialize/js/materialize.min.js') }}"></script>
    @yield('imported_js')
    <script src="{{ asset('js/fgs.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.parallax').parallax();
        });
    </script>
    @yield('js')
</html>
