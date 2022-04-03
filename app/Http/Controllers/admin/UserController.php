<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminLogs;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    
    public function index()
    {
        $users = User::all();

        return $users;
    }

    public function uploadImage($image)
    {
        $exploded_base64 = explode(',', $image);
        $decoded_base64  = base64_decode($exploded_base64[1]);
        $extention = $this->string_between_two_string($exploded_base64[0], '/', ';');
        
        $fileName = 'cus_'.time().'.'.$extention;
        $path = storage_path('app/public/').$fileName;
    
        file_put_contents($path,$decoded_base64);   
        
        return $fileName;
    }

    public function string_between_two_string($str, $starting_word, $ending_word)
    {
        $arr = explode($starting_word, $str);
        if (isset($arr[1])){
            $arr = explode($ending_word, $arr[1]);
            return $arr[0];
        }
        return '';
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

        $image_req = str_contains($request->image,'base64');

        if($image_req){
            $fileName = $this->uploadImage($request->image);
        }

        $user = User::create([
            'name'=> $request->name,
            'type'=> $request->type,
            'email'=> $request->email,
            'password'=> bcrypt($request->password),
            'rfid_number'=> (int)$request->rfid_number,
            'image' => $image_req ? $fileName : null ,


        ]);

        $dt = Carbon::now();
        $todayDate = $dt->toDayDateTimeString();

        $admin = Admin::select('admins.*')->find(auth()->guard('admin')->user()->id);

        AdminLogs::create([
            'name' => $admin->name,
            'email' => $admin->email,
            'description' => 'Created User '. $request->name,
            'date_time' => $todayDate,
        ]);

        return $user;
    }

    
    public function show($id)
    {
        $user = User::with('reservations')->find($id);

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
        
        $user = User::find($id);

        $userUpdate = [
            'name'=> $request->name,
            'type'=> $request->type,
            'email'=> $request->email,
            'rfid_number'=> (int)$request->rfid_number
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

        $dt = Carbon::now();
        $todayDate = $dt->toDayDateTimeString();

        $admin = Admin::select('admins.*')->find(auth()->guard('admin')->user()->id);

        AdminLogs::create([
            'name' => $admin->name,
            'email' => $admin->email,
            'description' => 'Update User '. $request->name,
            'date_time' => $todayDate,
        ]);

        return $user;
    }

    
    public function destroy(User $user)
    {
        if($user->image){
            Storage::delete('app/public/updloads/'.$user->image);
        }
        $dt = Carbon::now();
        $todayDate = $dt->toDayDateTimeString();

        $admin = Admin::select('admins.*')->find(auth()->guard('admin')->user()->id);

        AdminLogs::create([
            'name' => $admin->name,
            'email' => $admin->email,
            'description' => 'Deleted User '. $user->name,
            'date_time' => $todayDate,
        ]);
        $user->delete();

        return $user;
    }
}
