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
                                                                    User : {{$request->User->name}} / New
                                                                    Date
                                                                    : {{ date('Y-m-d',strtotime($request->timein)) }}
                                                                    /
                                                                    New
                                                                    Timein
                                                                    : {{ date('h:i a',strtotime($request->timein)) }}
                                                                    / New
                                                                    Timeout
                                                                    : {{ date('h:i a',strtotime($request->timeout)) }}
                                                                    / Old
                                                                    Date
                                                                    : {{ date('Y-m-d',strtotime($request->Attendance->timein)) }}
                                                                    / Old
                                                                    Timein
                                                                    : {{ date('h:i a',strtotime($request->Attendance->timein)) }}
                                                                    / Old
                                                                    Timeout
                                                                    : {{ date('h:i a',strtotime($request->Attendance->timeout)) }}
                                                                </li>
                                                                <li><span class="pa-5">Action :
                                                            <a class="btn_request_action"
                                                               data-id="{{ $request->id }}"
                                                               data-status="reject"
                                                               data-toggle="tooltip-danger" data-placement="bottom"
                                                               title="" data-original-title="Reject Request"
                                                               style="font-size:18px;" href="#"><i
                                                                        class="zmdi zmdi-minus-circle"></i></a>
                                                                <a class="btn_request_action"
                                                                   data-id="{{ $request->id }}"
                                                                   data-status="approve"
                                                                   data-toggle="tooltip-success" data-placement="bottom"
                                                                   title="" data-original-title="Approve Request"
                                                                   style="font-size:18px;" href="#"><i
                                                                            class="zmdi zmdi-check-circle"></i></a>
                                                                </span></li>
                                                                <li> Message : {{$request->message}} </li>
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
                                                @if ( count($approvedRequests)>0)
                                                    @foreach ($approvedRequests as $request)
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            <ul class="list-group">
                                                                <li>
                                                                    User : {{$request->User->name}} / New
                                                                    Date
                                                                    : {{ date('Y-m-d',strtotime($request->timein)) }}
                                                                    /
                                                                    New
                                                                    Timein
                                                                    : {{ date('h:i a',strtotime($request->timein)) }}
                                                                    / New
                                                                    Timeout
                                                                    : {{ date('h:i a',strtotime($request->timeout)) }}
                                                                    / Old
                                                                    Date
                                                                    : {{ date('Y-m-d',strtotime($request->Attendance->timein)) }}
                                                                    / Old
                                                                    Timein
                                                                    : {{ date('h:i a',strtotime($request->Attendance->timein)) }}
                                                                    / Old
                                                                    Timeout
                                                                    : {{ date('h:i a',strtotime($request->Attendance->timeout)) }}
                                                                </li>
                                                                <li>
                                                                    Remarks
                                                                    : {{ empty($request->remark) ? 'No remarks' : $request->remark }} </li>
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
                                {{--                                Rejected Request--}}
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between">
                                        <a role="button" data-toggle="collapse" href="#collapse_3i"
                                           aria-expanded="false"
                                           class="collapsed">Rejected Requests</a>
                                    </div>
                                    <div id="collapse_3i" class="collapse" data-parent="#accordion_2" role="tabpanel"
                                         style="">
                                        <div class="card-body pa-15">
                                            <ul class="list-group">
                                                @if ( count($rejectedRequests)>0)
                                                    @foreach ($rejectedRequests as $request)
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            <ul class="list-group">
                                                                <li>
                                                                    User : {{$request->User->name}} / New
                                                                    Date
                                                                    : {{ date('Y-m-d',strtotime($request->timein)) }}
                                                                    /
                                                                    New
                                                                    Timein
                                                                    : {{ date('h:i a',strtotime($request->timein)) }}
                                                                    / New
                                                                    Timeout
                                                                    : {{ date('h:i a',strtotime($request->timeout)) }}
                                                                    / Old
                                                                    Date
                                                                    : {{ date('Y-m-d',strtotime($request->Attendance->timein)) }}
                                                                    / Old
                                                                    Timein
                                                                    : {{ date('h:i a',strtotime($request->Attendance->timein)) }}
                                                                    / Old
                                                                    Timeout
                                                                    : {{ date('h:i a',strtotime($request->Attendance->timeout)) }}
                                                                </li>
                                                                <li>
                                                                    Remarks
                                                                    : {{ empty($request->remark) ? 'No remarks' : $request->remark }} </li>
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
                        <div class="row">
                            <div class="col-md-12">
                                <section class="hk-sec-wrapper justify-content-center">
                                    <p class="mb-40">Add advanced interaction controls to HTML tables like <code>search,
                                            pagination &
                                            selectors</code>. For responsive table just add the <code>responsive:
                                            true</code> to your
                                        DataTables function. <a href="https://datatables.net/reference/option/"
                                                                target="_blank">View all
                                            options</a>.</p>
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
                                                        <th>Status</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @if ( count(Auth::user()->UserRequest->all()) > 0 )
                                                        @foreach(Auth::user()->UserRequest->all() as $req)
                                                            <td>{{ date('h:i a', strtotime($req->timein)) }}</td>
                                                            <td>{{ date('Y-m-d', strtotime($req->timein)) }}</td>
                                                            <td>{{ date('h:i a', strtotime($req->timeout)) }}</td>
                                                            <td>{{ date('Y-m-d', strtotime($req->timeout)) }}</td>
                                                            <td>
                                                            <span class="badge {{$req->status == 'pending' ? 'badge-info':($req->status == 'approved' ? 'badge-success':
                                                            'badge-danger')}}">
                                                                {{ $req->status }}
                                                            </span>
                                                            </td>
                                                        @endforeach
                                                    @else
                                                        <td class="text-center" colspan="5">No data at this moment.</td>
                                                    @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
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
                            {{ csrf_field() }}
                            <input name="id" id="req_id" type="hidden">
                            <textarea class="form-control" id="remarks" name="remark" cols="30" rows="8"
                                      placeholder="Enter request remarks"></textarea>
                            <input value="" name="status" id="status" type="hidden">
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
            $(document).on('click', '.btn_request_action', function (e) {
                e.preventDefault();
                var req_id = $(this).data("id");
                var status = $(this).data('status');
                $('.remarks_error ul').html('');
                if (req_id != null) {
                    $('#req_id').val(req_id);
                    $('#status').val(status);
                    $('#remark_modal').modal('show');
                }
            });
            $(document).on('submit', '#remark_form', function (e) {
                e.preventDefault();
                var data = $(this).serialize();
                $.ajax({
                    url: '{{route("request.approve")}}',
                    method: 'post',
                    dataType: 'json',
                    data: data,
                    success: function (data) {
                        if (data.errors.length <= 0) {
                            $(".reload_sec").load("{{route('request.index')}} .reload_sec");
                            $('#remark_modal').modal('hide');
                            Swal.fire({
                                position: 'center',
                                type: 'success',
                                title: 'Success...',
                                text: 'Your action has been performed successfully.'
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