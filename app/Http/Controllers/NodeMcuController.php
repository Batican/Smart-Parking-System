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
        // $slot = ParkingSlot::where('user_id', $user->id)->first();
        $dt = Carbon::now();
        $todayDate = $dt->toDateString();


        if($user){
            $user = User::where('rfid_number', $request->rfid_number)->first();
            $slot = ParkingSlot::where('user_id', $user->id)->first();
            if($slot){
                ParkingSlot::where('user_id', $user->id)
                ->update([
                'user_id' => null,
                'status' => ParkingSlot::AVAILABLE,
                ]);
                Log::create([
                    'name_of_user'=>$user->name,
                    'number_of_slot'=>$slot->parking_number,
                    'description'=>'Exited',
                    'date_time'=>$todayDate,
                ]);
            }
            else{
                Log::create([
                    'name_of_user'=>$user->name,
                    'number_of_slot'=>$slot->parking_number,
                    'description'=>'Entered',
                    'date_time'=>$todayDate,
                ]);
            }
            // 

            // Reservation::whereDate('date',Carbon::now())->where('user_id', $user->id)->delete();

            return [
                "authorized"=>"Autorized User"
            ];
        }

        

       
    }

}
