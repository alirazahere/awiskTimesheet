<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function index()
    {
        $users = User::whereLine_manager(Auth::user()->id)->get();
        $requests = array();
        foreach ($users as $user) {
            foreach ($user->UserRequest()->get() as $request) {
                $requests[] = $request;
            }
        }
        return view('pages.dashboard')->withRequests($requests);
    }
}
