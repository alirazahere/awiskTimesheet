<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class UserDatatableController extends Controller
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

    protected function UserDatatable()
    {
        if (request()->ajax()) {
            $users = User::all()->where('id', '!=', Auth::user()->id);
           return DataTables::of($users)
               ->addColumn('role', function($data){
                   return $data->UserRole->Role->role;
               })
               ->addColumn('action', function($data){
                   $button = '<div class="btn-group" role="group">';
                   $button .= '<button  type="button" name="delete" class="btn btn-primary btn-sm">Edit</button>';
                   $button .= '<button id="btn_delete" type="button" name="delete" data-id="'.$data->id.'" class="btn btn-danger btn-sm">Delete</button></div>';
                   return $button;
               })
               ->make(true);
        }else{
            return redirect()->route('login');
        }
    }
}
