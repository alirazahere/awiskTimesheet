<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

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
            $previous_atd = Auth::user()->Attendance()->whereDate('timein_date', $yestarday)->where('timeout', NULL)->first();
            if (!empty($previous_atd)) {
                $output = ['output' => 'error', 'date' => $yestarday];
                return json_encode($output);
            } else {
                $atd = Auth::user()->Attendance()->whereDate('timein_date', $today)->first();
                if (!empty($atd)) {
                    if ($atd->timeout != NULL && $atd->timein != NULL) {
                        $output = ['output' => 'default'];
                        return json_encode($output);
                    } else if ($atd->timein != NULL && $atd->timeout == NULL) {
                        $output = ['output' => 'true', 'date' => $today];
                        return json_encode($output);
                    } else {
                        return json_encode($output = ['output' => 'false', 'date' => $today]);
                    }
                } else {
                    return json_encode($output = ['output' => 'false', 'date' => $today]);
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
            $date = Carbon::now();
            $atd = Auth::user()->Attendance()->whereDate('created_at', $date->format('Y-m-d'))->first();
            if (!isset($atd) || ($atd->timein != NULL && $atd->timeout != NULL)) {
                Auth::user()->Attendance()->create([
                    'timein' => $date->format('H:i'),
                    'timein_date' => $date->format('Y-m-d'),
                    'timeout' => NULL,
                    'timeout_date' => NULL,
                    'status' => True
                ]);
                $output = ['output'=>'success','message'=>'Your TimeIn has been marked.'];
                return json_encode($output);

            } else {
                $atd = Auth::user()->Attendance()->latest()->first();
                $atd->timeout = $date->format('H:i');
                $atd->timeout_date = $date->format('Y-m-d');
                $atd->save();
                $output = ['output'=>'success','message'=>'Your attendance has been marked.'];
                return json_encode($output);
            }
            return redirect()->route('page.dashboard');
        } else {
            return redirect()->route('page.dashboard');
        }
    }
}
