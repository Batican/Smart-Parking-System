<?php

namespace App\Console\Commands;

use App\Models\ParkingSlot;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DailyUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A simple command to update todays status in parking slot';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $todayDate = Carbon::today();

            foreach(ParkingSlot::all() as $parkingSlot){
                
                $isReserved = $parkingSlot->reservations()->whereDate('date', $todayDate)->where('status', Reservation::ACTIVE)->exists();

                if($parkingSlot->status == ParkingSlot::AVAILABLE && $isReserved){
                    $parkingSlot->update([
                        'status'=> ParkingSlot::RESERVED 
                    ]);
                }
            }
        
        // $reservations = Reservation::whereDate('date',$todayDate)->get();

        // foreach($reservations as $reservation){
        //     ParkingSlot::where('id',$reservation->slot_id)
        //     ->update([
        //         'status' => ParkingSlot::RESERVED,

        //     ]);

        // }

        Log::info('Parking slot status updated successfully');
    }
}
