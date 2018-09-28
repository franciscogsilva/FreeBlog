<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('/img/icon.png') }}">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>{{ $title_page }}</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <link href="{{ asset('plugins/materialize/css/materialize.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ asset('plugins/trumbowyg/ui/trumbowyg.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/font-awesome/css/font-awesome.min.css')  }}">
    @yield('imported_css')
    <meta name="google" value="notranslate">
</head>
<body>    
        @include('admin.layouts.partials._navbar_left')
        @include('admin.layouts.partials._navbar_top')
        <main class="main_admin">            
            @yield('content')
            
        </main>
        @include('admin.layouts.partials._footer')
</body>
    <!--   Core JS Files   -->
    <script src="{{ asset('plugins/materialize/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('plugins/materialize/js/materialize.min.js') }}"></script>
    <script src="{{ asset('plugins/trumbowyg/trumbowyg.js') }}"></script>
    <script src="{{ asset('plugins/trumbowyg/plugins/pasteimage/trumbowyg.pasteimage.min.js') }}"></script> 
    <script src="{{ asset('plugins/trumbowyg/plugins/base64/trumbowyg.base64.min.js') }}"></script> 
    <script src="{{ asset('plugins/trumbowyg/plugins/colors/trumbowyg.colors.min.js') }}"></script> 
    <script src="{{ asset('plugins/trumbowyg/plugins/noembed/trumbowyg.noembed.min.js') }}"></script> 
    <script src="{{ asset('plugins/trumbowyg/plugins/preformatted/trumbowyg.preformatted.min.js') }}"></script> 
    <script src="{{ asset('plugins/trumbowyg/plugins/upload/trumbowyg.upload.min.js') }}"></script> 
    <script src="{{ asset('plugins/trumbowyg/plugins/noembed/trumbowyg.noembed.js') }}"></script> 
    <script src="{{ asset('plugins/trumbowyg/langs/es.min.js')}}"></script>
    @yield('imported_js')
    <script src="{{ asset('js/fgs.js') }}"></script>
    <script type="text/javascript">
        $('select').material_select();
        $(".button-collapse").sideNav();
        $(".dropdown-button").dropdown();
        $('.tooltipped').tooltip({delay: 50});
        $("#session_msg").delay(3000).hide(600);
        $('.modal').modal();
        $('.materialboxed').materialbox();
    </script>
    @yield('js')
</html>
