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
            $previous_atd = Auth::user()->Attendance()->whereDate('timein', $yestarday)->where('timeout', NULL)->first();
            if ( !empty($previous_atd)) {
                $prev_check = Carbon::parse($previous_atd->timein)->addHours(12);
                if($date->lte($prev_check)){
                    $prev_check = Carbon::parse($previous_atd->timein)->addHours(12);
                    $output = ['output' => 'error','date' => $yestarday];
                    return json_encode($output);
                }

            } else {
                $atd = Auth::user()->Attendance()->whereDate('timein', $today)->first();
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
            $atd = Auth::user()->Attendance()->latest('timein')->first();
            if ( !isset($atd) && ($atd->timein == NULL && $atd->timeout == NULL)) {
                Auth::user()->Attendance()->create([
                    'timein' => $date,
                    'timeout' => NULL,
                    'status' => True
                ]);
                $output = ['output'=>'success','message'=>'Your TimeIn has been marked.'];
                return json_encode($output);

            } else {
                $atd->timeout = $date;
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
