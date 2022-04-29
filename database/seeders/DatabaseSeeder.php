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
            'first_name' => 'dan',
            'last_name' => 'padilla',
            'email' => 'dan@gmail.com',
            'type' => 'Student',
            'vehicle' => 'Car',
            'password' => bcrypt(1234),
            'rfid_number' => '010101'
        ]);

        Department::create([
            'name'=>'College of Engineering and Architecture',
            'color'=>'orange',
            'abbreviation'=>'CEA'
        ]);

        Department::create([
            'name'=>'College of Management',
            'color'=>'yellow',
            'abbreviation'=>'COM'
        ]);

        Department::create([
            'name'=>'College of Education',
            'color'=>'blue',
            'abbreviation'=>'COE'
        ]);

        Admin::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt(1234),
            'is_super' => False,
        ]);

        Artisan::call('passport:install');
        Artisan::call('storage:link');
        Artisan::call('key:generate');
    }
}

