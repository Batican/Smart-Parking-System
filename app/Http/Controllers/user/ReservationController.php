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

        $startTime = Carbon::createFromTime($request->start_time,00,);
        $endTime  = Carbon::createFromTime($request->end_time,00,);
     
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        $exists = Reservation::where('slot_id',$request->slot_id)->whereDate('date',Carbon::parse($startDate))->exists();
        
        $reservationCount = Reservation::where('user_id', $request->user_id)->where('status', Reservation::ACTIVE)->get();

        if(count($reservationCount) == 3){
            $messages[] = "You have reached the maximum reservation count";
        }else{
            if($startDate->eq($endDate) && !$exists){
                $reservation = Reservation::create([
                    'slot_id'=> $request->slot_id,
                    'user_id'=>$request->user_id,
                    'date'=>$startDate,
                    'start_time'=>$startTime,
                    'end_time'=>$endTime,
                    'status'=> Reservation::ACTIVE,
                ]);
    
                $parkingSlot = ParkingSlot::where('id', $reservation->slot_id)->first();
    
                if($startDate->eq(Carbon::now() && $parkingSlot->status == ParkingSlot::AVAILABLE)){
                    $parkingSlot->update([
                        'status' => ParkingSlot::RESERVED
                    ]);
                }
            }
            else{
                $messages[] = "Parking slot is already reserved on this ".$startDate;
            }
            
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
                        'status'=> Reservation::ACTIVE,
                    ]);
    
                }
            }

            $reservations = Reservation::whereDate('date',Carbon::now())->get();

            foreach($reservations as $reservation){
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
      
        $reservation = Reservation::where('id', $request->id)->whereDate('date',Carbon::now())->exists();
        
        if($reservation){
            $reserved = Reservation::where('id', $request->id)->first();
            $user = ParkingSlot::where('user_id', $reserved->user_id)->exists();

            if($user){
                ParkingSlot::where('user_id',$reserved->user_id)
                ->update([
                    'status' => ParkingSlot::AVAILABLE,
                    'user_id' => null
                ]);
                ParkingSlot::where('id', $reserved->slot_id)->update([
                    'status' => ParkingSlot::OCCUPIED,
                    'user_id' => $reserved->user_id,
                ]);
    
                $reserved->update([
                    'status' => Reservation::ARCHIVE,
                ]);
                
                return [
                    "Success"=>"Parking Slot Occupied!"
                ];

            }
        }
        else{
            return [
                "Error"=>"Failed!"
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
            'status' => 'required',
        ]);

        $startTime= Carbon::parse($request->start_time)->toTimeString();
        $endTime = Carbon::parse($request->end_time)->toTimeString();

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
                'status'=>$request->status,
            ]);

        return $reservation;

    }

    public function destroy(Reservation $reservation)
    {

        $reservation->update([
            'status'=> Reservation::ARCHIVE,

        ]);

        $count = ParkingSlot::where('user_id',$reservation->user_id)->withCount([
            'reservations' => function($query){
                $query->where('status',Reservation::ACTIVE)->where('reservations_count','=', 0);
            }])->exists();
            
        if($count){
            ParkingSlot::where('user_id', $reservation->user_id)
            ->update([
                'status'=> ParkingSlot::AVAILABLE,
                'user_id' => null
            ]);
        }
        

        return $reservation;
    }
}
