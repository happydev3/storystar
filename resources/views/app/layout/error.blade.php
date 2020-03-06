<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>  {{$pageData['PageTitle'] or 'Title Missing'}} | {{config('app.name')}}</title>

        @stack('social-meta')


        <link href="{{app_assets("css/bootstrap.min.css")}}" rel="stylesheet" type="text/css">
        <link href="{{app_assets("css/style.css")}}" rel="stylesheet" type="text/css">
        <link href="{{app_assets("css/font-awesome.min.css")}}" type="text/css" rel="stylesheet">
        <link href="{{app_assets("css/star-rating-svg.css")}}" type="text/css" rel="stylesheet">
        <link href="{{app_assets('css/app_style.css')}}" type="text/css" rel="stylesheet">

        <!-- #FAVICONS -->
        <link rel="shortcut icon" href="{{app_assets('images/favicon/favicon.ico')}}" type="image/x-icon">
        <link rel="icon" href="{{app_assets('images/favicon/favicon.ico')}}" type="image/x-icon">

        <script type="text/javascript" src="{{app_assets('js/jquery-3.2.0.min.js')}}"></script>
        <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
        <script type="text/javascript" src="{{app_assets('js/bootstrap.min.js')}}"></script>
        <script type="text/javascript" src="{{app_assets('js/jquery.star-rating-svg.js')}}"></script>
        <script type="text/javascript" src="{{app_assets('js/jquery.customSelect.min.js')}}"></script>
        @stack('js-include')
        <script type="text/javascript" src="{{app_assets('js/app.js')}}"></script>


        <!-- Javascript Validation -->
        <script type="text/javascript" src="{{ url('public/vendor/jsvalidation/js/jsvalidation.js')}}"></script>

        @stack('css')

    </head>

    <body style="text-align: center;vertical-align: middle;margin: 0;">

    @yield('bodyContent')


    </body>
</html>










