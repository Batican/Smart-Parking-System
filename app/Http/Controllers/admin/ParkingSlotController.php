<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\ParkingSlot;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;

class ParkingSlotController extends Controller
{
    public function index()
    {
        $slot = ParkingSlot::with('department')->get();

        return $slot;
    }

    public function store(Request $request)
    {
        $request->validate([
            'parking_number'=>'required',
            'department_id' =>'required',
            
            
        ]);

        $slot = ParkingSlot::create([
            'parking_number'=> $request->parking_number,
            'department_id'=>$request->department_id,
            'status'=>ParkingSlot::AVAILABLE,
        ]);

        return $slot;
    }

    public function generate ($id)
    {
        $slot = ParkingSlot::findOrFail($id);
        $qrcode = QrCode::size(400)
                    ->generate($slot->department_id.'_'.$slot->parking_number);
        return $qrcode;
    }

    public function qrImage($id)
    {   
        $slot = ParkingSlot::findOrFail($id);
        $qrcode = QrCode::size(400)
                    ->generate($slot->department_id.'_'.$slot->parking_number, public_path('images/qrImage_'.$slot->parking_number.'.svg'));
        
        
        $img_url = '/images/qrImage_'.$slot->parking_number.'.svg';
        $img_value = $slot->department_id.'_'.$slot->parking_number;
    
        $slot = ParkingSlot::where('id', $id)
        ->update([
            'qrCode_path'=> $img_url,
            'qrCode_value'=> $img_value,
        ]);

        return $qrcode;
    }

    public function show($id)
    {
        $slot = ParkingSlot::with('department')->find($id);

        return $slot;
    }

    public function update(Request $request, $id)
    {

        $request->validate([

            'parking_number'=>'required',
            'department_id' =>'required',
            'status' =>'required',
            
        ]);

        $slot = ParkingSlot::where('id', $id)
            ->update([
                'parking_number'=> $request->parking_number,
                'department_id'=>$request->department_id,
                'status'=>$request->status,

            ]);

        return $slot;

    }

    public function destroy(ParkingSlot $slot)
    {

        $slot->delete();

        return $slot;
    }
}
