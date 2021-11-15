<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
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
            'color'=>'required'
        ]);

        $department = Department::create([
            'name'=> $request->name,
            'color'=> $request->color

        ]);

        return $department;
    }

    
    public function show($id)
    {
        $department = Department::find($id);

        return $department;
    }

  
   
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'color'=>'required'
        ]);

        $department = Department::where('id', $id)
            ->update([
                'name'=> $request->name,
                'color'=>$request->color
            ]);

        return $department;
    }

    
    public function destroy(Department $department)
    {
        $department->delete();

        return $department;
    }
}
