<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>@yield('title') | HRM</title>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="A Timesheet for Awisk."/>
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('favicon.png')}}">
    <link rel="icon" href="{{asset('favicon.png')}}" type="image/x-icon">
    <!-- Morris Charts CSS -->
{{--    <link href="{{asset('vendors/morris.js/morris.css')}}" rel="stylesheet" type="text/css" />--}}
<!-- Toastr CSS -->
{{--    <link href="{{asset('vendors/jquery-toast-plugin/dist/jquery.toast.min.css')}}" rel="stylesheet" type="text/css">--}}
{{--    Data Table CSS--}}
<!-- Data Table CSS -->
    <link href="{{asset('vendors/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css')}}"/>
    <link href="{{asset('vendors/datatables.net-responsive-dt/css/responsive.dataTables.min.css')}}" rel="stylesheet"
          type="text/css"/>
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
    <div class="hk-pg-wrapper" style="min-height: 789px;">
        @include('partials._requestForm')
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
{{--<script src="{{asset('vendors/jquery.sparkline/dist/jquery.sparkline.min.js')}}"></script>--}}

<!-- Morris Charts JavaScript -->
{{--<script src="{{asset('vendors/raphael/raphael.min.js')}}"></script>--}}
{{--<script src="{{asset('vendors/morris.js/morris.min.js')}}"></script>--}}

<!-- EChartJS JavaScript -->
{{--<script src="{{asset('vendors/echarts/dist/echarts-en.min.js')}}"></script>--}}

<!-- Peity JavaScript -->
{{--<script src="{{asset('vendors/peity/jquery.peity.min.js')}}"></script>--}}

<!-- Toastr JS -->
{{--<script src="{{asset('vendors/jquery-toast-plugin/dist/jquery.toast.min.js')}}"></script>--}}
{{--Sweet Alert--}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<!-- Init JavaScript -->
<script src="{{asset('dist/js/init.js')}}"></script>
{{--<script src="{{asset('dist/js/dashboard-data.js')}}"></script>--}}
{{--Data Table--}}
<script src="{{asset('vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendors/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendors/datatables.net-dt/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{asset('vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('vendors/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
<script src="{{asset('vendors/jszip/dist/jszip.min.js')}}"></script>
<script src="{{asset('vendors/pdfmake/build/pdfmake.min.js')}}"></script>
<script src="{{asset('vendors/pdfmake/build/vfs_fonts.js')}}"></script>
<script src="{{asset('vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('dist/js/dataTables-data.js')}}"></script>
<script>
    $(document).ready(function () {
        $(document).on('submit', '#request_form', function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '{{route('request.store')}}',
                method: 'post',
                dataType: 'json',
                data: formData,
                beforeSend: function () {
                    $('#requestSubmit').text('Sending Request ...');
                },
                success: function (data) {
                    if (data.errors.length > -1){
                        $.each(data.errors,function(index,error) {
                            $(error.name).html('<span class="text-danger">'+error.message+'<span>');
                        });
                    }
                    else {
                        Swal.fire({
                            position: 'center',
                            type: 'success',
                            title: 'Success...',
                            text: 'Your request has been sent.'
                        });
                        $('#request_form')[0].reset();
                        $('#request_form .help-block').html('');
                    }
                    $('#requestSubmit').text('Send Request');
                        },
                error: function () {
                    Swal.fire({
                        position: 'center',
                        type: 'error',
                        title: 'Oppss...',
                        text: 'Unable to send request.\n We are having some issues.'
                    });
                    $('#requestSubmit').text('Send Request');
                }
            });
        });
    });
</script>
@include('partials._message')
@yield('script')
</body>
</html>