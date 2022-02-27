<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservation = Reservation::with('parkingSlot', 'user')->get();

        return $reservation;
    }

    public function store(Request $request)
    {
        $request->validate([
            'slot_id'=>'required',
            'user_id' =>'required',
            'date' => 'required',
            
            
        ]);

        $exists = Reservation::where('slot_id',$request->slot_id)->whereDate('date',Carbon::parse($request->date))->exists();
        if($exists){
            return [
                "error"=>"Parking Slot is already reserve on this date"
            ];
        }

        $reservation = Reservation::create([
            'slot_id'=> $request->slot_id,
            'user_id'=>$request->user_id,
            'date'=>$request->date,
            
        ]);

        return $reservation;
    }

    public function show($id)
    {
        $reservation = Reservation::with('parkingSlot', 'user')->find($id);

        return $reservation;
    }

    public function update(Request $request, $id)
    {

        $request->validate([

            'slot_id'=>'required',
            'user_id' =>'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            
        ]);
        
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
                'start_date'=>$request->start_date,
                'end_date'=>$request->end_date,
                'start_time'=>$request->start_time,
                'end_time'=>$request->end_time,
            ]);

        return $reservation;

    }

    public function destroy(Reservation $reservation)
    {

        $reservation->delete();

        return $reservation;
    }
}
