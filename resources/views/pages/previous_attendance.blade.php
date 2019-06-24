@extends('layouts.main')
@section('title','Previous Attendance')
@section('content')
    <!-- Container -->
    <div class="container-fluid">
        <!-- Row -->
        <div class="row">
            <div class="col-md-12">
                <section class="hk-sec-wrapper">
                    <h5 class="hk-sec-title mt-md-2">Mark Previous Attendances</h5>
                    <p class="mb-40">Add advanced interaction controls to HTML tables like <code>search, pagination &
                            selectors</code>. For responsive table just add the <code>responsive: true</code> to your
                        DataTables function. <a href="https://datatables.net/reference/option/" target="_blank">View all
                            options</a>.</p>
                    <div class="row justify-content-center">
                        {{-- Form--}}
                        <form method="post" class="hk-sec-wrapper" id="prev_atd_form" style="width:50%;">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="label" for="timein">Time In</label>
                                <input type="time" name="timein" id="timein" class="form-control">
                                <div class="errors timein_error"></div>
                            </div>
                            <div class="form-group">
                                <label class="label" for="timein_date">Time In Date</label>
                                <input type="date" name="timein_date" id="timein_date" class="form-control">
                                <div class="errors timein_date_error"></div>
                            </div>
                            <div class="form-group">
                                <label class="label" for="timeout">Time Out</label>
                                <input type="time" name="timeout" id="timeout" class="form-control">
                                <div class="errors timeout_error"></div>
                            </div>
                            <div class="form-group">

                                <label class="label" for="timeout_date" style="width: 100% !important; cursor:pointer;">
                                    <span class=" badge badge-info float-right" id="sameDate">
                                        Same as Time In Date
                                    </span>
                                    Time Out Date
                                </label>
                                <input type="date" name="timeout_date" id="timeout_date" class="form-control">
                                <div class="errors timeout_date_error"></div>
                            </div>
                            <div class="form-group">
                                <button type="submit" id="prev_atd_submit" class="btn btn-outline-primary btn-block">
                                    Submit Attendance
                                </button>
                                <button type="reset" class="btn btn-outline-danger btn-block">Reset Form</button>
                            </div>
                        </form>
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
            $('#sameDate').click(function () {
                var timein = $('#timein_date').val();
                if (timein != null) {
                    $('#timeout_date').val(timein);
                }
            });
            $(document).on('submit', '#prev_atd_form', function (e) {
                e.preventDefault();
                $('.errors').html('');
                var data = $('#prev_atd_form').serialize();
                $.ajax({
                    url: '{{route("attendance.previous.store")}}',
                    method: 'post',
                    data: data,
                    dataType: 'json',
                    beforeSend: function () {
                        $('#prev_atd_submit').html('Submitting....');
                    },
                    success: function (data) {
                        if (data == 'success') {
                            Swal.fire({
                                position: 'center',
                                type: 'success',
                                title: 'Submitted.',
                                html: 'You previous attendance has been submitted.'
                            });
                        } else {
                            $.each(data, function (index, error) {
                                $(error.name).html('<span class="text-danger">' + error.message + '<span>');
                            });
                        }
                    },
                    error: function () {
                        Swal.fire({
                            position: 'center',
                            type: 'error',
                            title: 'Oppss...',
                            html: 'Unable to send request.<br> We are having some issues.'
                        });
                    }
                });
                $('#prev_atd_submit').html('Submit Attendance');
            });
        });
    </script>
@stop
