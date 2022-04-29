<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'first_name'     => $row['first_name'],
            'last_name'     => $row['last_name'],
            'type'     => $row['type'],
            'vehicle'     => $row['vehicle'],
            'email'    => $row['email'], 
            'rfid_number'    => $row['rfid_number'], 
            'password' => \Hash::make($row['password']),
        ]);
    }
}
