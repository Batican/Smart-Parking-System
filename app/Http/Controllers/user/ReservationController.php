<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
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
            'date' => 'required'
            
        ]);

        $reservation= Reservation::where('id', $id)
            ->update([
                'slot_id'=> $request->slot_id,
                'user_id'=>$request->user_id,
                'date'=>$request->date

            ]);

        return $reservation;

    }

    public function destroy(Reservation $reservation)
    {

        $reservation->delete();

        return $reservation;
    }
}
