<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\ParkingSlot;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;

class ParkingSlotController extends Controller
{
    public function index(Request $request)
    {
        $parkingslots = ParkingSlot::query();
        if($request->query('department_id') != 0)  {
            $parkingslots
            ->whereHas('department', function ($query) use($request){
                return $query->find($request->query('department_id'));
            });
        }

        return $parkingslots;
    }
}
