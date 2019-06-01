<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RequestsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
