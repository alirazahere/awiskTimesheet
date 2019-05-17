<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $atd = Attendance::all()->where('user_id',Auth::user()->id)->where('status','active')->sortByDesc('created_at');
      return json_encode($atd);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $date = Carbon::now()->format('Y-m-d');
        $atd = Attendance::where('user_id', Auth::user()->id)->whereDate('created_at', $date)->first();
        if ($atd && !empty($atd->timein) && !empty($atd->timeout)) {
            $output = ['output' => 'default'];
            echo json_encode($output);
        } else if ($atd && !empty($atd->timein)) {
            $output = ['output' => 'true', 'value' => $atd->timein];
            echo json_encode($output);
        } else {
            $output = ['output' => 'false', 'value' => $atd->timeout];
            echo json_encode($output);
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
            $atd = new Attendance();
            $atd->timein = $request->get('timein');
            $atd->user_id = Auth::user()->id;
            $atd->status = 'active';
            $atd->save();
        } else {
            $this->validate($request, [
                'timeout' => 'required'
            ]);
            $date = Carbon::now()->format('Y-m-d');
            $atd = Attendance::whereDate('created_at', $date)->where('user_id', Auth::user()->id)
                ->update(['timeout' => $request->get('timeout')]);
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
