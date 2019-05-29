<?php

namespace App\Http\Controllers;

use App\Attendance;
use App\User;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DatatableController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function UserAttendanceDatatable($id)
    {
        if (request()->ajax()) {
            $atds = Attendance::whereUser_id($id);
            return DataTables::of($atds)
                ->addColumn('time_in', function ($data) {
                    return date('h:i a', strtotime($data->timein));
                })
                ->addColumn('time_out', function ($data) {
                    if ($data->timeout == NULL) {
                        return "Not Marked";
                    } else {
                        return date('h:i a', strtotime($data->timeout));
                    }

                })
                ->addColumn('timein_date', function ($data) {
                    return date('Y-m-d', strtotime($data->timein));
                })
                ->addColumn('timeout_date', function ($data) {
                    if ($data->timeout == NULL) {
                        return "Not Marked";
                    } else {
                        return date('Y-m-d', strtotime($data->timeout));
                    }

                })
                ->addColumn('action', function ($data) {
                    $button = '<div class="btn-group" role="group">';
                    $button .= '<button type="button" data-id="' . $data->id . '"  id="btn_edit" class="btn btn-primary btn-sm">Edit</a>';
                    $button .= '<button id="btn_delete" type="button"  data-id="' . $data->id . '" class="btn btn-danger btn-sm">Delete</button></div>';
                    return $button;
                })
                ->make(true);
        } else {
            return redirect()->route('login');
        }
    }

    protected function UserDatatable()
    {
        if (request()->ajax()) {
            $users = User::all()->where('id', '!=', Auth::user()->id);
            return DataTables::of($users)
                ->addColumn('role', function ($data) {
                    return $data->UserRole->Role->role;
                })
                ->addColumn('action', function ($data) {
                    $button = '<div class="btn-group" role="group">';
                    $button .= '<a href="' . route('user.edit', $data->id) . '" name="delete" class="btn btn-primary btn-sm">Edit</a>';
                    $button .= '<button id="btn_delete" type="button" name="delete" data-id="' . $data->id . '" class="btn btn-danger btn-sm">Delete</button></div>';
                    return $button;
                })
                ->make(true);
        } else {
            return redirect()->route('login');
        }
    }

    protected function AttendanceDatatable()
    {
        if (request()->ajax()) {
            $atds = Attendance::whereUser_id(Auth::user()->id);
            return DataTables::of($atds)
                ->addColumn('time_in', function ($data) {
                    return date('h:i a', strtotime($data->timein));
                })
                ->addColumn('time_out', function ($data) {
                    if ($data->timeout == NULL) {
                        return "Not Marked";
                    } else {
                        return date('h:i a', strtotime($data->timeout));
                    }
                })
                ->addColumn('timein_date', function ($data) {
                    return date('Y-m-d', strtotime($data->timein));
                })
                ->addColumn('timeout_date', function ($data) {
                    if ($data->timeout == NULL) {
                        return "Not Marked";
                    } else {
                        return date('Y-m-d', strtotime($data->timeout));
                    }
                })
                ->addColumn('action', function ($data) {
                    $req = '
                <button href="#" id="request_btn" data-id="' . $data->id . '" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#request_modal">
                    Request Change
                </button>';
                    return $req;
                })
                ->make(true);
        } else {
            return redirect()->route('login');
        }
    }

}
