<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminLogs;
use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $department = Department::withCount('parkingSlots')->get();

        return $department;
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'abbreviation'=>'required',
            'color'=>'required'
        ]);

        $department = Department::create([
            'name'=> $request->name,
            'abbreviation' => $request->abbreviation,
            'color'=> $request->color,
            

        ]);

        $dt = Carbon::now();
        $todayDate = $dt->toDayDateTimeString();

        $admin = Admin::select('admins.*')->find(auth()->guard('admin')->user()->id);

        AdminLogs::create([
            'name' => $admin->name,
            'email' => $admin->email,
            'description' => 'Created Department '. $request->name,
            'date_time' => $todayDate,
        ]);

        return $department;
    }

    
    public function show($id)
    {
        $department = Department::with('parkingSlots')->withCount('parkingSlots')->find($id);

        return $department;
    }

  
   
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'abbreviation'=>'required',
            'color'=>'required'
        ]);

        $department = Department::where('id', $id)
            ->update([
                'name'=> $request->name,
                'abbreviation' => $request->abbreviation,
                'color'=>$request->color
            ]);
        
        $dt = Carbon::now();
        $todayDate = $dt->toDayDateTimeString();

        $admin = Admin::select('admins.*')->find(auth()->guard('admin')->user()->id);

        AdminLogs::create([
            'name' => $admin->name,
            'email' => $admin->email,
            'description' => 'Updated Department '. $request->name,
            'date_time' => $todayDate,
        ]);

        return $department;
    }

    
    public function destroy(Department $department)
    {
        $dt = Carbon::now();
        $todayDate = $dt->toDayDateTimeString();

        $admin = Admin::select('admins.*')->find(auth()->guard('admin')->user()->id);

        AdminLogs::create([
            'name' => $admin->name,
            'email' => $admin->email,
            'description' => 'Deleted Department '. $department->name,
            'date_time' => $todayDate,
        ]);
        $department->delete();

        return $department;
    }
}
