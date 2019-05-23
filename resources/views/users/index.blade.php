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
            <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="zmdi zmdi-settings"></i></span>User
                Management</h4>
        </div>
        <!-- /Title -->
        <!-- Row -->
        <div class="row">
            <div class="col-md-8">
                <section class="hk-sec-wrapper">
                    <h5 class="hk-sec-title">Manage User</h5>
                    <p class="mb-40">Add advanced interaction controls to HTML tables like <code>search, pagination &
                            selectors</code>. For responsive table just add the <code>responsive: true</code> to your
                        DataTables function. <a href="https://datatables.net/reference/option/" target="_blank">View all
                            options</a>.</p>
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-wrap">
                                <table id="user_table" class="table table-hover w-100 display pb-30">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-4 create_atd_form">
                <form method="POST" class="card p-2" action="{{ route('user.store') }}">
                    {{csrf_field()}}
                    <p class="text-center lead mb-30">Create User</p>
                    <div class="form-group messages"></div>
                    <div class="form-group timein_field">
                        <label class="mt-2" for="name">Name</label>
                        <input id="name" name="name"
                               class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                               placeholder="Name" type="text" required
                        >
                        @if ($errors->has('name'))
                            <span class="help-block">
                                        <small class="text-danger">{{ $errors->first('name') }}</small>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group timeout_field">
                        <label class="mt-2" for="email">Email</label>
                        <input id="email" name="email"
                               class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                               placeholder="Email"
                               type="email" required
                        >
                        @if ($errors->has('email'))
                            <span class="help-block">
                                        <small class="text-danger">{{ $errors->first('email') }}</small>
                                    </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="mt-2" for="password">Password</label>
                        <input id="password" name="password"
                               class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                               placeholder="Password" type="password">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                        <small class="text-danger">{{ $errors->first('password') }}</small>
                                    </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label class="mt-2" for="password-confirm">Confirm Password</label>
                        <input id="password-confirm" placeholder="Confirm Password" type="password" class="form-control"
                               name="password_confirmation"
                               required>
                    </div>

                    <div class="form-group">
                        <label class="mt-2" for="role">Role</label>
                        <select class="form-control {{ $errors->has('role') ? 'is-invalid' : '' }}" name="role"
                                required>
                            <option selected disabled>Select user role</option>
                            @foreach ($roles as $role)
                                <option value="{{$role->id}}">{{$role->role}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('role'))
                            <span class="help-block">
                                        <small class="text-danger">{{ $errors->first('role') }}</small>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <button class="btn btn-outline-primary btn-block" type="submit">Create User</button>
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
            $('#user_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('datatable.get_users') !!}',
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'role', name: 'role'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
            $(document).on('click', '#btn_delete', function () {
                if (confirm('Are your sure you want to delete this user ?')) {
                    var token = $('meta[name="csrf-token"]').attr("content");
                    var id = $(this).data('id');
                    $.ajax({
                        url: '{{url('user')}}/' + id + '',
                        method: 'Post',
                        data: {_method: 'DELETE', _token: token},
                        dataType: 'json',
                        success: function (data) {
                            if (data == 'success') {
                                $('#user_table').DataTable().ajax.reload();
                                Swal.fire({
                                    type: 'success',
                                    title: 'Success...',
                                    text: 'User has been deleted.'
                                })
                            } else {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Oops...',
                                    text: 'Something went wrong!'
                                })
                            }
                        }

                    });
                }
            });
        });
    </script>
@endsection