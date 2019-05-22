<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $data){
         $this->validate($data,[
             'subject'=> 'required|max:255',
             'message'=>'required|max:255',
         ]);
         $request = new Request();
         $request->subject = $data->input('subject');
         $request->message = $data->input('message');
         $request->author = Auth::user()->id;
         $request->status = True;

    }
}
