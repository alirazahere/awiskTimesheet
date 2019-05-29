<?php

namespace App\Http\Controllers;
use App\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EditAttendanceAjax extends Controller
{
    protected function fetch_Attendance(Request $request){
        if(request()->ajax()){
            $id = $request->get('id');
            $atd = Attendance::find($id);
            $atd_timein =  Carbon::parse($atd->timein);
            $atd_timeout =  Carbon::parse($atd->timeout);
            $timein = $atd_timein->format('H:i');
            $timeout = $atd_timeout->format('H:i');
            $timein_date = $atd_timein->format('Y-m-d');
            $timeout_date = $atd_timeout->format('Y-m-d');
            $output = [
                '#atd_id'=>$id,
                '#timein'=>$timein ,
                '#timein_date'=>$timein_date,
                '#timeout'=>$timeout,
                '#timeout_date'=>$timeout_date
            ];
            return json_encode($output);
        }
        else{
            return redirect()->route('page.dashboard');
        }
    }

    protected function Update_Attendance(Request $request){
        if(request()->ajax() && request()->method('post')){

            $validation = Validator::make($request->all(), [
                'id' => 'required|integer',
                'timein'  => 'required|date_format:H:i',
                'timein_date'  => 'required|date',
                'timeout'  => 'required|date_format:H:i',
                'timeout_date' => 'required|date',
            ]);
            $error_array = array();
            if ($validation->fails())
            {
                foreach ($validation->messages()->getMessages() as $field_name => $messages)
                {
                    $error_array[] = array('name'=>".".$field_name."_error",'message'=>$messages);
                }
                $output = ['errors'=>$error_array];
                return json_encode($output);
            }
            else {
                $id = $request->get('id');
                $timein = $request->get('timein');
                $timeout = $request->get('timeout');
                $timein_date = $request->get('timein_date');
                $timeout_date = $request->get('timeout_date');

                $atd_timein = $timein_date . " " . $timein;
                $atd_timeout = $timeout_date . " " . $timeout;

                $atd = Attendance::find($id);
                $atd->timein = $atd_timein;
                $atd->timeout = $atd_timeout;
                $atd->save();
            }
            $output = array('errors'=>$error_array);
            echo json_encode($output);
        }
        else{
            return redirect()->route('page.dashboard');
        }
    }

    protected function Delete_Attendance(Request $request){
        if(request()->ajax() && request()->method('post')){
            $validate = Validator::make($request->all(),[
                'id'=> 'required|integer'
            ]);
            if (!$validate->fails()){
                $id = $request->get('id');
                Attendance::destroy($id);
                return json_encode('success');
            }
            else{
                json_encode('error');
            }
        }
        else{
            return redirect()->route('page.dashboard');
        }
    }
}
