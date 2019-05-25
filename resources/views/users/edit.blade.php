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
            <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="zmdi zmdi-comment-edit"></i></span>Edit User Info</h4>
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
            </div>
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
                    {data: 'action',orderable: false,searchable: false},
                ]
            });
        });
    </script>
@stop