<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Requests;

class RequestsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::whereLine_manager(Auth::user()->id)->get();
        $requests = array();
        $pending_requests = array();
        foreach ($users as $user) {
            foreach ($user->UserRequest()->whereStatus(true)->get() as $request) {
                $requests[] = $request;
            }
            foreach ($user->UserRequest()->whereStatus(false)->get() as $pending_request) {
                $pending_requests[] = $pending_request;
            }
        }
        return view('requests.index')->withRequests($requests)->withPendingRequests($pending_requests);
    }

    public function approve(Request $data){
        if (request()->ajax() && request()->method('post') ){
            $validate = Validator::make($data->all() ,[
                'id' => 'required|integer',
                'remark' => 'string|max:255|nullable'
            ]);
            $errors = array();
            if($validate->fails()){
                $errors = $validate->errors()->all();
                $output = ['errors' => $errors];
                return json_encode($output);
            }
            else {
                $req_id = $data->input('id');
                $request = Requests::find($req_id);
                $atd_id = $request->attendance_id;
                $attendance = Attendance::find($atd_id);
                $attendance->timein = $request->timein;
                $attendance->timeout = $request->timeout;
                $request->status = false;
                $request->remark = $data->input('remark');
                $request->save();
                $attendance->save();
                $output = ['errors' => $errors];
                return json_encode($output);
            }
        }
        else{
            return redirect()->route('request.index');
        }
    }

    public function store(Request $data)
    {
        if (request()->ajax() && request()->method('post')) {
            $validate = Validator::make($data->all(), [
                'timein' => 'required|date_format:H:i',
                'timein_date' => 'required|date',
                'timeout' => 'required|date_format:H:i',
                'timeout_date' => 'required|date',
                'message' => 'required|max:255',
                'atd_id' => 'required|integer',
            ]);
            $error_array = array();
            $success = '';
            if ($validate->fails()) {
                foreach ($validate->messages()->getMessages() as $field_name => $messages) {
                    $error_array[] = array('name' => "." . $field_name . "_error", 'message' => $messages);
                }
                $output = ['errors' => $error_array, 'success', $success];
                return json_encode($output);
            } else {

                $timeIn = $data->input('timein_date') . " " . $data->input('timein');
                $timeOut = $data->input('timeout_date') . " " . $data->input('timeout');

                Auth::user()->UserRequest()->create([
                    'timein' => $timeIn,
                    'timeout' => $timeOut,
                    'message' => $data->input('message'),
                    'attendance_id' => $data->input('atd_id'),
                    'author' => Auth::user()->id,
                    'status' => TRUE,
                ]);
                $output = ['errors' => $error_array, 'success', $success];
                return json_encode($output);
            }
        }
    }
}
