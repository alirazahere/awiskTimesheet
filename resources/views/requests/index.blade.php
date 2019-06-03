@extends('layouts.main')
@section('title','Requests')
@section('content')
    <section class="hk-sec-wrapper">
        <h5 class="hk-sec-title">User Requests</h5>
        <p class="mb-25">Add badges to any list group item to show unread counts, activity, and more with the help of some flex utilities.</p>
        <div class="row">
            <div class="col-sm">
                <div class="row">
                    <div class="col-md-12">
                        <ul class="list-group">
                            @foreach ($requests as $request)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    User: {{$request->User->name}} / New Date: {{ date('Y-m-d',strtotime($request->timein)) }} / New Timein: {{ date('h:i a',strtotime($request->timein)) }} / New Timeout: {{ date('h:i a',strtotime($request->timeout)) }}
                                    / Old Date: {{ date('Y-m-d',strtotime($request->Attendance->timein)) }} / Old Timein: {{ date('h:i a',strtotime($request->Attendance->timein)) }} / Old Timeout: {{ date('h:i a',strtotime($request->Attendance->timeout)) }}
                                    <a style="font-size:18px;" onclick="event.preventDefault();" href="#"><i class="zmdi zmdi-check-circle"></i></a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop