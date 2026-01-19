<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('user')->insert([
            'nama'      => 'Admin Adidas',
            'username'  => 'adminadidas',
            'password'  => Hash::make('adidasadmin'),
            'role'      => 'admin',
            'created_at'=> now(),
            'updated_at'=> now(),
        ]);
    }
}
