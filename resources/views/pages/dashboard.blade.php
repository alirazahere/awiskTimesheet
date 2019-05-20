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
            <small>logged in as {{ Auth::user()->UserRole->Role->role }}</small>
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
                                        <th>Date</th>
                                        <th>Time In</th>
                                        <th>TimeOut</th>
                                    </tr>
                                    </thead>
                                    <tbody class="atd_table_body">
                                    @foreach(Auth::user()->Attendance->reverse() as $attendance)
                                        <tr>
                                            <td>{{ date('j M Y',strtotime($attendance->created_at)) }}</td>
                                            <td>{{ date('H:i A',strtotime($attendance->timein))}}</td>
                                            <td>{{ $attendance->timeout == NULL ? 'Not Marked' : date('H:i A',strtotime($attendance->timeout)) }}</td>
                                        </tr>
                                    @endforeach
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
                    <div class="form-group messages"></div>
                    <div class="form-group">
                        <label class="mt-2" for="timein">TimeIn</label>
                        <input id="timein" name="timein"
                               class="form-control {{ $errors->has('timein') ? 'is-invalid' : '' }}"
                               placeholder="TimeIn" type="time" required
                        >
                        @if ($errors->has('timein'))
                            <span class="help-block">
                                        <small class="text-danger">{{ $errors->first('timein') }}</small>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="mt-2" for="timein">TimeOut</label>
                        <input id="timeout" name="timeout"
                               class="form-control {{ $errors->has('timeout') ? 'is-invalid' : '' }}"
                               placeholder="TimeOut"
                               type="time" required
                        >
                        @if ($errors->has('timeout'))
                            <span class="help-block">
                                        <small class="text-danger">{{ $errors->first('timeout') }}</small>
                                    </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="mt-2" for="Date">Date</label>
                        <input id="Date" disabled
                               class="form-control" placeholder="Date" type="date">
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
            $('#atd_table').DataTable({
                "ordering": false
            });

            function create_atd_form() {
                $.ajax({
                    url: '{{route("attendance.create")}}',
                    dataType: "json",
                    success: function (data) {
                        if (data.output == 'true') {
                            $('#timein').attr('disabled', 'true');
                            $('#Date').val(data.date);
                            $('#timein').val(data.value);
                        } else if (data.output == 'false') {
                            $('#timeout').attr('disabled', 'true');
                            $('#Date').val(data.date);
                        } else if (data.output == 'default') {
                            var marked = '<div class="alert alert-success" role="alert">\n' +
                                '                                                <h4 class="alert-heading mb-10">You are done for the day !</h4>\n' +
                                '                                                <p>You have successfully marked your attendance.</p>\n' +
                                '                                                <hr class="hr-soft-success">\n' +
                                '                                                <p>if you have any queries contact your supervisor.</p>\n' +
                                '                                            </div>';
                            $('.create_atd_form').html(marked);
                        } else if (data.output == 'error') {
                            var message = '<div class="alert alert-warning alert-wth-icon alert-dismissible fade show" role="alert">\n' +
                                '<span class="alert-icon-wrap"><i class="zmdi zmdi-help"></i></span>You did not marked your previous timeout.\n' +
                                '</div>';
                            $('#timein').attr('disabled', 'true');
                            $('#Date').val(data.date);
                            $('#timein').val(data.value);
                            $('.messages').html(message);
                        } else {
                            var warning = '<div class="alert alert-warning alert-wth-icon alert-dismissible fade show" role="alert">\n' +
                                '<span class="alert-icon-wrap"><i class="zmdi zmdi-help"></i></span>We are having some issues rightnow. Please contact your supervisor.\n' +
                                '</div>';
                            $('.create_atd_form').html(warning);
                        }
                    }
                });
            }
        });
    </script>
@endsection 