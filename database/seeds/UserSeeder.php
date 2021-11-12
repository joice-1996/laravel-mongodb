<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
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
//return $date;
     User::insert([
           ['name'=>ucwords('radhika'),
           'email'=>'radhika@gmail.com',
           'user_type'=>'user',
           'status'=>1,
           'created'=>$date],
           ['name'=>ucwords('mahima'),
           'email'=>'mahima@gmail.com',
           'user_type'=>'user',
           'status'=>1,
           'created'=>$date],
           ['name'=>ucwords('limi'),
           'email'=>'limi@gmail.com',
           'user_type'=>'user',
           'status'=>1,
           'created'=>$date],
           ['name'=>ucwords('kavya'),
           'email'=>'kavya@gmail.com',
           'user_type'=>'user',
           'status'=>1,
           'created'=>$date],
           ['name'=>ucwords('elizabeth'),
           'email'=>'elizabeth@gmail.com',
           'user_type'=>'user',
           'status'=>1,
           'created'=>$date],
           ['name'=>ucwords('sony'),
           'email'=>'sony@gmail.com',
           'user_type'=>'user',
           'status'=>1,
           'created'=>$date],
       ]);
    }
}
