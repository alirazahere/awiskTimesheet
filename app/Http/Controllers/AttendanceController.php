<?php

namespace App\Http\Controllers;

use App\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AttendanceController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (request()->ajax()) {
            $date = Carbon::now();
            $today = $date->format('Y-m-d');
            $yestarday = Carbon::yesterday()->format('Y-m-d');
            $previous_atd = Auth::user()->Attendance()->whereDate('timein', $yestarday)->where('timeout', NULL)->first();
            $today_atd = Auth::user()->Attendance()->whereDate('timein', $today)->first();
            if (!empty($previous_atd)) {
                $prev_check = Carbon::parse($previous_atd->timein)->addHours(12);
                if ($date->gte($prev_check) && empty($today_atd)) {
                    $output = ['output' => 'warning', 'message' => 'You did not marked your previous attendance.
                     Please make a request to your supervisor.', 'submit_text' => 'Mark Your Time In.', 'submit' => 'timein', 'date' => $today];
                    return json_encode($output);
                } else if ($previous_atd->timein != NULL && $previous_atd->timeout == NULL) {
                    $output = ['output' => 'success', 'submit_text' => 'Mark Your Time Out.', 'submit' => 'timeout', 'date' => $yestarday];
                    return json_encode($output);
                }
            } else {
                if (!empty($today_atd)) {
                    if ($today_atd->timeout != NULL && $today_atd->timein != NULL) {
                        $output = ['output' => 'default'];
                        return json_encode($output);
                    } else if ($today_atd->timein != NULL && $today_atd->timeout == NULL) {
                        $output = ['output' => 'success', 'submit_text' => 'Mark Your TimeOut', 'submit' => 'timeout', 'date' => $today];
                        return json_encode($output);
                    } else {
                        return json_encode($output = ['output' => 'success', 'submit_text' => 'Mark Your Time In', 'submit' => 'timein', 'date' => $today]);
                    }
                } else {
                    return json_encode($output = ['output' => 'success', 'submit_text' => 'Mark Your Time In', 'submit' => 'timein', 'date' => $today]);
                }
            }
        } else {
            return redirect()->route('page.dashboard');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (request()->ajax() && request()->method('post')) {
            $submit = $request->get('submit');
            if (!empty($submit) && $submit != 'error') {
                $date = Carbon::now();
                $time = $date->format('h:i a');
                if ($submit == 'timein') {
                    Auth::user()->Attendance()->create([
                        'timein' => $date,
                        'timeout' => NULL,
                        'status' => TRUE
                    ]);
                    $output = ['output' => 'success', 'message' => $time, 'status' => 'Timed in'];
                    return json_encode($output);
                } else if ($submit == 'timeout') {
                    $atd = Auth::user()->Attendance()->latest('timein')->first();
                    $atd->timeout = $date;
                    $atd->save();
                    $output = ['output' => 'success', 'message' => $time, 'status' => 'Timed out'];
                    return json_encode($output);
                } else {
                    $output = ['output' => 'error'];
                    return json_encode($output);
                }
            } else {
                $output = ['output' => 'error'];
                return json_encode($output);
            }
        } else {
            return redirect()->route('page.dashboard');
        }
    }

    public function previous()
    {
        return view('pages.previous_attendance');
    }

    public function store_previous(Request $request)
    {
        if (request()->ajax() && request()->method('post')) {
            $validate = Validator::make($request->all(), [
                'timein' => 'required|date_format:H:i',
                'timeout' => 'required|date_format:H:i',
                'timein_date' => 'required|date',
                'timeout_date' => 'required|date',
            ]);
            $errors = array();
            if (!$validate->fails()) {
                $timeIn = $request->input('timein_date') . " " . $request->input('timein');
                $timeOut = $request->input('timeout_date') . " " . $request->input('timeout');
                Attendance::create([
                    'timein' => $timeIn,
                    'timeout' => $timeOut,
                    'status' => True,
                    'user_id' => Auth::user()->id,
                ]);
                return json_encode('success');
            } else {
                foreach ($validate->messages()->getMessages() as $field_name => $messages) {
                    $errors[] = array('name' => "." . $field_name . "_error", 'message' => $messages);
                }
                return json_encode($errors);
            }
        } else {
            return redirect()->route('attendance.previous');
        }
    }
}
