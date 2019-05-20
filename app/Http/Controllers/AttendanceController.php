<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use phpDocumentor\Reflection\Types\Null_;

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
        $date = Carbon::now();
        $today = $date->format('Y-m-d');
        $yestarday = $date->subDays(1)->format('Y-m-d');
        $previous_atd = Auth::user()->Attendance()->whereDate('created_at', $yestarday)->first();
        if ( !empty($previous_atd) && $previous_atd->timein != Null && $previous_atd->timeout == Null ) {
            $output = [ 'output' => 'error','message' => 'Please Marked Your Previous Attendance.'
                ,'date'=>$yestarday,'value' => $previous_atd->timein ];
            return json_encode($output);
        } else {
            $atd = Auth::user()->Attendance()->whereDate('created_at', $today)->first();
            if (!empty($atd)) {
                if ($atd->timeout != NULL && $atd->timein != NULL) {
                    $output = ['output' => 'default'];
                    return json_encode($output);
                } else if ($atd->timein != NULL) {
                    $output = ['output' => 'true', 'value' => $atd->timein , 'date' => $atd->created_at->format('Y-m-d')];
                    return json_encode($output);
                }
            } else {
                return json_encode($output = [ 'output' => 'false' ,'date' => $today ]);
            }
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
        if (!isset($request->timeout)) {
            $this->validate($request, [
                'timein' => 'required'
            ]);
            Auth::user()->Attendance()->create([
                'timein' => $request->input('timein'),
                'timeout' => NULL,
                'status' => 'active'
            ]);

        } else {
            $this->validate($request, [
                'timein' => 'null',
                'timeout' => 'required'
            ]);
            $atd = Auth::user()->Attendance()->latest()->first();
            $atd->timeout = $request->input('timeout');
            $atd->save();
        }
        return redirect()->route('page.dashboard');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
