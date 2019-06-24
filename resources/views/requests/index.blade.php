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
                    @if (Auth::user()->role->first()->role == "LineManager")
                        <div class="col-md-12 reload_sec">
                            <div class="accordion accordion-type-2" id="accordion_2">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between">
                                        <a role="button" data-toggle="collapse" href="#collapse_1i"
                                           aria-expanded="false"
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
                                                                    Date: {{ date('Y-m-d',strtotime($request->timein)) }}
                                                                    /
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
                                                                <li> Message: {{$request->message}} </li>
                                                            </ul>
                                                            <a class="text-right btn_approve"
                                                               data-id="{{ $request->id }}"
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
                                        <a role="button" data-toggle="collapse" href="#collapse_2i"
                                           aria-expanded="false"
                                           class="collapsed">Approved Requests</a>
                                    </div>
                                    <div id="collapse_2i" class="collapse" data-parent="#accordion_2" role="tabpanel"
                                         style="">
                                        <div class="card-body pa-15">
                                            <ul class="list-group">
                                                @if ( count($pendingRequests)>0)
                                                    @foreach ($pendingRequests as $request)
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            <ul class="list-group">
                                                                <li>
                                                                    User: {{$request->User->name}} / New
                                                                    Date: {{ date('Y-m-d',strtotime($request->timein)) }}
                                                                    /
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
                                                                <li>
                                                                    Remarks: {{ empty($request->remark) ? 'No remarks' : $request->remark }} </li>
                                                            </ul>
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
                    @else

                    @endif

                </div>
            </div>
        </div>
    </section>
    {{-- Remarks Modal   --}}
    <!-- Modal -->
    <div class="modal fade" id="remark_modal" tabindex="-1" role="dialog" aria-labelledby="Remarks" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Remarks</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="remark_form">
                    <div class="modal-body">
                        <div class="form-group">
                            <input id="req_id" type="hidden">
                            <textarea class="form-control" id="remarks" name="remarks" id="" cols="30" rows="8"
                                      placeholder="Enter request remarks"></textarea>
                            <small class="title">*Optional</small>
                            <div class="remarks_error">
                                <ul>

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="remark_btn" class="btn btn-primary">Approve Request.</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script>
        $(document).ready(function () {
            $(document).on('click', '.btn_approve', function (e) {
                e.preventDefault();
                var req_id = $(this).data("id");
                $('.remarks_error ul').html('');
                if (req_id != null) {
                    $('#req_id').val(req_id);
                    $('#remark_modal').modal('show');
                }
            });
            $(document).on('submit', '#remark_form', function (e) {
                e.preventDefault();
                var token = $('meta[name="csrf-token"]').attr("content");
                var req_id = $('#req_id').val();
                var remark = $('#remarks').val();
                $.ajax({
                    url: '{{route("request.approve")}}',
                    method: 'post',
                    dataType: 'json',
                    data: {id: req_id, _token: token, remark: remark},
                    success: function (data) {
                        if (data.errors.length <= 0) {
                            $(".reload_sec").load("{{route('request.index')}} .reload_sec");
                            $('#remark_modal').modal('hide');
                            Swal.fire({
                                position: 'center',
                                type: 'success',
                                title: 'Success...',
                                text: 'Your request has been approved.'
                            });
                        } else {
                            $error = '';
                            $.each(data.errors, function (index, error) {
                                $output += '<li>' + error + '</li>';
                            });
                            $('.remarks_error ul').html($error);
                        }
                    }
                });
            });
        });
    </script>
@stop