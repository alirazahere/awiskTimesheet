@extends('layouts.main')
@section('title','Dashboard')
@section('stylesheet')
    <!-- Data Table CSS -->
    <link href="{{asset('vendors/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css')}}"/>
    <link href="{{asset('vendors/datatables.net-responsive-dt/css/responsive.dataTables.min.css')}}" rel="stylesheet"
          type="text/css"/>
@endsection
@section('content')
    <!-- Container -->
    <div class="container-fluid">
        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="zmdi zmdi-calendar-account"></i></span>Attendance
                Sheet</h4>
        </div>
        <!-- /Title -->
        <!-- Row -->
        <div class="row">
            <div class="col-md-8">
                <section class="hk-sec-wrapper">
                    <h5 class="hk-sec-title">Your Attendance</h5>
                    <p class="mb-40">Add advanced interaction controls to HTML tables like <code>search, pagination &
                            selectors</code>. For responsive table just add the <code>responsive: true</code> to your
                        DataTables function. <a href="https://datatables.net/reference/option/" target="_blank">View all
                            options</a>.</p>
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-wrap">
                                <table id="atd_table" class="table table-hover w-100 display pb-30">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Time In</th>
                                        <th>TimeOut</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody class="atd_table_body">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-4 create_atd_form">
                <form method="POST" class="card p-2" action="{{ route('attendance.store') }}">
                    {{csrf_field()}}
                    <p class="text-center lead mb-30">Mark your Attendance.</p>
                    <div class="form-group row {{ $errors->has('timein') ? ' is-invalid' : '' }}">
                        <div class="col-md-3">
                            <label class="pt-2" for="timein">TimeIn</label>
                        </div>
                        <div class="col-md-9">
                            <input id="timein" name="timein" class="form-control" placeholder="TimeIn" type="time"
                                   required>
                            @if ($errors->has('timein'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('timein') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row {{ $errors->has('timeout') ? ' is-invalid' : '' }}">
                        <div class="col-md-3">
                            <label class="pt-2" for="timein">TimeOut</label>
                        </div>
                        <div class="col-md-9">
                            <input id="timeout" name="timeout" class="form-control" placeholder="TimeOut"
                                   type="time"
                                   required>
                            @if ($errors->has('timeout'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('timeout') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-3">
                            <label class="p-2" for="Date">Date</label>
                        </div>
                        <div class="col-md-9">
                            <input value="{{\Carbon\Carbon::now()->format('Y-m-d')}}" id="Date" disabled
                                   class="form-control" placeholder="TimeOut" type="date">
                        </div>
                    </div>
                    <button class="btn btn-primary btn-block" type="submit">Mark Attendance</button>
                </form>
            </div>
        </div>
        <!-- /Row -->

    </div>
    <!-- /Container -->
@endsection
@section('script')
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script>
        $(document).ready(function () {
            create_atd_form();
            fill_atd_table();

            function fill_atd_table() {
                $.ajax({
                    url: '{{route('attendance.index')}}',
                    dataType: "json",
                    success: function (data) {
                        var table_data = '';
                        for (var i = 0; i < data.length; i++) {
                            var date = moment(data[i].created_at).format('DD-MM-YYYY');
                            table_data += '<tr>' +
                                ' <td>' + (i+1) + '</td><td>' +date+ '</td><td>' + data[i].timein + '</td>' +
                                '<td>' + data[i].timeout + '</td><td></td></tr>';
                        }
                         $('.atd_table_body').html(table_data);
                        $('#atd_table').DataTable();
                    }
                });
            }

            function create_atd_form() {
                $.ajax({
                    url: '{{route("attendance.create")}}',
                    dataType: "json",
                    success: function (data) {
                        if (data.output == 'true') {
                            $('#timein').attr('disabled', 'true');
                            $('#timein').val(data.value);
                        } else {
                            var marked = '<div class="alert alert-success" role="alert">\n' +
                                '                                                <h4 class="alert-heading mb-10">Well done !</h4>\n' +
                                '                                                <p>You have successfully marked your attendance.</p>\n' +
                                '                                                <hr class="hr-soft-success">\n' +
                                '                                                <p>if you have any queries contact your supervisor.</p>\n' +
                                '                                            </div>';
                            $('.create_atd_form').html(marked);
                        }
                    }
                });
            }
        });
    </script>
@endsection 