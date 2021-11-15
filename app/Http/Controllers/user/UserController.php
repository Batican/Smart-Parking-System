<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    
    public function index()
    {
        $users = User::all();

        return $users;
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            'rfid_number'=>'required'
        ]);

        $user = User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> bcrypt($request->password),
            'rfid_number'=> $request->rfid_number

        ]);

        return $user;
    }

    
    public function show($id)
    {
        $user = User::find($id);

        return $user;
    }

  
   
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'rfid_number'=>'required'
        ]);

        $user = User::where('id', $id)
            ->update([
                'name'=> $request->name,
                'email'=> $request->email,
                'rfid_number'=> $request->rfid_number
            ]);

        return $user;
    }

    
    public function destroy(User $user)
    {
        $user->delete();

        return $user;
    }
}
