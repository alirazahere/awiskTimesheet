@extends('layouts.main')
@section('title','Requests')
@section('content')
    <section class="hk-sec-wrapper">
        <h5 class="hk-sec-title display-6">User Requests</h5>
        <p class="mb-25">Add badges to any list group item to show unread counts, activity, and more with the help of
            some flex utilities.</p>
        <div class="row">
            <div class="col-sm">
                <div class="row">
                    <div class="col-md-12 reload_sec">
                        <div class="accordion accordion-type-2" id="accordion_2">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <a role="button" data-toggle="collapse" href="#collapse_1i" aria-expanded="false"
                                       class="collapsed">Current Requests</a>
                                </div>
                                <div id="collapse_1i" class="collapse" data-parent="#accordion_2" role="tabpanel"
                                     style="">
                                    <div class="card-body pa-15">
                                        <ul class="list-group">
                                            @if (count($requests)>0)
                                                @foreach ($requests as $request)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <ul class="list-group">
                                                            <li>
                                                                User: {{$request->User->name}} / New
                                                                Date: {{ date('Y-m-d',strtotime($request->timein)) }} /
                                                                New
                                                                Timein: {{ date('h:i a',strtotime($request->timein)) }}
                                                                / New
                                                                Timeout: {{ date('h:i a',strtotime($request->timeout)) }}
                                                                / Old
                                                                Date: {{ date('Y-m-d',strtotime($request->Attendance->timein)) }}
                                                                / Old
                                                                Timein: {{ date('h:i a',strtotime($request->Attendance->timein)) }}
                                                                / Old
                                                                Timeout: {{ date('h:i a',strtotime($request->Attendance->timeout)) }}
                                                            </li>
                                                            <li> Remarks: {{$request->message}} </li>
                                                        </ul>
                                                        <a class="text-right btn_approve" data-id="{{ $request->id }}"
                                                           style="font-size:18px;" href="#"><i
                                                                    class="zmdi zmdi-check-circle text-right"></i></a>
                                                    </li>
                                                @endforeach
                                            @else
                                                <p>No requests at this moment.</p>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header d-flex justify-content-between">
                                    <a role="button" data-toggle="collapse" href="#collapse_2i" aria-expanded="false"
                                       class="collapsed">Previous Requests</a>
                                </div>
                                <div id="collapse_2i" class="collapse" data-parent="#accordion_2" role="tabpanel"
                                     style="">
                                    <div class="card-body pa-15">
                                        <ul class="list-group">
                                            @if ( count($pendingRequests)>0)
                                                @foreach ($pendingRequests as $request)
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        User: {{$request->User->name}} / New
                                                        Date: {{ date('Y-m-d',strtotime($request->timein)) }} / New
                                                        Timein: {{ date('h:i a',strtotime($request->timein)) }} / New
                                                        Timeout: {{ date('h:i a',strtotime($request->timeout)) }}
                                                        / Old
                                                        Date: {{ date('Y-m-d',strtotime($request->Attendance->timein)) }}
                                                        / Old
                                                        Timein: {{ date('h:i a',strtotime($request->Attendance->timein)) }}
                                                        / Old
                                                        Timeout: {{ date('h:i a',strtotime($request->Attendance->timeout)) }}
                                                    </li>
                                                @endforeach
                                            @else
                                                <p>No requests at this moment.</p>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('script')
    <script>
        $(document).ready(function () {
            $(document).on('click', '.btn_approve', function (e) {
                e.preventDefault();
                var req_id = $(this).data("id");
                var token = $('meta[name="csrf-token"]').attr("content");
                $.ajax({
                    url: '{{route("request.approve")}}',
                    method: 'post',
                    dataType: 'json',
                    data: {id: req_id, _token: token},
                    success: function (data) {
                        if (data == 'success') {
                            $(".reload_sec").load("{{route('request.index')}} .reload_sec");
                            Swal.fire({
                                position: 'center',
                                type: 'success',
                                title: 'Success...',
                                text: 'Your request has been approved.'
                            });
                        } else {
                            Swal.fire({
                                position: 'center',
                                type: 'error',
                                title: 'Oppss...',
                                text: 'Unable to perform the action.\n We are having some issues.'
                            });
                        }
                    }
                });
            });
        });
    </script>
@stop