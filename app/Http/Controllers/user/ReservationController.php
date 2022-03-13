<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\ParkingSlot;
use App\Models\Reservation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{   
    public function store(Request $request)
    {
        $request->validate([
            'slot_id'=>'required',
            'user_id' =>'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            
        ]);
        $messages = [];
        $st = Carbon::parse($request->start_time);
        $startTime = $st->toTimeString();
        $et = Carbon::parse($request->end_time);
        $endTime = $et->toTimeString();
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            
            $exists = Reservation::where('slot_id',$request->slot_id)->whereDate('date',Carbon::parse($date))->exists();
            if($exists){
                $messages[] = "Parking slot is already reserved on this ".$date;
            }
            else{
                Reservation::create([
                    'slot_id'=> $request->slot_id,
                    'user_id'=>$request->user_id,
                    'date'=>$date,
                    'start_time'=>$startTime,
                    'end_time'=>$endTime,
                ]);

                $reservation = Reservation::whereDate('date',Carbon::now())->first();
                ParkingSlot::where('id',$reservation->slot_id)
                ->update([
                    'status' => ParkingSlot::RESERVED
                ]);


            }

        }

        
        return $messages;
    }

    public function show($id)
    {
        $reservation = Reservation::with('parkingSlot', 'user')->find($id);

        return $reservation;
    }

    public function done(Request $request)
    {
        $reservation = Reservation::where('parkingSlot->qrCode_value', $request->qrCode_value)->exists();
        if($reservation){
            $reserved = Reservation::where('id', $request->id)->first();
            $reserved->parkingSlot()->update([
                'status' => ParkingSlot::OCCUPIED,
                'user_id' => $reserved->user_id,
            ]);
            return [
                "Success"=>"Parking Slot Occupied!"
            ];
        }
        else{
            return [
                "Error"=>"QR Code Doesn't Matched!"
            ];
        }
        
    }

    public function update(Request $request, $id)
    {

        $request->validate([

            'slot_id'=>'required',
            'user_id' =>'required',
            'date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $st = Carbon::parse($request->start_time);
        $startTime = $st->toTimeString();
        $et = Carbon::parse($request->end_time);
        $endTime = $et->toTimeString();
        
        $exists = Reservation::where('slot_id',$request->slot_id)->whereDate('date',Carbon::parse($request->date))->exists();
        if($exists){
            return [
                "error"=>"Parking Slot is already reserve on this date"
            ];
        }

        $reservation= Reservation::where('id', $id)
            ->update([
                'slot_id'=> $request->slot_id,
                'user_id'=>$request->user_id,
                'date'=>$request->date,
                'start_time'=>$startTime,
                'end_time'=>$endTime,
            ]);

        return $reservation;

    }

    public function destroy(Reservation $reservation)
    {

        $reservation->delete();

        return $reservation;
    }
}
