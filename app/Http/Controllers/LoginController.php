<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Models\AdminLogs;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Dotenv\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function userDashboard()
    {
        return Auth::user();
    }

    public function adminDashboard()
    {
        $users = Admin::all();
        $success =  $users;

        return response()->json($success, 200);
    }

    public function userLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

    
        if(auth()->guard('user')->attempt(['email' => request('email'), 'password' => request('password')])){

            config(['auth.guards.api.provider' => 'user']);
            
            $user = User::select('users.*')->find(auth()->guard('user')->user()->id);
            $success =  $user;
            $success['token'] =  $user->createToken('MyApp',['user'])->accessToken; 

            return response()->json($success, 200);
        }else{ 
            return response()->json(['error' => ['Email and Password are Wrong.']], 200);
        }
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $dt = Carbon::now();
        $todayDate = $dt->toDayDateTimeString();


        if(auth()->guard('admin')->attempt(['email' => request('email'), 'password' => request('password')])){

            config(['auth.guards.api.provider' => 'admin']);
            
            $admin = Admin::select('admins.*')->find(auth()->guard('admin')->user()->id);
            $success =  $admin;
            $success['token'] =  $admin->createToken('MyApp',['admin'])->accessToken; 

            AdminLogs::create([
                'name' => $admin->name,
                'email' => $admin->email,
                'description' => 'Log In',
                'date_time' => $todayDate,
            ]);

            return response()->json($success, 200);
        }else{ 
            return response()->json(['error' => ['Email and Password are Wrong.']], 200);
        }
    }

    public function logout(Request $request)
    {
        $dt = Carbon::now();
        $todayDate = $dt->toDayDateTimeString();

        
        $admin = Admin::select('admins.*')->find(auth()->guard('admin')->user()->id);

        AdminLogs::create([
            'name' => $admin->name,
            'email' => $admin->email,
            'description' => 'Log Out',
            'date_time' => $todayDate,
        ]);

        auth()->guard('admin')->logout();

        $request->user()->token()->revoke();

        return "sucess";
    }

    public function logoutUser(Request $request)
    {

        auth()->guard('user')->logout();

        $request->user()->token()->revoke();


        return "sucess";
    }
}