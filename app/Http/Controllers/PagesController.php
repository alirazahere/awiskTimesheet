<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    protected function home(){
          return view('pages.home');
    }
}
