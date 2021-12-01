<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\ParkingSlot;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;

class ParkingSlotController extends Controller
{
    public function index()
    {
        $slot = ParkingSlot::all();

        return $slot;
    }
}
