<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>Awisk | @yield('title')</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="A Timesheet for Awisk."/>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}">
    <link rel="icon" href="{{asset('favicon.ico" type="image/x-icon')}}">
    <!-- Morris Charts CSS -->
{{--    <link href="{{asset('vendors/morris.js/morris.css')}}" rel="stylesheet" type="text/css" />--}}
<!-- Toastr CSS -->
{{--    <link href="{{asset('vendors/jquery-toast-plugin/dist/jquery.toast.min.css')}}" rel="stylesheet" type="text/css">--}}
<!-- Toggles CSS -->
    <link href="{{asset('vendors/jquery-toggles/css/toggles.css" rel="stylesheet" type="text/css')}}">
    <link href="{{asset('vendors/jquery-toggles/css/themes/toggles-light.css')}}" rel="stylesheet" type="text/css">
    <!-- Custom CSS -->
    <link href="{{asset('dist/css/style.css')}}" rel="stylesheet" type="text/css">
    @yield('stylesheet')
</head>
<body>

<!-- Preloader -->
<div class="preloader-it">
    <div class="loader-pendulums"></div>
</div>
<!-- /Preloader -->

<!-- HK Wrapper -->
@if (Route::current()->getName() != 'login')
    <div class="hk-wrapper hk-alt-nav hk-icon-nav">
        @include('partials._nav')
    </div>
    <div class="hk-pg-wrapper">
        @yield('content')
    </div>

@else
    <div class="hk-wrapper">
        @yield('content')
    </div>
@endif

<!-- /HK Wrapper -->
<!-- jQuery -->
<script src="{{asset('vendors/jquery/dist/jquery.min.js')}}"></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{asset('vendors/popper.js/dist/umd/popper.min.js')}}"></script>
<script src="{{asset('vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>

<!-- Slimscroll JavaScript -->
<script src="{{asset('dist/js/jquery.slimscroll.js')}}"></script>

<!-- Fancy Dropdown JS -->
<script src="{{asset('dist/js/dropdown-bootstrap-extended.js')}}"></script>

<!-- FeatherIcons JavaScript -->
<script src="{{asset('dist/js/feather.min.js')}}"></script>

<!-- Toggles JavaScript -->
<script src="{{asset('vendors/jquery-toggles/toggles.min.js')}}"></script>
<script src="{{asset('dist/js/toggle-data.js')}}"></script>

<!-- Counter Animation JavaScript -->
<script src="{{asset('vendors/waypoints/lib/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('vendors/jquery.counterup/jquery.counterup.min.js')}}"></script>

<!-- Easy pie chart JS -->
{{--<script src="{{asset('vendors/easy-pie-chart/dist/jquery.easypiechart.min.js')}}"></script>--}}

<!-- Sparkline JavaScript -->
<script src="{{asset('vendors/jquery.sparkline/dist/jquery.sparkline.min.js')}}"></script>

<!-- Morris Charts JavaScript -->
{{--<script src="{{asset('vendors/raphael/raphael.min.js')}}"></script>--}}
{{--<script src="{{asset('vendors/morris.js/morris.min.js')}}"></script>--}}

<!-- EChartJS JavaScript -->
{{--<script src="{{asset('vendors/echarts/dist/echarts-en.min.js')}}"></script>--}}

<!-- Peity JavaScript -->
{{--<script src="{{asset('vendors/peity/jquery.peity.min.js')}}"></script>--}}

<!-- Toastr JS -->
{{--<script src="{{asset('vendors/jquery-toast-plugin/dist/jquery.toast.min.js')}}"></script>--}}
{{----}}
<!-- Init JavaScript -->
<script src="{{asset('dist/js/init.js')}}"></script>
{{--<script src="{{asset('dist/js/dashboard-data.js')}}"></script>--}}
@yield('script')
</body>

</html>