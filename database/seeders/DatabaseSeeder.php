<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Department;
use Illuminate\Support\Facades\Artisan;

use function PHPSTORM_META\type;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'dan',
            'email' => 'dan@gmail.com',
            'type' => 'student',
            'password' => bcrypt(1234),
            'rfid_number' => '010101'
        ]);

        Department::create([
            'name'=>'College of Engineering and Technology',
            'color'=>'red',
            'abbreviation'=>'CET'
        ]);

        Admin::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt(1234)
        ]);

        Artisan::call('passport:install');
        Artisan::call('storage:link');
        Artisan::call('key:generate');
    }
}

