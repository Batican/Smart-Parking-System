<?php

namespace App\Http\Controllers\admin;

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
            'type'=>'required',
            'email'=>'required|email',
            'password'=>'required',
            'rfid_number'=>'required'
        ]);

        $user = User::create([
            'name'=> $request->name,
            'type'=> $request->type,
            'email'=> $request->email,
            'password'=> bcrypt($request->password),
            'rfid_number'=> (int)$request->rfid_number

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
            'type'=>'required',
            'email'=>'required|email',
            'rfid_number'=>'required'
        ]);

        $userUpdate = [
            'name'=> $request->name,
            'type'=> $request->type,
            'email'=> $request->email,
            'rfid_number'=> (int)$request->rfid_number
        ];

        if($request->password){
            $userUpdate["password"] = bcrypt($request->password);
            return $userUpdate;
        }

        $user = User::where('id', $id)
            ->update($userUpdate);

        return $user;
    }

    
    public function destroy(User $user)
    {
        $user->delete();

        return $user;
    }
}
