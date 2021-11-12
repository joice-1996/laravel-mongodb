<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date=date('Y-m-d');
        $time=date('H:i:s');
        $date=$date."T".$time;
        User::insert([
            'name'=>ucwords('admin'),
            'email'=>'admin@gmail.com',
            'password'=>Hash::make('admin'),
            'user_type'=>'admin',
            'status'=>1,
            'created'=>$date
        ]);
    }
}
