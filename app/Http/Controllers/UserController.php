<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use App\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        $users = User::all();
        $linemanager = [];
        foreach ($users as $user) {
            if ($user->Role()->first()->role == 'LineManager') {
                $linemanager[] = $user;
            }
        }
        return view('users.index')->withRoles($roles)->withLinemanagers($linemanager);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|integer',
            'linemanager'=>'required|integer',
            ]);
        $linemanager = $request->input('linemanager');
        if ($linemanager  == 0){
            $linemanager = null;
        }
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->line_manager = $linemanager;
        $role = $request->input('role');
        if ($user->save()) {
            $user_role = new UserRole();
            $user_role->role_id = $role;
            $user_role->user_id = $user->id;
            $user_role->save();
            Session::flash('success', 'User has been created successfully .');
        } else {
            Session::flash('error', 'Some error occurred while creating a user.');
        }

        return redirect()->route('user.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        $users = User::all();
        $linemanager = [];
        foreach ($users as $user) {
            if ($user->Role()->first()->role == 'LineManager') {
                $linemanager[] = $user;
            }
        }
        return view('users.edit')->withUser($user)->withRoles($roles)->withLinemanagers($linemanager);
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
        if (isset($id)) {
            $this->validate($request, [
                'name' => 'required|max:255',
                'role' => 'required|integer',
                'linemanager'=>'required|integer',
            ]);
            $linemanager = $request->input('linemanager');
            if ($linemanager  == 0){
                $linemanager = null;
            }
            $user = User::find($id);
            $user_role = $user->Role()->first()->UserRole()->first();
            $user_role->role_id = $request->input('role');
            $user_role->user_id = $id;
            $user->name = $request->input('name');
            $user->line_manager = $linemanager;
            $user_role->save();
            $user->save();
            Session::flash('success', 'User has been edited.');
        }
        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (request()->ajax()) {
            if (User::destroy($id)) {
                return json_encode('success');
            } else {
                return json_encode('error');
            }

        }
    }
}
