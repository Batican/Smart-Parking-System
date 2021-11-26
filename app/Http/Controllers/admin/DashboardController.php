<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use App\Models\ParkingSlot;

class DashboardController extends Controller
{
    public function getData(){

        return [
            'users' => User::all()->count(),
            'departments' => Department::all()->count(),
            'parking_slots' => ParkingSlot::all()->count(),
        ];
    }
}