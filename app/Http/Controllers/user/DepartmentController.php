<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $department = Department::all();

        return $department;
    }

    public function show($id)
    {
        $department = Department::with('parkingSlots')->find($id);

        return $department;
    }
}
