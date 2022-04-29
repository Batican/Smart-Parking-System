<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class MyController extends Controller
{
    public function import() 
    {
        Excel::import(new UsersImport,request()->file('file'));
             
        return back();
    }
}
