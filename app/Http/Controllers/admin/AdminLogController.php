<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\AdminLogs;
use Facade\Ignition\Middleware\AddLogs;
use Illuminate\Http\Request;

class AdminLogController extends Controller
{

    public function index(){
        $adminLogs = AdminLogs::all();

        return $adminLogs;

    }
    
}
