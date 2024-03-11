<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class setUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
                        'name'=>'M.Ataar',
                        'email'=>'ataar77@gmail.com',
                        'password'=>Hash::make('Ataar12345'),
                        'type'=>'admin',
               ]);
                 User::create([
                'name'=>'ali',
                'email'=>'ataar13@gmail.com',
                'password'=>Hash::make('Ataar12345'),
                'type'=>'admin',
       ]);
    }
}
