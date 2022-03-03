<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{

    public function index(){
        $logs = Log::all();

        return $logs;

    }
    
}
