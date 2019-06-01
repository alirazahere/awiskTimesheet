<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function index()
    {
        $users = User::whereLine_manager(Auth::user()->id)->get();
        return view('pages.dashboard')->withUsers($users);
    }
}
