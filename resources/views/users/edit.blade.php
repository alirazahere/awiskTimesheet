@extends('layouts.main')
@section('title','Manage User')
@section('stylesheet')
    <!-- Data Table CSS -->
    {{--    <link href="{{asset('vendors/datatables.net-dt/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css')}}"/>--}}
    {{--    <link href="{{asset('vendors/datatables.net-responsive-dt/css/responsive.dataTables.min.css')}}" rel="stylesheet"--}}
    {{--          type="text/css"/>--}}
@endsection
@section('content')
    <!-- Container -->
    <div class="container-fluid">
        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="zmdi zmdi-comment-edit"></i></span>Edit User
                Info</h4>
        </div>
        <!-- /Title -->
        <!-- Row -->
        <div class="row">
            <div class="col-md-8">
                <section class="hk-sec-wrapper">
                    <h5 class="hk-sec-title">Edit User Attendance</h5>
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
                                        <th>TimeInDate</th>
                                        <th>TimeOut</th>
                                        <th>TimeOutDate</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Modal -->
                <div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                     aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Attendance</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" id="EditAtdForm">
                                    {{csrf_field()}}
                                    <input name="id" id="id" type="hidden">
                                    <div class="form-group error_message"></div>
                                    <div class="form-group">
                                        <label for="timein">TimeIn:</label>
                                        <input name="timein" class="form-control" id="timein" type="time">
                                        <span class="help-block timein_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="timein_date">TimeIn Date:</label>
                                        <input name="timein_date" class="form-control" id="timein_date" type="date">
                                        <span class="help-block timein_date_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="timeout">TimeOut:</label>
                                        <input name="timeout" class="form-control" id="timeout" type="time">
                                        <span class="help-block timeout_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="timeout_date">TimeOut Date:</label>
                                        <input name="timeout_date" class="form-control" id="timeout_date" type="date">
                                        <span class="help-block timeout_date_error"></span>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-outline-grey" data-dismiss="modal">Close
                                        </button>
                                        <button id="editAtd_submit" type="submit" class="btn btn-outline-primary">
                                            Submit
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{--           End of Modal --}}
            <div class="col-md-4 create_atd_form">
                <form method="post" class="card p-2" action="{{route('user.update',$user->id)}}">
                    {{csrf_field()}}
                    {{method_field('PATCH')}}
                    <h3 class="title display-5 mb-15 text-center">User Info</h3>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input class="form-control" value="{{$user->email}}" id="email" disabled="disabled"
                               type="email">
                    </div>
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input name="name" id="name" required
                               class="form-control {{$errors->has('name')?'is-invalid':''}}"
                               placeholder="First name" value="{{$user->name}}" type="text">
                        @if ($errors->has('name'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="role">Role:</label>
                        <select id="role" name="role" class="form-control" required>
                            @foreach ($roles as $role)
                                <option {{$role->role == $user->UserRole->role->role ? 'selected': '' }} value="{{$role->id}}">
                                    {{$role->role}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('role'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <button class="btn btn-outline-primary btn-block" type="submit">Submit</button>
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
            $('#atd_table').DataTable({
                processing: true,
                serverSide: true,
                dataType: 'json',
                ajax: '{!! route('datatable.get_userattendances',$user->id) !!}',
                columns: [
                    {data: 'time_in', name: 'time_in'},
                    {data: 'timein_date', name: 'timein_date'},
                    {data: 'time_out', name: 'time_out'},
                    {data: 'timeout_date', name: 'timeout_date'},
                    {data: 'action', orderable: false, searchable: false},
                ]
            });
            $(document).on('click', '#btn_edit', function () {
                $('#EditAtdForm .help-block').html('');
                var token = $('meta[name="csrf-token"]').attr("content");
                var id = $(this).data('id');
                $.ajax({
                    url: '{{route('atdAjax.fetchAtd')}}',
                    method: 'post',
                    dataType: 'json',
                    data: {id: id, _token: token},
                    success: function (data) {
                        if (data != null){
                            $('#EditAtdForm #id').val(id);
                            $('#EditAtdForm #timein').val(data.timein);
                            $('#EditAtdForm #timein_date').val(data.timein_date);
                            $('#EditAtdForm #timeout').val(data.timeout);
                            $('#EditAtdForm #timeout_date').val(data.timeout_date);
                            $('#EditModal').modal('show');
                        }
                    },
                    error: function () {
                        Swal.fire({
                            position: 'center',
                            type: 'error',
                            title: 'Oppss...',
                            text: 'Unable to perform the action.\n We are having some issues.'
                        });
                    }
                });
            });

            $(document).on('click', '#btn_delete', function () {
                if (confirm('Are you sure you want delete ?')) {
                    var token = $('meta[name="csrf-token"]').attr("content");
                    var id = $(this).data('id');
                    $.ajax({
                        url: '{{route('atdAjax.deleteAtd')}}',
                        method: 'post',
                        dataType: 'json',
                        data: {id: id, _token: token},
                        success: function (data) {
                            if (data == 'success') {
                                Swal.fire({
                                    position: 'center',
                                    type: 'success',
                                    title: 'Deleted...',
                                    text: 'Attendance has been deleted.'
                                });
                                $('#atd_table').DataTable().ajax.reload();
                            } else {
                                Swal.fire({
                                    position: 'center',
                                    type: 'error',
                                    title: 'Oppss...',
                                    text: 'Unable to delete attendance.'
                                });
                            }
                        },
                        error: function () {
                            Swal.fire({
                                position: 'center',
                                type: 'error',
                                title: 'Oppss...',
                                text: 'Unable to perform the action.\n We are having some issues.'
                            });
                        }
                    });
                }
            });

            $(document).on('submit', '#EditAtdForm', function (e) {
                e.preventDefault();
                var form_data = $(this).serialize();
                $.ajax({
                    url: '{{route('atdAjax.updateAtd')}}',
                    method: 'post',
                    dataType: 'json',
                    data: form_data,
                    beforeSend: function () {
                        $('#editAtd_submit').text('Submitting...');
                    },
                    success: function (data) {
                        if (data.errors.length > -1) {
                            $.each(data.errors,function(index,error) {
                                $('#EditAtdForm '+error.name).html('<span class="text-danger">'+error.message+'<span>');
                            });
                        } else {
                            Swal.fire({
                                position: 'center',
                                type: 'success',
                                title: 'Success...',
                                text: 'Attendance is updated.'
                            });
                            $('#atd_table').DataTable().ajax.reload();
                            $('#EditModal').modal('hide');
                            $('#EditAtdForm .help-block').html('');
                        }
                        $('#editAtd_submit').text('Submit');
                    },
                    error: function () {
                        Swal.fire({
                            position: 'center',
                            type: 'error',
                            title: 'Oppss...',
                            text: 'Unable to perform the action.\n We are having some issues.'
                        });
                        $('#editAtd_submit').text('Submit');
                    }
                });
            });
        });
    </script>
@stop