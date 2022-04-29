<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\ParkingSlot;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NodeMcuController extends Controller
{
    public function checkRfid(Request $request){
        
        $user = User::where('rfid_number', $request->rfid_number)->exists();
      
        $dt = Carbon::now();
        $todayDate = $dt->toDayDateTimeString();


        if($user){
            $user = User::where('rfid_number', $request->rfid_number)->first();
            $slot = ParkingSlot::where('user_id', $user->id)->exists();
            if($slot){
                $user_slot = ParkingSlot::where('user_id', $user->id)->first();
                Log::create([
                    'name_of_user'=>$user->name,
                    'number_of_slot'=>$user_slot->parking_number,
                    'description'=>'Exited',
                    'date_time'=>$todayDate,
                ]);

                $user_slot->update([
                    'user_id' => null,
                    'status' => ParkingSlot::AVAILABLE,
                    ]);
            }
            else{
                Log::create([
                    'name_of_user'=>$user->name,
                    'number_of_slot'=>null,
                    'description'=>'Entered',
                    'date_time'=>$todayDate,
                ]);
            }
            return [
                "authorized"=>"Autorized User"
            ];
        }

        

       
    }

}
