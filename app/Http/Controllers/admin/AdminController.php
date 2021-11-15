<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;

class AdminController extends Controller
{

    public function index()
    {
        $admin = Admin::all();

        return $admin;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required'
        ]);

        $admin = Admin::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> bcrypt($request->password)
        ]);

        return $admin;
    }

    public function show($id)
    {
        $admin = Admin::find($id);

        return $admin;
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required'
        ]);

        $admin = Admin::where('id', $id)
            ->update([
                'name'=> $request->name,
                'email'=> $request->email,
                'password'=> bcrypt($request->password)
            ]);

        return $admin;

    }

    public function destroy(Admin $admin)
    {

        $admin->delete();

        return $admin;
    }
}
