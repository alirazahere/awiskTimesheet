@extends('layouts.main')
@section('title','Dashboard')
@section('content')
    <!-- Container -->
    <div class="container-fluid">
        {{-- Title --}}
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
                    <h5 class="hk-sec-title">Your Attendance {{Auth::user()->Attendance[0]->created_at}}</h5>
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
                                        <th>TimeIn</th>
                                        <th>TimeIn Date</th>
                                        <th>TimeOut</th>
                                        <th>TimeOut Date</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-4 atd_form">
                <form id="atd_form" class="card p-2" action="{{ route('attendance.store') }}">
                    {{csrf_field()}}
                    <p class="text-center lead mb-30">Mark your Attendance.</p>
                    <div class="form-group atd_message"></div>

                    <div class="form-group">
                        <label class="mt-2" for="date">Date</label>
                        <input id="date" disabled
                               class="form-control" placeholder="Date" type="date">
                    </div>

                    <div class="form-group">
                        <button id="atd_submit" class="btn btn-outline-primary btn-block" type="submit">Mark Your
                            TimeIn
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /Row -->

    </div>
    <!-- /Container -->
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            create_atd_form();
            $('#atd_table').DataTable({
                processing: true,
                serverSide: true,
                dataType:'json',
                ajax: '{!! route('datatable.get_attendances') !!}',
                columns: [
                    {data: 'timein', name: 'timein'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'timeout', name: 'timeout'},
                    {data: 'timeout_date', name: 'timeout_date'},
                ]
            });

            function create_atd_form() {
                var token = $('meta[name="csrf-token"]').attr("content");
                $.ajax({
                    url: '{{route("attendance.create")}}',
                    method: 'post',
                    data: {_token: token},
                    dataType: "json",
                    success: function (data) {
                        if (data.output == 'default') {
                            var message = '<div class="alert alert-success" role="alert">\n' +
                                '                                                <h4 class="alert-heading mb-10">You are done for the day!</h4>\n' +
                                '                                                <p>Your attendance has been marked.</p>\n' +
                                '                                                <hr class="hr-soft-success">\n' +
                                '                                                <p>If you have any queries contact your supervisor.</p>\n' +
                                '                                            </div>';
                            $('.atd_form').html(message);
                        } else if (data.output == 'false') {
                            $('#date').val(data.date);
                            $('#atd_submit').html('Mark Your TimeIn');
                        } else if (data.output == 'true') {
                            $('#date').val(data.date);
                            $('#atd_submit').html('Mark Your TimeOut');
                        } else if (data.output == 'error') {
                            var message = '<div class="alert alert-warning" role="alert">\n' +
                                '                                                <h4 class="alert-heading mb-10">You did not marked your previous timeout.</h4>\n' +
                                '                                                <p>Marked your previous timeout.</p>\n' +
                                '                                                <hr class="hr-soft-warning">\n' +
                                '                                            </div>';
                            $('.atd_form').html(message);
                        } else {
                            var message = '<div class="alert alert-danger" role="alert">\n' +
                                '                                                <h4 class="alert-heading mb-10">Error!</h4>\n' +
                                '                                                <p>We are having some issues rightnow.</p>\n' +
                                '                                                <hr class="hr-soft-danger">\n' +
                                '                                            </div>';
                            $('.atd_message').html(message);
                        }
                    }
                });
            }

            $('#atd_form').on('submit', function (e) {
                e.preventDefault();
                var token = $('meta[name="csrf-token"]').attr("content");
                $.ajax({
                    url: '{{route('attendance.store')}}',
                    method: 'post',
                    data:{_token: token},
                    dataType: 'json',
                    beforeSend: function () {
                        $('#atd_submit').text('Processing...');
                    },
                    success: function (data) {
                        if (data.output == 'success') {
                            Swal.fire({
                                position: 'center',
                                type: 'success',
                                title: 'Success...',
                                text: data.message
                            });
                        } else {
                            Swal.fire({
                                position: 'center',
                                type: 'error',
                                title: 'Oppss...',
                                text: 'Unable to perform the action.\n We are having some issues.'
                            });
                        }
                        create_atd_form();
                    }
                });
            });

        });
    </script>
@endsection 