<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class NodeMcuController extends Controller
{
    public function checkRfid(Request $request){
        
        $user = User::where('rfid_number', $request->rfid_number)->exists();
        if($user){
            return [
                "authorized"=>"Autorized User"
            ];
        }
    }
}
