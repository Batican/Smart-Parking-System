<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return $users;
    }

    
    public function show($id)
    {
        $user = User::with(['reservations'=>function($reservation){
            return $reservation->where('status',Reservation::ACTIVE)->with('parkingSlot.department');
        }])->find($id);

        return $user;
    }

  
   
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'type'=>'required',
            'email'=>'required|email',
           
        ]);
        
        $user = User::find($id);

        $userUpdate = [
            'name'=> $request->name,
            'type'=> $request->type,
            'email'=> $request->email,
           
        ];

        if(str_contains($request->image,'base64')){
            if($user->image){
                Storage::delete('app/public/updloads/'.$user->image);
            }

            $userUpdate['image'] =  $this->uploadImage($request->image);
        }

        if($request->password){
            $userUpdate["password"] = bcrypt($request->password);
        }

        $user->update($userUpdate);

        return $user;
    }
}
