@extends('layouts.main')
@section('title','Manage User')
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
                                <table id="atd_table" class="table table-hover w-100 display pb-30">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody class="atd_table_body">
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->UserRole->Role->role }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary">Edit</button>
                                                <button type="button" class="btn btn-sm btn-danger">Delete</button>
                                            </td>
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
                <form method="POST"  class="card p-2" action="{{ route('attendance.store') }}" id="theform">
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
                        <input id="password"
                               class="form-control" placeholder="password" type="password">
                    </div>
                    <button class="btn btn-primary btn-block" type="submit">Create User</button>
                </form>
            </div>
        </div>
        <!-- /Row -->

    </div>
    <!-- /Container -->
@endsection
@section('script')
@endsection