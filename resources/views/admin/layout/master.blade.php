<!DOCTYPE html>

<html lang="en-us" id="" class="smart-style-1">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <title>  {{$pageData['PageTitle'] or 'Title Missing'}} | {{config('app.name')}}</title>
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">


    <!-- #CSS Links -->
    <!-- Basic Styles -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{assets('css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{assets('css/font-awesome.min.css')}}">

    <!-- SmartAdmin Styles : Caution! DO NOT change the order -->
    <link rel="stylesheet" type="text/css" media="screen"
          href="{{assets('css/smartadmin-production-plugins.min.css')}}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{assets('css/smartadmin-production.min.css')}}">
    <link rel="stylesheet" type="text/css" media="screen" href="{{assets('css/smartadmin-skins.min.css')}}">

    <!-- SmartAdmin RTL Support -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{assets('css/smartadmin-rtl.min.css')}}">


    <link rel="stylesheet" type="text/css" media="screen" href="/assets/admin/css/your_style1.css?v=2">

    <!-- Demo purpose only: goes with demo.js, you can delete this css when designing your own WebApp -->
    <link rel="stylesheet" type="text/css" media="screen" href="{{assets('css/demo.min.css')}}">

    <!-- #FAVICONS -->
    <link rel="shortcut icon" href="{{assets('img/favicon/favicon.ico')}}" type="image/x-icon">
    <!-- #FAVICONS -->
    <link rel="shortcut icon" href="{{app_assets('images/favicon/favicon.ico')}}" type="image/x-icon">
    <link rel="icon" href="{{app_assets('images/favicon/favicon.ico')}}" type="image/x-icon">

    <!-- #GOOGLE FONT -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

    <!-- #APP SCREEN / ICONS -->
    <!-- Specifying a Webpage Icon for Web Clip
         Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
    <link rel="apple-touch-icon" href="{{assets('img/splash/sptouch-icon-iphone.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{assets('img/splash/touch-icon-ipad.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{assets('img/splash/touch-icon-iphone-retina.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{assets('img/splash/touch-icon-ipad-retina.png')}}">

    <!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">

    <!-- Startup image for web apps -->
    <link rel="apple-touch-startup-image" href="{{assets('img/splash/ipad-landscape.png')}}"
          media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
    <link rel="apple-touch-startup-image" href="{{assets('img/splash/ipad-portrait.png')}}"
          media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
    <link rel="apple-touch-startup-image" href="{{assets('img/splash/iphone.png')}}"
          media="screen and (max-device-width: 320px)">

    <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script> if (!window.jQuery) {
            document.write('<script src="{{assets('js/libs/jquery-2.1.1.min.js')}}"><\/script>');
        } </script>


    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script>
        if (!window.jQuery.ui) {
            document.write('<script src="{{assets('js/libs/jquery-ui-1.10.3.min.js')}}"><\/script>');
        }
    </script>


    <!-- BOOTSTRAP JS -->
    <script src="{{assets('js/libs/jquery.serializeObject.min.js')}}"></script>
    <script src="{{assets('js/bootstrap/bootstrap.min.js')}}"></script>


    {{--<!-- JQUERY VALIDATE -->--}}
    {{--<script src="{{assets('js/plugin/jquery-validate/jquery.validate.min.js')}}"></script>--}}

    <!-- JQUERY MASKED INPUT -->
    <script src="{{assets('js/plugin/masked-input/jquery.maskedinput.min.js')}}"></script>


    <!-- Laravel Javascript Validation -->
    <script type="text/javascript"
            src="{{ url('public/vendor/jsvalidation/js/jsvalidation.js')}}"></script>



    @stack('css')
</head>

<body class="smart-style-1 pace-done   fixed-header">

@if (session('csrf_error'))
    <div class="alert alert-block alert-danger">
        <a class="close" data-dismiss="alert" href="#">Ã—</a>
        <h4 class="alert-heading">Please Note!</h4>
        <p>
            {{ session('csrf_error') }}
        </p>
    </div>
@endif
@yield('header')


@yield('bodyContent')

<!--================================================== -->
<!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)-->
<script src="{{assets('js/plugin/pace/pace.min.js')}}"></script>

<!-- IMPORTANT: APP CONFIG -->
<script src="{{assets('js/config.js')}}"></script>

<!-- JS TOUCH : include this plugin for mobile drag / drop touch events
<script src="js/plugin/jquery-touch/jquery.ui.touch-punch.min.js')}}"></script> -->


<!-- JQUERY SELECT2 INPUT -->
<script type="text/javascript"
        src="{{ assets('js/plugin/select2/select2.min.js')}}"></script>

<script type="text/javascript"
        src="{{ assets('js/smartwidgets/jarvis.widget.min.js')}}"></script>


<!-- MAIN APP JS FILE -->
<script src="{{assets('js/notification/SmartNotification.min.js')}}"></script>

<script src="{{assets('js/app.min.js')}}"></script>

@stack('js')

{!! $jsValidator or '' !!}

<script>
    $(document).ready(function () {
        pageSetUp();
    });
</script>

<script>
    function field_reset() {
        localStorage.setItem('DataTables_User_TBL_/story-admin/site-member/list', '');
        localStorage.setItem('DataTables_User_TBL_/story-admin/ads/list', '');
        localStorage.setItem('DataTables_PointsBadWords_TBL_/story-admin/points-bad-words/list', '');
        localStorage.setItem('DataTables_User_TBL_/story-admin/flag/list', '');
        localStorage.setItem('DataTables_Backend_User_TBL_/story-admin/member/list', '');
        localStorage.setItem('DataTables_StoryStar_TBL_/story-admin/story-star/list', '');
        localStorage.setItem('DataTables_PointsHistory_TBL_/story-admin/points-history/list', '');
        localStorage.setItem('DataTables_Star_TBL_/story-admin/author-of-month/list', '');
        localStorage.setItem('DataTables_User_TBL_/story-admin/subscriber/list', '');
        localStorage.setItem('DataTables_Star_TBL_/story-admin/star-portraits/list', '');
        localStorage.setItem('DataTables_Subject_TBL_/story-admin/subject/list', '');
        localStorage.setItem('DataTables_Category_TBL_/story-admin/category/list', '');
        localStorage.setItem('DataTables_SubCategory_TBL_/story-admin/subcategory/list', '');
        localStorage.setItem('DataTables_PointsOnHold_TBL_/story-admin/points-on-hold/list', '');
        localStorage.setItem('DataTables_PointsCategory_TBL_/story-admin/points-category/list', '');
        localStorage.setItem('DataTables_PointsHistory_TBL_/story-admin/contest/entries', '');
        localStorage.setItem('DataTables_Theme_TBL_/story-admin/theme/list', '');
        window.location = location.href.replace("", "");
    }
</script>
</body>
</html>











