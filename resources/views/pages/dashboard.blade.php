@extends('layouts.main')
@section('title','Dashboard')
@section('content')
    <!-- Container -->
    <div class="container-fluid">
        <!-- Title -->
        <div class="hk-pg-header">
            <h4 class="hk-pg-title"><span class="pg-title-icon"><i class="zmdi zmdi-calendar-account"></i></span>Attendance Sheet</h4>
        </div>
        <!-- /Title -->
        <!-- Row -->
        <div class="row">
            <div class="col-md-8">
                <section class="hk-sec-wrapper">
                    <h5 class="hk-sec-title">Your Attendance</h5>
                    <p class="mb-40">Add advanced interaction controls to HTML tables like <code>search, pagination & selectors</code>. For responsive table just add the <code>responsive: true</code> to your DataTables function. <a href="https://datatables.net/reference/option/" target="_blank">View all options</a>.</p>
                    <div class="row">
                        <div class="col-sm">
                            <div class="table-wrap">
                                <table id="datable_1" class="table table-hover w-100 display pb-30">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                        <th>Age</th>
                                        <th>Start date</th>
                                        <th>Salary</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Tiger Nixon</td>
                                        <td>System Architect</td>
                                        <td>Edinburgh</td>
                                        <td>61</td>
                                        <td>2011/04/25</td>
                                        <td>$320,800</td>
                                    </tr>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Office</th>
                                        <th>Age</th>
                                        <th>Start date</th>
                                        <th>Salary</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="col-md-4">
                <form method="POST" action="{{ route('login') }}">
                    {{csrf_field()}}
                    <p class="text-center lead mb-30">Mark your Attendance.</p>
                    <div class="form-group {{ $errors->has('email') ? ' is-invalid' : '' }}">
                        <input id="email" name="email" class="form-control" placeholder="Email" type="email"
                               required>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('password') ? ' is-invalid' : '' }}">
                        <div class="input-group">
                            <input name="password" class="form-control" placeholder="Password"
                                   type="password" required>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="custom-control custom-checkbox mb-25">
                        <input name="remember" class="custom-control-input" id="remember"
                               type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                    </div>
                    <button class="btn btn-primary btn-block" type="submit">Login</button>
                </form>
            </div>
        </div>
        <!-- /Row -->

    </div>
    <!-- /Container -->
@stop