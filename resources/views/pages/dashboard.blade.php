@extends('layouts.main')
@section('title','Dashboard')
@section('content')
    <!-- Container -->
    <div class="container-fluid">
        {{-- Title --}}
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><i
                            class="zmdi zmdi-calendar-account"></i></span>Attendance
                Sheet</h4>
            <small>logged in as {{ Auth::user()->Role()->first()->role }}</small>
        </div>
        <!-- /Title -->
        <!-- Row -->
        <div class="row">
            <div class="col-md-12">
                <section class="hk-sec-wrapper justify-content-between">
                    <div class="row">
                        <div class="col-md-8 justify-content-between">
                            <h5 class="hk-sec-title mt-md-2">Your Attendance </h5>
                        </div>
                        <div class="col-md-4 atd_form justify-content-between">
                            <form id="atd_form" action="{{ route('attendance.store') }}">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <button name="submit" id="atd_submit" value="submit"
                                            class="btn btn-outline-primary btn-block"
                                            type="submit">
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <p class="mb-40">Add advanced interaction controls to HTML tables like <code>search, pagination &
                            selectors</code>. For responsive table just add the <code>responsive: true</code> to your
                        DataTables function. <a href="https://datatables.net/reference/option/" target="_blank">View all
                            options</a>.</p>
                    <div class="row">
                        <div class="col-md-5">
                            <input value="06-2019" PLACEHOLDER="Select Month and Year" class="form-control" id="table_date" type="text">
                        </div>
                        <div class="col-md-7">
                            <button type="button" id="table_search" class="btn btn-primary">Search</button>
                            <button type="button" id="table_all" class="btn btn-info">Show All</button>
                        </div>
                    </div>
                    <br>
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
                                        <th>Request</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Requests Modal -->
                    <div class="modal fade" id="request_modal" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Make Request</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="request_form" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" id="atd_id" name="atd_id">
                                        <div class="form-group">
                                            <label for="timein">Timein : </label>
                                            <input id="timein" placeholder="Timein" class="form-control time_picker"
                                                   name="timein"
                                                   type="time">
                                            <span class="help-block timein_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="timein_date">Timein Date : </label>
                                            <input id="timein_date" placeholder="Timein Date"
                                                   class="form-control date_picker" name="timein_date"
                                                   type="date">
                                            <span class="help-block timein_date_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="timein">Timeout : </label>
                                            <input id="timeout" placeholder="Timeout"
                                                   class="form-control time_picker"
                                                   name="timeout"
                                                   type="time">
                                            <span class="help-block timeout_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="timeout_date">Timeout Date : </label>
                                            <input id="timeout_date" placeholder="Timeout Date"
                                                   class="form-control date_picker"
                                                   name="timeout_date"
                                                   type="date">
                                            <span class="help-block timeout_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label for="message">Message : </label>
                                            <textarea id="message" placeholder="Your Message."
                                                      class="form-control" name="message"
                                                      type="text"></textarea>
                                            <span class="help-block message_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                            </button>
                                            <button id="requestSubmit" type="submit" class="btn btn-outline-primary">
                                                Send Request
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
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
            $("#table_date").datepicker({
                format: "mm-yyyy",
                viewMode: "months",
                minViewMode: "months"
            });
            var table = $('#atd_table').DataTable({
                processing: true,
                serverSide: true,
                dataType: 'json',
                ajax: {
                    url: '{!! route('datatable.get_attendances') !!}',
                    type: 'GET',
                    data: function (d) {
                        d.search_atd = $('#table_date').val();
                    }
                },
                columns: [
                    {data: 'time_in', name: 'time_in'},
                    {data: 'timein_date', name: 'timein_date'},
                    {data: 'time_out', name: 'time_out'},
                    {data: 'timeout_date', name: 'timeout_date'},
                    {data: 'action', name: 'action'},
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
                                '                                                <p class="alert-heading">Your today attendance has been marked!</p></div>';
                            $('.atd_form').html(message);
                        } else if (data.output == 'success') {
                            $('#atd_submit').html(data.submit_text);
                            $('#atd_submit').val(data.submit);
                            $('.atd_message').html('');
                        } else if (data.output == 'warning') {
                            var message = '<div class="alert alert-warning alert-wth-icon alert-dismissible fade show" role="alert">\n' +
                                '                                        <span class="alert-icon-wrap"><i class="zmdi zmdi-help"></i></span>' + data.message + '' +
                                '                                    </div>';
                            $('.atd_message').html(message);
                            $('#atd_submit').val(data.submit);
                            $('#date').val(data.date);
                            $('#atd_submit').text(data.submit_text);
                        } else {
                            var message = '<div class="alert alert-danger" role="alert">\n' +
                                '                                                <h4 class="alert-heading mb-10">Error!</h4>\n' +
                                '                                                <p>We are having some issues rightnow.</p>\n' +
                                '                                                <hr class="hr-soft-danger">\n' +
                                '                                            </div>';
                            $('.atd_form').html(message);
                        }
                    }
                });
            }

            $('#atd_form').on('submit', function (e) {
                e.preventDefault();
                var token = $('meta[name="csrf-token"]').attr("content");
                var submit = $('#atd_submit').val();
                $.ajax({
                    url: '{{route('attendance.store')}}',
                    method: 'post',
                    data: {_token: token, submit: submit},
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
                                html: "Successfully " + data.status + ".<br>Your " + data.status + " time is " + data.message
                            });
                        } else {
                            Swal.fire({
                                position: 'center',
                                type: 'error',
                                title: 'Oppss...',
                                html: 'Unable to perform the action.<br>We are having some issues.'
                            });
                        }
                        $('#atd_table').DataTable().ajax.reload();
                    },
                    error: function () {
                        Swal.fire({
                            position: 'center',
                            type: 'error',
                            title: 'Oppss...',
                            html: 'Unable to perform the action.<br>We are having some issues.'
                        });
                    }
                });
                create_atd_form();
            });

            $(document).on('submit', '#request_form', function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: '{{route('request.store')}}',
                    method: 'post',
                    dataType: 'json',
                    data: formData,
                    beforeSend: function () {
                        $('#requestSubmit').text('Sending Requests ...');
                    },
                    success: function (data) {
                        if (data.errors.length > 0) {
                            $.each(data.errors, function (index, error) {
                                $(error.name).html('<span class="text-danger">' + error.message + '<span>');
                            });
                        } else {
                            Swal.fire({
                                position: 'center',
                                type: 'success',
                                title: 'Success...',
                                text: 'Your request has been sent.'
                            });
                            $('#request_form')[0].reset();
                            $('#request_form .help-block').html('');
                            $('#request_modal').modal('hide');
                        }
                        $('#requestSubmit').text('Send Requests');
                    },
                    error: function () {
                        Swal.fire({
                            position: 'center',
                            type: 'error',
                            title: 'Oppss...',
                            html: 'Unable to send request.<br> We are having some issues.'
                        });
                        $('#requestSubmit').text('Send Requests');
                    }
                });
            });

            $(document).on('click', '#request_btn', function () {
                $('#request_form .help-block').html('');
                var token = $('meta[name="csrf-token"]').attr("content");
                var id = $(this).data('id');
                $.ajax({
                    url: '{{route('atdAjax.fetchAtd')}}',
                    method: 'post',
                    dataType: 'json',
                    data: {id: id, _token: token},
                    success: function (data) {
                        if (data != null) {
                            $.each(data, function (index, value) {
                                $("#request_form " + index).val(value);
                            });
                            $('#request_modal').modal('show');
                        }
                    },
                    error: function () {
                        Swal.fire({
                            position: 'center',
                            type: 'error',
                            title: 'Oppss...',
                            html: 'Unable to send request.<br> We are having some issues.'
                        });
                        $('#request_modal').modal('hide');
                    }
                });
            });
            $(document).on('click', '#table_search', function () {
                table.draw(true)
            });
            $(document).on('click', '#table_all', function () {
                $('#table_date').val('');
                table.draw(true)
            });
        });
    </script>
@endsection 