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

    
    public function show($id)
    {
        $user = User::find($id);

        return $user;
    }

  
   
    public function update(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'type'=>'required',
            'email'=>'required|email',
        ]);

        $userUpdate = [
            'name'=> $request->name,
            'type'=> $request->type,
            'email'=> $request->email,
        ];

        if($request->password){
            $userUpdate["password"] = bcrypt($request->password);
            return $userUpdate;
        }

        $user = $request->user()
            ->update($userUpdate);

        return $user;
    }
}
