<?php

namespace App\Http\Controllers;

use App\Models\ParkingSlot;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NodeMcuController extends Controller
{
    public function checkRfid(Request $request){
        
        $user = User::where('rfid_number', $request->rfid_number)->exists();
        if($user){
            $user = User::where('rfid_number', $request->rfid_number)->first();
            ParkingSlot::where('user_id', $user->id)
            ->update([
                'user_id' => null,
                'status' => ParkingSlot::AVAILABLE,
            ]);

            Reservation::whereDate('date',Carbon::now())->where('user_id', $user->id)->delete();

            return [
                "authorized"=>"Autorized User"
            ];
        }
    }

}
