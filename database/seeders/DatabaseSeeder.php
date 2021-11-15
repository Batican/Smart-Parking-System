<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Admin;
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
            'password' => bcrypt(1234),
            'rfid_number' => '010101'
        ]);

        Admin::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt(1234)
        ]);
    }
}
